<?php

namespace App\Model\Wish\Action;

use App\Model\Action;

class CreateWish extends Action
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