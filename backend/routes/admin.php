<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\PostVoteController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RotationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\StateReportController;
use App\Http\Controllers\ChatbotAlertController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\StudentRotationController;
use App\Http\Controllers\QuestionnaireItemController;
use App\Http\Controllers\ChatbotInteractionController;
use App\Http\Controllers\QuestionnaireChoiceController;
use App\Http\Controllers\QuestionnaireResponseController;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::resource('users', UserController::class);
Route::resource('users', UserController::class);
Route::resource('permissions', PermissionController::class);
Route::resource('roles', RoleController::class);
Route::resource('student-profiles', StudentProfileController::class);
Route::resource('rotations', RotationController::class);
Route::resource('student-rotations', StudentRotationController::class);
Route::resource('questionnaires', QuestionnaireController::class);
Route::post('questionnaires/generate-code',[QuestionnaireController::class, 'generateCode'])
    ->name('questionnaires.generateCode');
Route::post('questionnaires/generate-version', [QuestionnaireController::class, 'generateVersion'])
    ->name('questionnaires.generateVersion');

Route::resource('questionnaire-items', QuestionnaireItemController::class);
Route::get('questionnaire/{id}/next-order', [QuestionnaireItemController::class, 'getNextOrder']);

Route::resource('questionnaire-choices', QuestionnaireChoiceController::class);
Route::resource('questionnaire-responses', QuestionnaireResponseController::class);
Route::resource('state-reports', StateReportController::class);
Route::resource('chatbot-interactions', ChatbotInteractionController::class);
Route::resource('chatbot-alerts', ChatbotAlertController::class);
Route::resource('professionals', ProfessionalController::class);
Route::resource('appointments', AppointmentController::class);
Route::resource('resources', ResourceController::class);
Route::resource('posts', PostController::class);
Route::resource('comments', CommentController::class);
Route::resource('post-votes', PostVoteController::class);
Route::resource('post-tags', PostTagController::class);
Route::resource('files', FileController::class);
Route::resource('notifications', NotificationController::class);
Route::resource('audit-logs', AuditLogController::class);