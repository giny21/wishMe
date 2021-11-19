<?php

namespace App\Security\Voter\Wish\Subscription;

use App\Entity\User\User;
use App\Entity\Wish\Subscription\WishSubscription;
use App\Security\Voter\Wish\WishVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class WishSubscriptionVoter extends Voter
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
            $subject instanceof WishSubscription;
    }

    /** @param WishSubscription $subject */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token) : bool
    {
        switch($attribute){
            case self::ACTION_REMOVE:
                return $this->canRemove($subject, $token->getUser());
        }

        return false;
    }

    private function canRemove(WishSubscription $subject, User $user) : bool
    {
        return 
            $this->authorizationChecker->isGranted(
                WishVoter::ACTION_EDIT, 
                $subject->getWish()
            )
            ||
            $subject->getUser() === $user;
    }
}