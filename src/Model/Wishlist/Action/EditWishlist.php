<?php

namespace App\Model\Wishlist\Action;

use App\Model\Action;

class EditWishlist extends CreateWishlist
{
    private ?bool $publicAvailable = null;

    public function getPublicAvailable() : ?bool
    {
        return $this->publicAvailable;
    }
}