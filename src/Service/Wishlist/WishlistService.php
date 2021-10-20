<?php

namespace App\Service\Wishlist;

use App\Entity\User\User;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wishlist\Action\CreateWishlist;
use App\Model\Wishlist\Action\Subscription\CreateWishlistSubscription;
use App\Repository\Wishlist\WishlistRepository;
use App\Service\Wish\WishService;
use App\Service\Wishlist\Subscription\WishlistSubscriptionService;

class WishlistService
{
    public function __construct(
        private WishlistSubscriptionService $wishlistSubscriptionService,
        private WishService $wishService,
        private WishlistRepository $wishlistRepository
    )
    {}

    public function create(User $user, CreateWishlist $createWishlist) : Wishlist
    {
        $wishlist = $this->wishlistRepository->create(
            $createWishlist->getName()
        );

        $this->wishlistSubscriptionService->create(
            $wishlist,
            new CreateWishlistSubscription(
                $user->getEmail(),
                WishlistSubscription::ROLE_OWNER
            )
        );

        return $wishlist;
    }

    public function remove(Wishlist $wishlist) : void
    {
        foreach($wishlist->getSubscriptions() as $wishlistSubscription)
            $this->wishlistSubscriptionService->remove($wishlistSubscription);

        foreach($wishlist->getWishes() as $wishlistWish)
            $this->wishService->remove($wishlistWish);

        $this->wishlistRepository->remove($wishlist);
    }
}