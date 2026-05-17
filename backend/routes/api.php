<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// --- AÑADE ESTA LÍNEA ---
use App\Http\Controllers\Api\QuestionnaireResponseController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// --- RUTAS DE AUTENTICACIÓN ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Rutas protegidas que haremos luego (Chatbot interactions, etc)
});

// --- AÑADE ESTA LÍNEA PARA EL TEST RÁPIDO ---
Route::post('/questionnaire-responses', [QuestionnaireResponseController::class, 'store']);
