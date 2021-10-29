<?php

namespace App\Model\Wish\Action\Link;

use App\Model\Action;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateWishLink extends Action
{
    #[NotBlank()]
    private string $rawLink;
    
    public function getRawLink() : string
    {
        return $this->rawLink;
    }
}