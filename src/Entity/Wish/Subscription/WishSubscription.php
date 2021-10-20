<?php

namespace App\Entity\Wish\Subscription;

use App\Entity\DoctrineEntity;
use App\Entity\User\User;
use App\Entity\Wish\Wish;
use App\Repository\Wish\Subscription\WishSubscriptionRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: WishSubscriptionRepository::class)]
class WishSubscription extends DoctrineEntity
{
    #[ManyToOne(inversedBy: "wishSubscriptions", targetEntity: User::class)]
    private User $user;

    #[ManyToOne(inversedBy: "subscriptions", targetEntity: Wish::class)]
    private Wish $wish;

    public function getUser() : User
    {
        return $this->user;
    }

    public function setUser(User $user) : self
    {
        $this->user = $user;

        return $this;
    }

    public function getWish() : Wish
    {
        return $this->wish;
    }

    public function setWish(Wish $wish) : self
    {
        $this->wish = $wish;

        return $this;
    }
}
