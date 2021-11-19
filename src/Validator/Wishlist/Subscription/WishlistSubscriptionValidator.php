<?php

namespace App\Validator\Wishlist\Subscription;

use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Exception\InvalidActionDataExcepiton;
use App\Model\Wishlist\Action\Subscription\CreateWishlistSubscription;
use App\Repository\User\UserRepository;
use App\Repository\Wishlist\Subscription\WishlistSubscriptionRepository;
use App\Validator\Validator;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class WishlistSubscriptionValidator extends Validator
{
    private CONST VIOLATION_USER_NOT_FOUND = "User not found";
    private CONST VIOLATION_USER_ALREADY_SUBSCRIBE = "User already subscribe this wishlist";
    private CONST VIOLATION_LAST_SUBSCRIBER = "You cannot remove last subscriber";

    public function __construct(
        ValidatorInterface $validator,
        private UserRepository $userRepository,
        private WishlistSubscriptionRepository $wishlistSubscriptionRepository,
    )
    {
        parent::__construct($validator);
    }

    public function validateCreate(Wishlist $wishlist, CreateWishlistSubscription $action) : void
    {
        $violations = parent::validate($action);

        if($user = $this->userRepository->findOneByEmail($action->getUserEmail())){
            if($this->wishlistSubscriptionRepository->findOneByWishlistAndUser($wishlist, $user))
                $this->addViolation($violations, self::VIOLATION_USER_ALREADY_SUBSCRIBE, [], $action, $user);
        }
        else
            $this->addViolation($violations, self::VIOLATION_USER_NOT_FOUND, [], $action, $action->getUserEmail());
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }

    public function validateRemove(Wishlist $wishlist, WishlistSubscription $wishlistSubscription) : void
    {
        $violations = new ConstraintViolationList();

        if($wishlist->getSubscriptions()->count() === 1)
            $this->addViolation($violations, self::VIOLATION_LAST_SUBSCRIBER, [], $wishlist, $wishlistSubscription);
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }
}