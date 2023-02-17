<?php

namespace App\Service;

use App\Entity\User;
use App\Security\TokenGenerator;
use Exception;

class UserService
{
    /**
     * @throws Exception
     */
    public static function createUser(string $email, string $password) : User
    {
        $apiToken = TokenGenerator::generate();
        return (new User())
            ->setEmail($email)
            ->setPassword($password)
            ->setRoles([User::API_ROLE])
            ->setApiToken($apiToken);
    }
}
