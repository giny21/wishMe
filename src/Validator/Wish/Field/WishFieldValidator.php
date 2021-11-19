<?php

namespace App\Validator\Wish\Field;

use App\Exception\InvalidActionDataExcepiton;
use App\Model\Wish\Action\Field\CreateWishField;
use App\Validator\Validator;

class WishFieldValidator extends Validator
{
    public function validateCreate(CreateWishField $action) : void
    {
        $violations = parent::validate($action);
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }
}