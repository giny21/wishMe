<?php

namespace App\Entity\Wish;

use App\Entity\DoctrineEntity;
use App\Entity\Wish\Field\WishField;
use App\Entity\Wish\Link\WishLink;
use App\Entity\Wish\Subscription\WishSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Repository\Wish\WishRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity(repositoryClass: WishRepository::class)]
class Wish extends DoctrineEntity
{
    #[ManyToOne(inversedBy: "wishes", targetEntity: Wishlist::class)]
    private Wishlist $wishlist;

    #[Column(type: "text")]
    private string $name;

    #[OneToMany(mappedBy: "wish", targetEntity: WishLink::class)]
    private Collection $links;
 
    #[OneToMany(mappedBy: "wish", targetEntity: WishField::class)]
    private Collection $fields;

    #[OneToMany(mappedBy: "wish", targetEntity: WishSubscription::class)]
    private Collection $subscriptions;

    public function __construct()
    {
        parent::__construct();

        $this->links = new ArrayCollection();
        $this->fields = new ArrayCollection();
        $this->subscriptions = new ArrayCollection();
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

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
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
}
