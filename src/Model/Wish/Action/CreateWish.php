<?php

namespace App\Model\Wish\Action;

use App\Model\Action;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\Wishlist\Wishlist;
use Symfony\Component\Validator\Constraints\Length;

class CreateWish extends Action
{
    #[NotBlank(), Length(max: 40)]
    protected string $name;

    protected array $wishlists = [];

    public function getName() : string
    {
        return $this->name;
    }

    /** @return Wishlist[] */
    public function getWishlists() : array
    {
        return $this->wishlists;
    }
}