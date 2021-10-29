<?php

namespace App\Model\Wishlist\Action\Subscription;

use App\Model\Action;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateWishlistSubscription extends Action
{
    #[Email()]
    private string $userEmail;

    #[NotBlank()]
    private int $role;

    public function getRole() : int
    {
        return $this->role;
    }

    public function getUserEmail() : string
    {
        return $this->userEmail;
    }
}