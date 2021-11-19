<?php

namespace App\Security\Voter\Wishlist;

use App\Entity\User\User;
use App\Entity\Wishlist\Wishlist;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class WishlistVoter extends Voter
{
    public CONST ACTION_SHOW = 'show';
    public CONST ACTION_EDIT = 'edit';
    public CONST ACTION_REMOVE = 'remove';
    public CONST ACTION_SET_FAVORITE = 'setFavorite';

    protected function supports(string $attribute, $subject) : bool
    {
        return
            in_array(
                $attribute, 
                [self::ACTION_SHOW, self::ACTION_EDIT, self::ACTION_REMOVE, self::ACTION_SET_FAVORITE]
            ) 
            &&
            $subject instanceof Wishlist;
    }

    /** @param Wishlist $subject */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token) : bool
    {
        switch($attribute){
            case self::ACTION_SHOW:
                return $this->canShow($subject, $token->getUser());
            case self::ACTION_REMOVE:
                return $this->canRemove($subject, $token->getUser());
            case self::ACTION_EDIT:
                return $this->canEdit($subject, $token->getUser());
            case self::ACTION_SET_FAVORITE:
                return $this->canSetFavorite($subject, $token->getUser());
        }

        return false;
    }

    private function canShow(Wishlist $subject, $user) : bool
    {
        if($user instanceof User)
            return (bool)$subject->getSubscription($user) || $subject->getPublicAvailable();
        
        return $subject->getPublicAvailable();
    }

    private function canEdit(Wishlist $subject, User $user) : bool
    {
        return $subject->isOwner($user);
    }

    private function canRemove(Wishlist $subject, User $user) : bool
    {
        return $subject->isOwner($user);
    }

    private function canSetFavorite(Wishlist $subject, $user) : bool
    {
        if($user instanceof User)
            return (bool)$subject->getSubscription($user);
        
        return false;
    }
}