<?php

namespace App\Model\Wishlist\Action;

use App\Model\Action;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateWishlist extends Action
{
    #[NotBlank(), Length(max: 40)]
    protected string $name;

    public function getName() : string
    {
        return $this->name;
    }
}