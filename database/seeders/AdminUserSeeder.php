<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'admin@bem.local'],
            [
                'password' => Hash::make('Admin12345!'),
                'role' => 'admin',
                'is_verified' => true,
                'ktm_path' => null,
            ]
        );
    }
}
