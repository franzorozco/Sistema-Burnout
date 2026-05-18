<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// --- AÑADE ESTA LÍNEA ---
use App\Http\Controllers\Api\QuestionnaireResponseController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatbotInteractionController;
use App\Http\Controllers\Api\ProfessionalController;
use App\Http\Controllers\Api\ChatbotAlertController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ResourceController;

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
    
    // CRUDs protegidos
    Route::get('/chatbot-interactions', [ChatbotInteractionController::class, 'index']);
    Route::get('/professionals', [ProfessionalController::class, 'index']);
    Route::get('/alerts', [ChatbotAlertController::class, 'index']);
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    
    Route::get('/resources', [ResourceController::class, 'index']);
    Route::post('/resources', [ResourceController::class, 'store']);
});

// --- AÑADE ESTA LÍNEA PARA EL TEST RÁPIDO ---
Route::post('/questionnaire-responses', [QuestionnaireResponseController::class, 'store']);
