<?php

namespace App\Entity\Wishlist;

use App\Entity\DoctrineEntity;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Repository\Wishlist\WishlistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity(repositoryClass: WishlistRepository::class)]
class Wishlist extends DoctrineEntity
{
    #[Column(type: "text")]
    private string $name;

    #[OneToMany(mappedBy: "wishlist", targetEntity: WishlistSubscription::class)]
    private Collection $subscriptions;

    #[OneToMany(mappedBy: "wishlist", targetEntity: WishlistSubscription::class)]
    private Collection $wishes;

    public function __construct()
    {
        parent::__construct();

        $this->subscriptions = new ArrayCollection();
        $this->wishes = new ArrayCollection();
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /** @return Collection<WishlistSubscription> */
    public function getSubscriptions() : Collection
    {
        return $this->subscriptions;
    }

    public function setSubscriptions(Collection $subscriptions) : self
    {
        $this->subscriptions = $subscriptions;

        return $this;
    }

    public function addSubscription(WishlistSubscription $wishlistSubscription) : void
    {
        $wishlistSubscription->setWishlist($this);
        $this->subscriptions->add($wishlistSubscription);
    }

    public function removeSubscription(WishlistSubscription $wishlistSubscription) : void
    {
        $this->subscriptions->removeElement($wishlistSubscription);
    }

    /** @return Collection<Wish> */
    public function getWishes() : Collection
    {
        return $this->wishes;
    }

    public function setWishes(Collection $wishes) : self
    {
        $this->wishes = $wishes;

        return $this;
    }

    public function addWish(Wish $wish) : void
    {
        $wish->setWishlist($this);
        $this->wishes->add($wish);
    }

    public function removeWish(Wish $wish) : void
    {
        $this->wishes->removeElement($wish);
    }
}
