<?php

namespace App\Model\Wish\Action;

use App\Model\Action;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateWish extends Action
{
    #[NotBlank()]
    private string $name;

    public function getName() : string
    {
        return $this->name;
    }
}