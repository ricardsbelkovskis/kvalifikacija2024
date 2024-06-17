<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'company_name' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'account_status' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}