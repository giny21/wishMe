<?php

namespace App\Security\Voter\Wishlist\Subscription;

use App\Entity\User\User;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Security\Voter\Wishlist\WishlistVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class WishlistSubscriptionVoter extends Voter
{
    public CONST ACTION_REMOVE = 'remove';

    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker
    )
    {}

    protected function supports(string $attribute, $subject) : bool
    {
        return
            in_array(
                $attribute, 
                [self::ACTION_REMOVE]
            ) 
            &&
            $subject instanceof WishlistSubscription;
    }

    /** @param WishlistSubscription $subject */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token) : bool
    {
        switch($attribute){
            case self::ACTION_REMOVE:
                return $this->canRemove($subject, $token->getUser());
        }

        return false;
    }

    private function canRemove(WishlistSubscription $subject, User $user) : bool
    {
        return 
            $this->authorizationChecker->isGranted(
                WishlistVoter::ACTION_EDIT, 
                $subject->getWishlist()
            )
            ||
            $subject->getUser() === $user;
    }
}