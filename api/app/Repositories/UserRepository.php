<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository {

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->select('id', 'name', 'email', 'password')->first();
    }
}
