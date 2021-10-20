<?php

namespace App\Model\Wishlist\Action;

use App\Model\Action;

class CreateWishlist extends Action
{
    public function __construct(
        private string $name
    )
    {}

    public function getName() : string
    {
        return $this->name;
    }
}