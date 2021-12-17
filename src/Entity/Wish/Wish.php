<?php

namespace App\Entity\Wish;

use App\Entity\DoctrineEntity;
use App\Entity\User\User;
use App\Entity\Wish\Field\WishField;
use App\Entity\Wish\Link\WishLink;
use App\Entity\Wish\Subscription\WishSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Repository\Wish\WishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OrderBy;
use JMS\Serializer\Annotation\VirtualProperty;

#[Entity(repositoryClass: WishRepository::class)]
class Wish extends DoctrineEntity
{
    #[Column(type: "text")]
    private string $name;

    #[Column(type: "boolean")]
    private bool $important;

    #[Column(type: "boolean")]
    private bool $fulfilled;

    #[ManyToMany(inversedBy: "wishes", targetEntity: Wishlist::class)]
    private Collection $wishlists;

    #[OneToMany(mappedBy: "wish", targetEntity: WishLink::class)]
    private Collection $links;
 
    #[OneToMany(mappedBy: "wish", targetEntity: WishField::class), OrderBy(["important" => "DESC"])]
    private Collection $fields;

    #[OneToMany(mappedBy: "wish", targetEntity: WishSubscription::class)]
    private Collection $subscriptions;

    public function __construct()
    {
        parent::__construct();

        $this->wishlists = new ArrayCollection();

        $this->links = new ArrayCollection();
        $this->fields = new ArrayCollection();
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

    public function getImportant() : bool
    {
        return $this->important;
    }

    public function setImportant(bool $important) : self
    {
        $this->important = $important;

        return $this;
    }

    public function getFulfilled() : bool
    {
        return $this->fulfilled;
    }

    public function setFulfilled(bool $fulfilled) : self
    {
        $this->fulfilled = $fulfilled;

        return $this;
    }

    /** @return Collection<Wishlist> */
    public function getWishlists() : Collection
    {
        return $this->wishlists;
    }

    public function setWishlists(Collection $wishlists) : self
    {
        $this->wishlists = $wishlists;

        return $this;
    }

    public function addWishlist(Wishlist $wishlist) : void
    {
        $this->wishlists->add($wishlist);
    }

    public function removeWishlist(Wishlist $wishlist) : void
    {
        $this->wishlists->removeElement($wishlist);
    }

    /** @return Collection<WishLink> */
    public function getLinks() : Collection
    {
        return $this->links;
    }

    public function setLinks(Collection $links) : self
    {
        $this->links = $links;

        return $this;
    }

    public function addLink(WishLink $wishLink) : void
    {
        $wishLink->setWish($this);
        $this->links->add($wishLink);
    }

    public function removeLink(WishLink $wishLink) : void
    {
        $this->links->removeElement($wishLink);
    }

    /** @return Collection<WishField> */
    public function getFields() : Collection
    {
        return $this->fields;
    }

    public function setFields(Collection $fields) : self
    {
        $this->fields = $fields;

        return $this;
    }

    public function addField(WishField $wishField) : void
    {
        $wishField->setWish($this);
        $this->fields->add($wishField);
    }

    public function removeField(WishField $wishField) : void
    {
        $this->fields->removeElement($wishField);
    }

    /** @return Collection<WishSubscription> */
    public function getSubscriptions() : Collection
    {
        return $this->subscriptions;
    }

    public function setSubscriptions(Collection $subscriptions) : self
    {
        $this->subscriptions = $subscriptions;

        return $this;
    }

    public function addSubscription(WishSubscription $wishSubscription) : void
    {
        $wishSubscription->setWish($this);
        $this->subscriptions->add($wishSubscription);
    }

    public function removeSubscription(WishSubscription $wishSubscription) : void
    {
        $this->subscriptions->removeElement($wishSubscription);
    }

    public function getSubscribtion(User $user) : WishSubscription|bool
    {
        return $this
            ->getSubscriptions()
            ->filter(
                fn(WishSubscription $wishSubscription) => $wishSubscription->getUser() === $user
            )
            ->first();
    }

    public function isOwner(User $user) : bool
    {
        foreach($this->getWishlists() as $wishlist){
            if($wishlist->isOwner($user))
                return true;
        }

        return $this->wishlists->count() === 0;
    }
}
