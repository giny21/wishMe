<?php

namespace App\Model\Wishlist\Action;

use App\Model\Action;

class SearchWishlist extends Action
{
    private ?string $name = null;

    private ?int $role = null;

    public function getName() : ?string
    {
        return $this->name;
    }

    public function getRole() : ?int
    {
        return $this->role;
    }
}