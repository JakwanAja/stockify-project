<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'       => 'Administrator',
                'email'      => 'admin@stockify.com',
                'password'   => Hash::make('admin123'),
                'role'       => 'Admin',
            ],
            [
                'name'       => 'Manajer Gudang',
                'email'      => 'manager@stockify.com',
                'password'   => Hash::make('12345678'),
                'role'       => 'Manajer Gudang',
            ],
            [
                'name'       => 'Staff Gudang',
                'email'      => 'staff@stockify.com',
                'password'   => Hash::make('12345678'),
                'role'       => 'Staff Gudang',
            ],
        ]);
    }
}