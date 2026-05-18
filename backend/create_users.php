<?php

use App\Models\User;
use App\Models\Professional;
use Illuminate\Support\Facades\Hash;

$doctor = User::firstOrCreate(
    ['email' => 'doctor@uab.edu.bo'],
    [
        'name' => 'Dr. Juan Perez',
        'password' => Hash::make('password123'),
        'is_active' => true
    ]
);

Professional::firstOrCreate(
    ['user_id' => $doctor->id],
    [
        'specialty' => 'Psiquiatría',
        'years_experience' => 5,
        'hourly_rate' => 150
    ]
);

User::firstOrCreate(
    ['email' => 'admin@uab.edu.bo'],
    [
        'name' => 'Administrador General',
        'password' => Hash::make('password123'),
        'is_active' => true
    ]
);

echo "Usuarios creados correctamente.\n";
