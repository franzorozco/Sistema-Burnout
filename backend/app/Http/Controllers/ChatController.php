<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
                    ->post('https://e39feec26ff1.ngrok-free.app/ask', [
                        'query' => $query,
                        'session_id' => $sessionId,
                        'user_id' => $userId // opcional si quieres usarlo
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
