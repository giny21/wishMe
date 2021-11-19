<?php

namespace App\Validator\Wish;

use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Exception\InvalidActionDataExcepiton;
use App\Model\Wish\Action\CreateWish;
use App\Model\Wish\Action\EditWish;
use App\Validator\Validator;
use Symfony\Component\Validator\ConstraintViolationList;

class WishValidator extends Validator
{
    private CONST VIOLATION_WISHLISTS_REDUNDANT = "You can't add Wish to same Wishlist two times";
    private CONST VIOLATION_WISH_ALREADY_FULFILLED = "Wish already fulfilled";

    public function validateEdit(EditWish $action) : void
    {
        $violations = parent::validate($action);

        $wishlistsIds = array_map(
            fn(Wishlist $wishlist) => $wishlist->getId(),
            $action->getWishlists()
        );

        if(sizeof(array_unique($wishlistsIds)) != sizeof($wishlistsIds))
            $this->addViolation($violations, self::VIOLATION_WISHLISTS_REDUNDANT, [], $action, $action->getWishlists());
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }

    public function validateCreate(CreateWish $action) : void
    {
        $violations = parent::validate($action);

        $wishlistsIds = array_map(
            fn(Wishlist $wishlist) => $wishlist->getId(),
            $action->getWishlists()
        );

        if(sizeof(array_unique($wishlistsIds)) != sizeof($wishlistsIds))
            $this->addViolation($violations, self::VIOLATION_WISHLISTS_REDUNDANT, [], $action, $action->getWishlists());
        
        if(count($violations) > 0)
            throw new InvalidActionDataExcepiton((string)$violations);
    }
}