<?php

namespace App\Model\Wishlist\Action;

use App\Model\Action;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateWishlist extends Action
{
    #[NotBlank()]
    private string $name;

    public function getName() : string
    {
        return $this->name;
    }
}