<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nombre' => 'Olguina',
            'apellidos' => 'Amaya',
            'fecha_nacimiento' => '2000-01-25',
            'genero' => 'femenino',
            'username' => 'olgamaya', 
            'rol' => 'administrador',            
            'email' => 'admin@fertirriego.com',
            'email_verified_at' => '2025-08-20', 
            'password' => Hash::make('Password1!')
        ]);
    }
}