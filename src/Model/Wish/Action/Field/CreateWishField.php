<?php

namespace App\Model\Wish\Action\Field;

use App\Model\Action;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateWishField extends Action
{
    #[NotBlank()]
    private string $name;

    #[NotBlank()]
    private string $value;

    public function getName() : string
    {
        return $this->name;
    }

    public function getValue() : string
    {
        return $this->value;
    }
}