<?php

namespace Database\Seeders;

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
        // Menyimpan data user ke database menggunakan model
        User::create([
            'name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => null,
            'password' => Hash::make('12345678'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Menambahkan user lain jika diperlukan
        // User::create([
        //     'name' => 'Nama Lengkap',
        //     'last_name' => 'Nama Belakang',
        //     'email' => 'email@example.com',
        //     'email_verified_at' => now(),
        //     'password' => Hash::make('12345678'),
        //     'remember_token' => Str::random(10),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    }
}
