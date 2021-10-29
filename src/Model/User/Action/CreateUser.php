<?php

namespace App\Model\User\Action;

use App\Model\Action;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateUser extends Action
{
    #[Email()]
    private string $email;

    #[NotBlank()]
    private string $password;

    #[NotBlank()]
    private string $passwordRepeat;

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getPasswordRepeat() : string
    {
        return $this->passwordRepeat;
    }
}