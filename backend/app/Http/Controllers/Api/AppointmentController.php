<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        // Traemos todas las citas médicas y sus relaciones
        $appointments = Appointment::with(['studentProfile.user', 'professional.user'])
            ->orderBy('scheduled_at', 'desc')
            ->get();
            
        return response()->json(['data' => $appointments]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_profile_id' => 'required|exists:student_profiles,id',
            'professional_id' => 'required|exists:professionals,id',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            'student_profile_id' => $request->student_profile_id,
            'professional_id' => $request->professional_id,
            'scheduled_at' => date('Y-m-d H:i:s', strtotime($request->scheduled_at)),
            'duration_minutes' => $request->duration_minutes ?? 30,
            'status' => 'pendiente',
            'notes' => $request->notes,
            'created_by' => auth()->id() ?? 1,
        ]);

        // Cargar las relaciones para devolver la cita completa
        $appointment->load(['studentProfile.user', 'professional.user']);

        return response()->json(['message' => 'Cita agendada con éxito', 'data' => $appointment], 201);
    }
}
