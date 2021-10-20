<?php

namespace App\Model\Wishlist\Action\Subscription;

use App\Model\Action;

class CreateWishlistSubscription extends Action
{
    public function __construct(
        private string $userEmail,
        private int $role
    )
    {}

    public function getRole() : int
    {
        return $this->role;
    }

    public function getUserEmail() : string
    {
        return $this->userEmail;
    }
}