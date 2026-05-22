<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cria o admin inicial do sistema caso ele ainda não exista
        // Credenciais: admin@userhub.com / password
        // Lembre de trocar a senha em produção!
        User::firstOrCreate(
            ['email' => 'admin@userhub.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );
    }
}
