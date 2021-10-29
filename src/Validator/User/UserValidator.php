<?php

namespace App\Validator\User;

use App\Exception\InvalidActionDataExcepiton;
use App\Model\Action;
use App\Model\User\Action\CreateUser;
use App\Model\User\Action\SignInUser;
use App\Repository\User\UserRepository;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use App\Validator\Validator;

class UserValidator extends Validator
{
    private CONST VIOLATION_EMAIL_USED = "Email already used by another User";
    private CONST VIOLATION_PASSWORDS_NOT_MATCH = "Passwords not match";

    public function __construct(
        private UserRepository $userRepository
    )
    {}

    public function validateCreate(CreateUser $action) : void
    {
        $violations = parent::validate($action);

        if($this->userRepository->findOneByEmail($action->getEmail()))
            $this->addViolation($violations, self::VIOLATION_EMAIL_USED, [], $action, $action->getEmail());
        if($action->getPassword() !== $action->getPasswordRepeat())
            $this->addViolation($violations, self::VIOLATION_PASSWORDS_NOT_MATCH, [], $action, $action->getPassword());
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }

    public function validateSignIn(SignInUser $action) : void
    {
        $violations = parent::validate($action);

        if($this->userRepository->findOneByEmail($action->getEmail()))
            $this->addViolation($violations, self::VIOLATION_EMAIL_USED, [], $action, $action->getEmail());
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }
}