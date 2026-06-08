<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@burnout.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password123'),
            ]
        );
        
        User::updateOrCreate(
            ['email' => 'estudiante@burnout.com'],
            [
                'name' => 'Estudiante Prueba',
                'password' => Hash::make('password123'),
            ]
        );
    }
}
