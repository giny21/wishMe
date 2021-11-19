<?php

namespace App\Service\Wishlist\Subscription;

use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wishlist\Action\Subscription\CreateWishlistSubscription;
use App\Repository\User\UserRepository;
use App\Repository\Wishlist\Subscription\WishlistSubscriptionRepository;

class WishlistSubscriptionService
{
    public function __construct(
        private UserRepository $userRepository,
        private WishlistSubscriptionRepository $wishlistSubscriptionRepository
    )
    {}

    public function create(Wishlist $wishlist, CreateWishlistSubscription $createWishlistSubscription) : Wishlist
    {
        $user = $this->userRepository->findOneByEmail(
            $createWishlistSubscription->getUserEmail()
        );

        $this->wishlistSubscriptionRepository->create(
            $wishlist, 
            $user, 
            $createWishlistSubscription->getRole()
        );

        return $wishlist;
    }

    public function switchFavorite(
        WishlistSubscription $wishlistSubscription
    )
    {
        $this->wishlistSubscriptionRepository->sets(
            $wishlistSubscription,
            [
                'favorite' => !$wishlistSubscription->getFavorite()
            ]
        );
    }

    public function remove(
        WishlistSubscription $wishlistSubscription
    ) : void
    {
        $wishlistSubscription
            ->getWishlist()
            ->removeSubscription($wishlistSubscription);
            
        $wishlistSubscription
            ->getUser()
            ->removeWishlistSubscription($wishlistSubscription);

        $this->wishlistSubscriptionRepository->remove($wishlistSubscription);
    }
}