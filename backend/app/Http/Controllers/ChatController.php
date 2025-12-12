<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;

use App\Models\ChatMessage;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        // Crear o recuperar session_id
        if (!$request->session()->has('chat_session_id')) {
            $request->session()->put('chat_session_id', Str::uuid()->toString());
        }

        return view('chat');
    }

    // Listar chats del usuario
    public function list()
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json(['chats' => []]);
        }

        // Traer todos los session_id del usuario
        $chats = DB::table('chatbot_interactions')
            ->where('user_id', $userId)
            ->select('session_id', DB::raw('MAX(created_at) as last_message'))
            ->groupBy('session_id')
            ->orderByDesc('last_message')
            ->get();

        // Devolver como JSON
        return response()->json([
            'chats' => $chats->map(function($c) {
                return [
                    'session_id' => $c->session_id,
                    'last_message' => $c->last_message,
                ];
            })
        ]);
    }

    // Cargar mensajes de un chat específico
    public function load($sessionId)
    {
        $userId = Auth::id();

        $messages = DB::table('chatbot_interactions')
            ->where('user_id', $userId)
            ->where('session_id', $sessionId)
            ->orderBy('created_at')
            ->get();

        $chatMessages = [];

        foreach ($messages as $m) {
            if ($m->input_text) {
                $chatMessages[] = ['text' => $m->input_text, 'sender' => 'user'];
            }
            if ($m->response_text) {
                $chatMessages[] = ['text' => $m->response_text, 'sender' => 'bot'];
            }
        }

        return response()->json(['messages' => $chatMessages]);

    }

    public function new(Request $request)
    {
        $sessionId = Str::uuid()->toString();
        $request->session()->put('chat_session_id', $sessionId);

        // Crear registro vacío en DB
        if (Auth::check()) {
            DB::table('chatbot_interactions')->insert([
                'user_id' => Auth::id(),
                'session_id' => $sessionId,
                'created_at' => now()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Nueva conversación iniciada.',
            'session_id' => $sessionId
        ]);
    }




    public function ask(Request $request)
    {
        try {
            $request->validate([
                'query' => 'required|string|max:500'
            ]);

            $query = $request->input('query');

            // Obtener session_id del chat
            $sessionId = $request->session()->get('chat_session_id', Str::uuid()->toString());
            $request->session()->put('chat_session_id', $sessionId);

            // Obtener usuario si está logueado
            $userId = Auth::check() ? Auth::id() : null;

            // ===============================
            //   Llamada al Servicio FastAPI
            // ===============================
            try {
                $response = Http::timeout(300)
                    ->retry(3, 2000)
                    ->post('https://9c8ebdec3c6a.ngrok-free.app/ask', [
                        'query' => $query,
                        'session_id' => $sessionId,
                        'user_id' => $userId
                    ]);

                $raw = $response->body();

                try {
                    $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    Log::error("JSON decode error:", [
                        'error' => $e->getMessage(),
                        'raw' => $raw
                    ]);

                    $data = [
                        'answer' => "Hubo un error interpretando la respuesta.",
                        'error' => $e->getMessage()
                    ];
                }

                $answer = $data['answer'] ?? "No se recibió respuesta del servidor.";
                $answer = mb_convert_encoding($answer, 'UTF-8', 'UTF-8');

            } catch (\Exception $e) {
                Log::error("Error al llamar a FastAPI:", ['message' => $e->getMessage()]);
                return response()->json([
                    'success' => false,
                    'answer' => "Parece que mi servidor está tardando. ¿Puedes intentar de nuevo?",
                    'error'  => $e->getMessage()
                ], 200);
            }

            return response()->json([
                'success' => true,
                'answer'  => $answer
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error inesperado en ChatController:", [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'answer'  => "Ocurrió un error inesperado, pero ya lo estoy revisando.",
                'error'   => $e->getMessage()
            ], 200);
        }
    }
}
