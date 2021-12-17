<?php

namespace App\Validator\Wish\Subscription;

use App\Entity\User\User;
use App\Entity\Wish\Wish;
use App\Exception\InvalidActionDataExcepiton;
use App\Validator\Validator;
use Symfony\Component\Validator\ConstraintViolationList;

class WishSubscriptionValidator extends Validator
{
    private CONST VIOLATION_USER_ALREADY_SUBSCRIBE = "User already subscribe this wish";
    private CONST VIOLATION_WISH_ALREADY_FULFILLED = "Wish already fulfilled";

    public function validateCreate(User $user, Wish $wish) : void
    {
        $violations = new ConstraintViolationList();

        if($wish->getFulfilled())
            $this->addViolation($violations, self::VIOLATION_WISH_ALREADY_FULFILLED, [], $wish, $wish->getFulfilled());

        foreach($wish->getSubscriptions() as $subscription){
            if($subscription->getUser() === $user)
                $this->addViolation($violations, self::VIOLATION_USER_ALREADY_SUBSCRIBE, [], $wish, $user);
        }
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }
}