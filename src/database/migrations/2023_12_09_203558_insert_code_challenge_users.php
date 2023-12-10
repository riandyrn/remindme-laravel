<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Code challenge users.
     * 
     * @var array
     */
    private $users = [
        [
            'name' => 'Alice',
            'email' => 'alice@mail.com',
            'password' => '123456',
        ],
        [
            'name' => 'Bob',
            'email' => 'bob@mail.com',
            'password' => '123456',
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->users as $i => $user) {
            $this->users[$i]['password'] = bcrypt($user['password']);
        }
        DB::table('users')->insert($this->users);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $emails = Arr::pluck($this->users, 'email');
        DB::table('users')->select('id')->whereIn('email', $emails)->delete();
    }
};
