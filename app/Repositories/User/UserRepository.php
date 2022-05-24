<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param string $email
     * @return \App\Models\User|null
     */
    public function findByEmail(string $email): User|null
    {
        return User::whereEmail($email)->first();
    }

}
