<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()
            ->firstOrCreate(['email' => 'alice@mail.com'], [
                'name' => 'Alice',
                'email' => 'alice@mail.com',
                'password' => Hash::make('123456')
            ]);
        User::query()
            ->firstOrCreate(['email' => 'bob@mail.com'], [
                'name' => 'Bob',
                'email' => 'bob@mail.com',
                'password' => Hash::make('123456')
            ]);
    }
}
