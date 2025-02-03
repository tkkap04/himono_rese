<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '一般ユーザー',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            /* 'email_verified_at' => now(),　*/
        ]);

        User::create([
            'name' => '管理者ユーザー',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            /* 'email_verified_at' => now(),　*/
        ]);

        User::create([
            'name' => '店舗ユーザー',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            /* 'email_verified_at' => now(),　*/
        ]);
    }
}
