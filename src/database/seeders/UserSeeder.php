<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@mail.com',
            'password' => '123456'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Bob',
            'email' => 'bob@mail.com',
            'password' => '123456'
        ]);
    }
}
