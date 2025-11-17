<?php

namespace App\HttpControllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireResponse; // Importa el modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Para ver errores

class QuestionnaireResponseController extends Controller
{
    /**
     * Almacena una nueva respuesta de cuestionario en la base de datos.
     * CADA LLAMADA A ESTA FUNCIÓN CREA UN NUEVO REGISTRO.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos que llegan del frontend
        $validator = Validator::make($request->all(), [
            // ESTA ES LA VALIDACIÓN MÁS IMPORTANTE
            // Comprueba que en tu tabla 'questionnaires' exista una fila con id = 1
            'questionnaire_id' => 'required|integer|exists:questionnaires,id',

            'student_profile_id' => 'nullable|integer|exists:student_profiles,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'summary_score' => 'required|numeric',

            // 'raw' debe ser un objeto/array JSON
            'raw' => 'required|array',
        ]);

        // Si la validación falla, devuelve un error 422
        if ($validator->fails()) {
            // Escribe el error en 'storage/logs/laravel.log' para que puedas ver qué falló
            Log::error('Error de validación de Test Rápido: ', $validator->errors()->toArray());
            return response()->json($validator->errors(), 422);
        }

        // 2. Crear el registro en la Base de Datos
        // ::create() SIEMPRE crea una nueva fila. Nunca reemplaza.
        try {
            $response = QuestionnaireResponse::create($request->all());

            // 3. Devolver una respuesta exitosa
            return response()->json($response, 201);

        } catch (\Exception $e) {
            // Captura cualquier error de la base de datos
            Log::error('Error al guardar Test Rápido: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al guardar la respuesta en la base de datos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
