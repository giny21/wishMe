<?php

namespace App\Security\Voter\Wish;

use App\Entity\User\User;
use App\Entity\Wish\Wish;
use Exception;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class WishVoter extends Voter
{
    public CONST ACTION_EDIT = 'edit';
    public CONST ACTION_REMOVE = 'remove';
    public CONST ACTION_CREATE_SUBSCRIPTION = 'createSubscription';
    public CONST ACTION_SET_FULFILLED = 'setFulfilled';

    protected function supports(string $attribute, $subject) : bool
    {
        return
            in_array(
                $attribute, 
                [self::ACTION_EDIT ,self::ACTION_REMOVE, self::ACTION_CREATE_SUBSCRIPTION, self::ACTION_SET_FULFILLED]
            ) 
            &&
            $subject instanceof Wish;
    }

    /** @param Wish $subject */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token) : bool
    {
        switch($attribute){
            case self::ACTION_EDIT:
                return $this->canEdit($subject, $token->getUser());
            case self::ACTION_REMOVE:
                return $this->canRemove($subject, $token->getUser());
            case self::ACTION_CREATE_SUBSCRIPTION:
                return $this->canCreateSubscription($subject, $token->getUser());
            case self::ACTION_SET_FULFILLED:
                return $this->canSetFulfilled($subject, $token->getUser());
            
        }
    }

    private function canEdit(Wish $subject, User $user) : bool
    {
        return $subject->isOwner($user);
    }

    private function canRemove(Wish $subject, User $user) : bool
    {
        return $subject->isOwner($user);
    }

    private function canCreateSubscription(Wish $subject, User $user) : bool
    {
        return !$subject->isOwner($user);
    }

    private function canSetFulfilled(Wish $subject, User $user) : bool
    {
        return !$subject->isOwner($user);
    }
}