<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'pseudo' => 'administrateur',
            'password' => Hash::make('12345678'),
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role_id' => 2
        ]);
        User::create([
            'pseudo' => 'user',
            'password' => Hash::make('12345678'),
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role_id' => 1
        ]);

        User::factory(8)->create();
    }
}
