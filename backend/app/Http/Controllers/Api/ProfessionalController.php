<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Professional;
use App\Models\User;

class ProfessionalController extends Controller
{
    public function index()
    {
        // Traemos a los profesionales con sus datos de usuario
        $professionals = Professional::with('user:id,name,email,is_active')->get();
        return response()->json(['data' => $professionals]);
    }
}
