<?php

namespace App\Entity\User;

use App\Entity\DoctrineEntity;
use App\Entity\User\User;
use App\Repository\User\UserTokenRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

#[Entity(repositoryClass: UserTokenRepository::class)]
class UserToken extends DoctrineEntity
{
    #[ManyToOne(targetEntity: User::class)]
    private User $user;

    #[Column(type: "string")]
    private string $token;
    
    public function getUser() : User
    {
        return $this->user;
    }

    public function setUser(User $user) : self
    {
        $this->user = $user;

        return $this;
    }

    public function getToken() : string
    {
        return $this->token;
    }

    public function setToken(string $token) : self
    {
        $this->token = $token;

        return $this;
    }
}