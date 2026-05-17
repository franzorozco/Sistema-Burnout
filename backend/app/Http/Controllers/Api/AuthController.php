<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudentProfile;
use App\Models\Professional;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'paternal_surname' => 'nullable|string|max:255',
            'maternal_surname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:student,professional,admin',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'paternal_surname' => $request->paternal_surname,
                'maternal_surname' => $request->maternal_surname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            // Assign profile based on role
            if ($request->role === 'student') {
                StudentProfile::create([
                    'user_id' => $user->id,
                    'semester' => $request->semester ?? 1,
                    'university' => $request->university ?? 'UAB',
                ]);
            } else if ($request->role === 'professional') {
                Professional::create([
                    'user_id' => $user->id,
                    'specialty' => $request->specialty ?? 'Psicología General',
                    'years_experience' => $request->years_experience ?? 1,
                    'hourly_rate' => $request->hourly_rate ?? 0.00,
                ]);
            }

            // Here we should assign Spatie roles if they are set up, but we'll keep it simple for now.

            DB::commit();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
                'role' => $request->role
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar usuario', 'error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'message' => 'Cuenta desactivada'
            ], 403);
        }

        // Determinar el rol
        $role = 'admin'; // por defecto
        if (StudentProfile::where('user_id', $user->id)->exists()) {
            $role = 'student';
        } else if (Professional::where('user_id', $user->id)->exists()) {
            $role = 'professional';
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'role' => $role
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada correctamente'
        ]);
    }
}
