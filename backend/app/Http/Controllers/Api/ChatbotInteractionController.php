<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatbotInteraction;

class ChatbotInteractionController extends Controller
{
    public function index()
    {
        // Traemos las interacciones con el usuario asociado, ordenadas de más reciente a más antigua
        $interactions = ChatbotInteraction::with('user:id,name,email')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return response()->json($interactions);
    }
}
