<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Caique',
            'email' => 'caique@teste.com',
            'password' => 'password',
        ])->tokens()->create([
            'name' => 'api',
            'token' => hash('sha256', 'N7fp6GTjO9CJD1QIhqv0Ty1ZZbJeS3tFIbToFJZQ'),
            'abilities' => ['api-access'],
        ]);

        User::create([
            'name' => 'João',
            'email' => 'joao@teste.com',
            'password' => 'password',
        ])->tokens()->create([
            'name' => 'api',
            'token' => hash('sha256', 'N8fp6GTjO9CJD1QIhqv0Ty1ZZbJeS3tFIbToFJZQ'),
            'abilities' => ['api-access'],
        ]);
    }
}
