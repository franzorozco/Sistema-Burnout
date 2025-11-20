<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// --- AÑADE ESTA LÍNEA ---
use App\Http\Controllers\Api\QuestionnaireResponseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// --- AÑADE ESTA LÍNEA PARA EL TEST RÁPIDO ---
Route::post('/questionnaire-responses', [QuestionnaireResponseController::class, 'store']);
