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
        // Crear session_id si no existe
        if (!$request->session()->has('chat_session_id')) {
            $request->session()->put('chat_session_id', Str::uuid()->toString());
        }

        return view('chat');
    }

    public function ask(Request $request)
    {
        // Validar input
        $request->validate([
            'query' => 'required|string|max:500'
        ]);

        $query = $request->input('query');

        // Mantener la sesión del chat
        $sessionId = $request->session()->get('chat_session_id');
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            $request->session()->put('chat_session_id', $sessionId);
        }

        $userId = Auth::check() ? Auth::id() : null;

        // Solo enviamos la pregunta del usuario
        $fullQuery = $query;

        try {
            // Llamada al backend RAG
            $response = Http::timeout(60)->post('http://127.0.0.1:8000/ask', [
                'query' => $fullQuery,
                'session_id' => $sessionId  // para memoria futura por sesión
            ]);

            Log::info("RAG response:", $response->json() ?? ['raw' => $response->body()]);

            $data = $response->json();
            if (!is_array($data)) $data = [];

            $answer = $data['answer'] ?? 'No se recibió respuesta del servidor RAG.';

        } catch (\Exception $e) {
            $answer = "Error al conectar con RAG: " . $e->getMessage();
            $data = ['error' => $e->getMessage()];
        }

        // Guardar interacción en BD
        try {
            $insertData = [
                'user_id'           => $userId,
                'session_id'        => $sessionId,
                'input_text'        => $query,
                'input_metadata'    => json_encode([
                    'ip'         => $request->ip(),
                    'user_agent' => $request->header('User-Agent')
                ], JSON_UNESCAPED_UNICODE) ?: '{}', // fallback si falla json_encode

                'response_text'     => $answer,
                'response_metadata' => json_encode($data, JSON_UNESCAPED_UNICODE) ?: '{}',

                'intent'            => null,
                'sentiment'         => null,
                'detected_risk'     => false,
                'detected_keywords' => json_encode([], JSON_UNESCAPED_UNICODE),

                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            DB::table('chatbot_interactions')->insert($insertData);

            Log::info("INSERT OK ✔✔✔", $insertData);

        } catch (\Exception $e) {
            Log::error("ERROR INSERTANDO EN chatbot_interactions:", [
                'error' => $e->getMessage(),
                'data'  => $insertData ?? []
            ]);
        }


        return response()->json(['answer' => $answer]);
    }
}
