<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), 
        ]);
    }
}