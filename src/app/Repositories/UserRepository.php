<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function findByEmail(string $email)
    {
        $checkEmail = $this->user::where('email', $email)->exists();
        return $checkEmail;
    }

    public function save($data)
    {
        $results = $this->user::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);

        return $results;
    }

}
