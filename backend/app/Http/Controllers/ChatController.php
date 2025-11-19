<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index(Request $request)
    {
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

            $sessionId = $request->session()->get('chat_session_id', Str::uuid()->toString());
            $request->session()->put('chat_session_id', $sessionId);

            $userId = Auth::check() ? Auth::id() : null;

            // Llamada a FastAPI
            try {
                $response = Http::timeout(300)
                    ->retry(3, 2000)
                    ->post('http://127.0.0.1:8000/ask', [
                        'query' => $query,
                        'session_id' => $sessionId,
                    ]);

                $raw = $response->body();

                try {
                    $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
                } catch (\JsonException $e) {
                    Log::error("JSON decode error:", ['error' => $e->getMessage(), 'raw' => $raw]);
                    $data = ['error' => 'Invalid JSON', 'raw' => $raw];
                }

                $answer = $data['answer'] ?? "No se recibió respuesta del RAG.";
                $answer = mb_convert_encoding($answer, 'UTF-8', 'UTF-8');

            } catch (\Exception $e) {
                Log::error("Error al llamar a FastAPI:", ['message' => $e->getMessage()]);
                $answer = "Estoy procesando tu respuesta… dame unos segundos.";
                $data = ['error' => $e->getMessage()];
            }

            // Guardar en la BD solo las columnas permitidas
            $input_metadata = json_encode([
                'ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent')
            ], JSON_UNESCAPED_UNICODE);

            $response_metadata = json_encode(
                $data,
                JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR
            ) ?: '{}';

            try {
                DB::table('chatbot_interactions')->insert([
                    'user_id'           => $userId,
                    'session_id'        => $sessionId,
                    'input_text'        => $query,
                    'input_metadata'    => $input_metadata,
                    'response_text'     => $answer,
                    'response_metadata' => $response_metadata,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            } catch (\Exception $e) {
                Log::error("Error al insertar en BD:", ['message' => $e->getMessage()]);
            }

            return response()->json([
                'success' => true,
                'answer'  => $answer
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error inesperado en controlador ChatController:", ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'answer'  => "Ocurrió un error inesperado.",
                'error'   => $e->getMessage()
            ], 200);
        }
    }
}
 