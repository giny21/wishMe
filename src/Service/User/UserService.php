<?php

namespace App\Service\User;

use App\Entity\User\User;
use App\Model\User\Action\CreateUser;
use App\Model\User\Action\SignInUser;
use App\Repository\User\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserService
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private UserRepository $userRepository
    )
    {}

    public function create(CreateUser $createUser) : User
    {
        $user = $this->userRepository->create(
            $createUser->getEmail(),
            $createUser->getPassword()
        );

        return $user;
    }

    public function signIn(SignInUser $signInUser) : User
    {
        $user = $this->userRepository->findOneByEmail($signInUser->getEmail());
        
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        return $user;
    }

    public function signOut() : void
    {
        $this->tokenStorage->setToken(null);
    }
}