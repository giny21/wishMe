<?php

namespace App\Service\Wish\Subscription;

use App\Entity\User\User;
use App\Entity\Wish\Subscription\WishSubscription;
use App\Entity\Wish\Wish;
use App\Repository\Wish\Subscription\WishSubscriptionRepository;

class WishSubscriptionService
{
    public function __construct(
        private WishSubscriptionRepository $wishSubscriptionRepository
    )
    {}

    public function create(
        Wish $wish,
        User $user
    ) : Wish
    {
        $this->wishSubscriptionRepository->create(
            $wish,
            $user
        );

        return $wish;
    }

    public function remove(
        WishSubscription $wishSubscription
    ) : void
    {
        $wishSubscription
            ->getWish()
            ->removeSubscription($wishSubscription);
            
        $wishSubscription
            ->getUser()
            ->removeWishSubscription($wishSubscription);

        $this->wishSubscriptionRepository->remove($wishSubscription);
    }
}