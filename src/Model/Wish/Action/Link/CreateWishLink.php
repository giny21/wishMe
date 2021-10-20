<?php

namespace App\Model\Wish\Action\Link;

use App\Model\Action;

class CreateWishLink extends Action
{
    public function __construct(
        private string $rawLink
    )
    {}

    public function getRawLink() : string
    {
        return $this->rawLink;
    }
}