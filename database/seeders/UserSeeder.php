<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Gantilah dengan password yang aman
            'role' => 'admin',
        ]);

        // Operator user
        User::create([
            'name' => 'Operator User',
            'email' => 'operator@example.com',
            'password' => Hash::make('password'), // Gantilah dengan password yang aman
            'role' => 'operator',
        ]);

        // Owner user
        User::create([
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'), // Gantilah dengan password yang aman
            'role' => 'owner',
        ]);

        // Client user
        User::create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => Hash::make('password'), // Gantilah dengan password yang aman
            'role' => 'client',
        ]);
    }
}
