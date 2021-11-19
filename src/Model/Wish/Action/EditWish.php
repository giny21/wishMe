<?php

namespace App\Model\Wish\Action;

class EditWish extends CreateWish
{
    private ?bool $important = null;

    public function getImportant() : ?bool
    {
        return $this->important;
    }
}