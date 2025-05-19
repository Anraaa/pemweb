<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => 'super_admin',
            ]
        );
        $user->assignRole('super_admin');

        $user = User::firstOrCreate(
            ['email' => 'petugas1@demo.com'],
            [
                'name' => 'Petugas 1',
                'password' => bcrypt('password'),
                'role' => 'petugas',
            ]
        );
        $user->assignRole('petugas');

        $user = User::firstOrCreate(
            ['email' => 'petugas2@demo.com'],
            [
                'name' => 'Petugas 2',
                'password' => bcrypt('password'),
                'role' => 'petugas',
            ]
        );
        $user->assignRole('petugas');

    }
}
