<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatbotAlert;

class ChatbotAlertController extends Controller
{
    public function index()
    {
        // Traemos todas las alertas con la información del estudiante (mediante studentProfile)
        $alerts = ChatbotAlert::with(['studentProfile.user', 'chatbotInteraction'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($alert) {
                // Formateamos para que el Frontend lo consuma sin cambiar mucho código
                $alert->user = $alert->studentProfile ? $alert->studentProfile->user : null;
                $alert->risk_level = $alert->severity;
                $alert->description = $alert->alert_type; // 'riesgo_emocional'
                return $alert;
            });
            
        return response()->json(['data' => $alerts]);
    }
}
