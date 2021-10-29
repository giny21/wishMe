<?php

namespace App\Model\User\Action;

use App\Model\Action;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class SignInUser extends Action
{
    #[Email()]
    private string $email;

    #[NotBlank()]
    private string $password;

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }
}