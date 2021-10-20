<?php

namespace App\Model\Wish\Action\Field;

use App\Model\Action;

class CreateWishField extends Action
{
    public function __construct(
        private string $name,
        private string $value
    )
    {}

    public function getName() : string
    {
        return $this->name;
    }

    public function getValue() : string
    {
        return $this->value;
    }
}