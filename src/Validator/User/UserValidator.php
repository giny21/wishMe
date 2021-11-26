<?php

namespace App\Validator\User;

use App\Exception\InvalidActionDataExcepiton;
use App\Model\Action;
use App\Model\User\Action\CreateUser;
use App\Model\User\Action\SignInUser;
use App\Repository\User\UserRepository;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use App\Validator\Validator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserValidator extends Validator
{
    private CONST VIOLATION_EMAIL_USED = "Email używany przez innego użytkownika";
    private CONST VIOLATION_PASSWORDS_NOT_MATCH = "Hasła nie pasują do siebie";
    private CONST VIOLATION_USER_NOT_FOUND = "Użytkownik o podanym haśle i emailu nie istnieje";

    public function __construct(
        ValidatorInterface $validator,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
        parent::__construct($validator);
    }

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

        if($user = $this->userRepository->findOneByEmail($action->getEmail())){
            if(!$this->userPasswordHasher->isPasswordValid($user, $action->getPassword()))
                $this->addViolation($violations, self::VIOLATION_USER_NOT_FOUND, [], $action, $action->getEmail());
        }
        else
            $this->addViolation($violations, self::VIOLATION_USER_NOT_FOUND, [], $action, $action->getEmail());
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }
}