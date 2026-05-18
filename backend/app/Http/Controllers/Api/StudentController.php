<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentProfile;

class StudentController extends Controller
{
    public function index()
    {
        // Traemos todos los perfiles de estudiantes con su usuario
        $students = StudentProfile::with('user')->get();
            
        return response()->json(['data' => $students]);
    }
}
