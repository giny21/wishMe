<?php

namespace App\Service\User;

use App\Entity\User\User;
use App\Entity\User\UserToken;
use App\Model\User\Action\CreateUser;
use App\Model\User\Action\SignInUser;
use App\Repository\User\UserRepository;
use App\Repository\User\UserTokenRepository;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserTokenRepository $userTokenRepository
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
        
        $this->userTokenRepository->create(
            $user, 
            $this->generateToken(16)
        );

        return $user;
    }

    public function signOut(User $user) : void
    {
        foreach($this->userTokenRepository->findByUser($user) as $token)
            $this->userTokenRepository->remove($token);
    }
    
    private function generateToken($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        
        return $randomString;
    }
}