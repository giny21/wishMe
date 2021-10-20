<?php

namespace App\Entity\User;

use App\Entity\DoctrineEntity;
use App\Entity\Wish\Subscription\WishSubscription;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Repository\User\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Entity(repositoryClass: UserRepository::class)]
class User extends DoctrineEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Column(type: "string", length: 180, unique: true)]
    private ?string $email;

    #[Column(type: "json")]
    private array $roles = [];

    #[Column(type: "string")]
    private string $password;

    #[OneToMany(mappedBy: "user", targetEntity: WishlistSubscription::class)]
    private Collection $wishlistSubscriptions;

    #[OneToMany(mappedBy: "user", targetEntity: WishSubscription::class)]
    private Collection $wishSubscriptions;

    public function __construct()
    {
        parent::__construct();

        $this->wishlistSubscriptions = new ArrayCollection();
        $this->wishSubscriptions = new ArrayCollection();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /** @return string[] */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /** @return Collection<WishlistSubscription> */ 
    public function getWishlistSubscriptions() : Collection
    {
        return $this->wishlistSubscriptions;
    }

    public function setWishlistSubscriptions(Collection $wishlistSubscriptions) : self
    {
        $this->wishlistSubscriptions = $wishlistSubscriptions;

        return $this;
    }

    public function addWishlistSubscription(WishlistSubscription $wishlistSubscription) : void
    {
        $wishlistSubscription->setUser($this);
        $this->wishlistSubscriptions->add($wishlistSubscription);
    }

    public function removeWishlistSubscription(WishlistSubscription $wishlistSubscription) : void
    {
        $this->wishlistSubscriptions->removeElement($wishlistSubscription);
    }

    /** @return Collection<WishSubscription> */ 
    public function getWishSubscriptions() : Collection
    {
        return $this->wishSubscriptions;
    }

    public function setWishSubscriptions(Collection $wishSubscriptions) : self
    {
        $this->wishSubscriptions = $wishSubscriptions;

        return $this;
    }

    public function addWishSubscription(WishSubscription $wishSubscription) : void
    {
        $wishSubscription->setUser($this);
        $this->wishSubscriptions->add($wishSubscription);
    }

    public function removeWishSubscription(WishSubscription $wishSubscription) : void
    {
        $this->wishSubscriptions->removeElement($wishSubscription);
    }
}
