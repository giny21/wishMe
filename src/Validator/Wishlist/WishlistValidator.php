<?php

namespace App\Validator\Wishlist;

use App\Exception\InvalidActionDataExcepiton;
use App\Model\Action;
use App\Model\Wishlist\Action\CreateWishlist;
use App\Model\Wishlist\Action\EditWishlist;
use App\Validator\Validator;

class WishlistValidator extends Validator
{
    public function validateEdit(EditWishlist $action) : void
    {
        $violations = parent::validate($action);
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }

    public function validateCreate(CreateWishlist $action) : void
    {
        $violations = parent::validate($action);
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }
}