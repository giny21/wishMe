<?php

namespace App\Entity\Wishlist\Subscription;

use App\Entity\DoctrineEntity;
use App\Entity\User\User;
use App\Entity\Wishlist\Wishlist;
use App\Repository\Wishlist\Subscription\WishlistSubscriptionRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: WishlistSubscriptionRepository::class)]
class WishlistSubscription extends DoctrineEntity
{
    public CONST ROLE_OWNER = 1;
    public CONST ROLE_SUBSCRIBER = 2;

    #[ManyToOne(inversedBy: "wishlistSubscriptions", targetEntity: User::class)]
    private User $user;

    #[ManyToOne(inversedBy: "subscriptions", targetEntity: Wishlist::class)]
    private Wishlist $wishlist;

    #[Column(type: "integer")]
    private int $role;

    #[Column(type: "boolean")]
    private bool $favorite;

    public function getUser() : User
    {
        return $this->user;
    }

    public function setUser(User $user) : self
    {
        $this->user = $user;

        return $this;
    }

    public function getWishlist() : Wishlist
    {
        return $this->wishlist;
    }

    public function setWishlist(Wishlist $wishlist) : self
    {
        $this->wishlist = $wishlist;

        return $this;
    }

    public function getRole() : int
    {
        return $this->role;
    }

    public function setRole(int $role) : self
    {
        $this->role = $role;

        return $this;
    }

    public function getFavorite() : bool
    {
        return $this->favorite;
    }

    public function setFavorite(bool $favorite) : self
    {
        $this->favorite = $favorite;

        return $this;
    }
}
