<?php

namespace App\Validator\Wish\Link;

use App\Exception\InvalidActionDataExcepiton;
use App\Model\Wish\Action\Link\CreateWishLink;
use App\Validator\Validator;

class WishLinkValidator extends Validator
{
    public function validateCreate(CreateWishLink $action) : void
    {
        $violations = parent::validate($action);
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }
}