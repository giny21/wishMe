<?php

namespace App\Service\User;

use App\Repository\User\UserRepository;

class UserService
{
    public function __construct(
        UserRepository $userRepository
    )
    {}
}