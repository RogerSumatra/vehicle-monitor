<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Heri Tarmiji',
            'email' => 'approverhead@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
            'region_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Budi Ronggolawe',
            'email' => 'approverbranch@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
            'region_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Mulyono Arang',
            'email' => 'approverminea@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
            'region_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Mulyono Bandung',
            'email' => 'approvermineb@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
            'region_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Mulyono Cangar',
            'email' => 'approverminec@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
            'region_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Mulyono Dusun',
            'email' => 'approvermined@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
            'region_id' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Mulyono Eagen',
            'email' => 'approverminee@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
            'region_id' => 7,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Mulyono Fathan',
            'email' => 'approverminef@example.com',
            'password' => Hash::make('password'),
            'role' => 'approver',
            'region_id' => 8,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
