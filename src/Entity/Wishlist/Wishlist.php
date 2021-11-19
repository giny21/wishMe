<?php

namespace App\Entity\Wishlist;

use App\Entity\DoctrineEntity;
use App\Entity\User\User;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Repository\Wishlist\WishlistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;

#[Entity(repositoryClass: WishlistRepository::class)]
class Wishlist extends DoctrineEntity
{
    #[Column(type: "text")]
    private string $name;

    #[Column(type: "boolean")]
    private bool $publicAvailable;

    #[ManyToMany(mappedBy: "wishlists", targetEntity: Wish::class), OrderBy(["important" => "DESC", "id" => "DESC"])]
    private Collection $wishes;

    #[OneToMany(mappedBy: "wishlist", targetEntity: WishlistSubscription::class)]
    private Collection $subscriptions;

    public function __construct()
    {
        parent::__construct();

        $this->wishes = new ArrayCollection();

        $this->subscriptions = new ArrayCollection();
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

    public function getPublicAvailable() : bool
    {
        return $this->publicAvailable;
    }

    public function setPublicAvailable(bool $publicAvailable) : self
    {
        $this->publicAvailable = $publicAvailable;

        return $this;
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
        $this->wishes->add($wish);
    }

    public function removeWish(Wish $wish) : void
    {
        $this->wishes->removeElement($wish);
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

    public function getSubscription(User $user) : WishlistSubscription|bool
    {
        return $this
            ->getSubscriptions()
            ->filter(
                fn(WishlistSubscription $wishlistSubscription) =>
                    $wishlistSubscription->getUser() === $user
            )
            ->first();
    }

    /** @return Collection<WishlistSubscription> */
    public function getOwnerSubscriptions() : Collection
    {
        return $this
            ->getSubscriptions()
            ->filter(
                fn(WishlistSubscription $wishlistSubscription) =>
                    $wishlistSubscription->getRole() === WishlistSubscription::ROLE_OWNER
            );
    }

    public function isOwner(User $user) : bool
    {
        foreach($this->getSubscriptions() as $subscription){
            if($subscription->getUser() === $user && $subscription->getRole() === WishlistSubscription::ROLE_OWNER)
                return true;
        }

        return false;
    }
}
