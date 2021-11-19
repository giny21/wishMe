<?php

namespace App\Model\Wishlist\Action\Subscription;

use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Model\Action;
use Symfony\Component\Validator\Constraints\Email;

class CreateWishlistSubscription extends Action
{
    #[Email()]
    private string $userEmail;

    private int $role = WishlistSubscription::ROLE_SUBSCRIBER;

    public function getUserEmail() : string
    {
        return $this->userEmail;
    }

    public function getRole() : int
    {
        return $this->role;
    }
}