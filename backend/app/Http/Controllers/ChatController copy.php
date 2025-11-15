<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    // Mostrar la página del chat
    public function index()
    {
        return view('chat');
    }

    // Procesar la pregunta del usuario
    public function ask(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:500'
        ]);

        $query = $request->input('query');

        // Definir la personalidad del chat
        $systemPrompt =     "Eres un asistente virtual Laiso,especializado en medicina preventiva y psicología, enfocado en la prevención del burnout. 
                            Responde siempre de manera empática, calmada y profesional. 
                            Ofrece recomendaciones prácticas y breves sobre manejo del estrés y autocuidado. 
                            Evita diagnósticos médicos específicos; en su lugar, da sugerencias preventivas y motivación positiva.
                            Habla de forma clara, cercana y respetuosa.";

        // Combinar la personalidad con la pregunta real
        $fullQuery = $systemPrompt . "\nPregunta del usuario: " . $query;

        try {
            // Enviar la consulta al servidor RAG (FastAPI)
            $response = Http::timeout(60)->post('http://localhost:8000/ask', [
                'query' => $fullQuery
            ]);

            $data = $response->json();

            // Obtener la respuesta del RAG o mensaje por defecto
            $answer = $data['answer'] ?? 'No se recibió respuesta del servidor RAG.';

        } catch (\Exception $e) {
            $answer = "Error al conectar con RAG: " . $e->getMessage();
        }

        // Devolver JSON para chat en tiempo real
        return response()->json(['answer' => $answer]);
    }
}
