<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Alice',
                'email' => 'alice@mail.com',
                'password' => Hash::make('123456'),
            ],
            [
                'name' => 'Bob',
                'email' => 'bob@mail.com',
                'password' => Hash::make('123456'),
            ],
        ]);
    }
}