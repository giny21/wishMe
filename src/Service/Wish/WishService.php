<?php

namespace App\Service\Wish;

use App\Entity\User\User;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wish\Action\CreateWish;
use App\Repository\Wish\Subscription\WishSubscriptionRepository;
use App\Repository\Wish\WishRepository;
use App\Service\Wish\Field\WishFieldService;
use App\Service\Wish\Link\WishLinkService;
use App\Service\Wish\Subscription\WishSubscriptionService;

class WishService
{
    public function __construct(
        private WishSubscriptionService $wishSubscriptionService,
        private WishFieldService $wishFieldService,
        private WishLinkService $wishLinkService,
        private WishRepository $wishRepository
    )
    {}

    public function create(
        Wishlist $wishlist, 
        User $user, 
        CreateWish $createWish
    ) : Wish
    {
        $wish = $this->wishRepository->create(
            $wishlist,
            $createWish->getName()
        );

        $this->wishSubscriptionService->create(
            $wish,
            $user
        );

        return $wish;
    }

    public function remove(Wish $wish) : void
    {
        $wish
            ->getWishlist()
            ->removeWish($wish);

        foreach($wish->getSubscriptions() as $wishSubscription)
            $this->wishSubscriptionService->remove($wishSubscription);
            
        foreach($wish->getFields() as $wishField)
            $this->wishFieldService->remove($wishField);
            
        foreach($wish->getLinks() as $wishLink)
            $this->wishLinkService->remove($wishLink);
        
        $this->wishRepository->remove($wish);
    }
}