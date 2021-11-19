<?php

namespace App\Service\Wish;

use App\Entity\User\User;
use App\Entity\Wish\Subscription\WishSubscription;
use App\Entity\Wish\Wish;
use App\Model\Wish\Action\CreateWish;
use App\Model\Wish\Action\EditWish;
use App\Repository\Wish\WishRepository;
use App\Service\Wish\Field\WishFieldService;
use App\Service\Wish\Link\WishLinkService;
use App\Service\Wish\Subscription\WishSubscriptionService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Exception;

class WishService
{
    public function __construct(
        private WishFieldService $wishFieldService,
        private WishLinkService $wishLinkService,
        private WishSubscriptionService $wishSubscriptionService,
        private WishRepository $wishRepository
    )
    {}

    /** @return Collection<Wish> */
    public function getsOwned(User $user) : Collection
    {
        return new ArrayCollection(
            array_values(
                array_filter(
                    $this
                        ->wishRepository
                        ->findByUser($user),
                    fn(Wish $wish) => $wish->isOwner($user)
                )
            )
        );
    }

    /** @return Collection<Wish> */
    public function getsSubscribed(User $user) : Collection
    {
        return new ArrayCollection(
            array_values(
                array_filter(
                    $this
                        ->wishRepository
                        ->findByUser($user),
                    fn(Wish $wish) => !$wish->isOwner($user)
                )
            )
        );
    }

    public function create(CreateWish $createWish, User $user) : Wish
    {
        $wish = $this->wishRepository->create(
            $createWish->getName(),
            new ArrayCollection($createWish->getWishlists())
        );

        $this->wishSubscriptionService->create(
            $wish,
            $user
        );

        return $wish;
    }

    public function edit(Wish $wish, EditWish $editWish) : Wish
    {
        $this->wishRepository->sets(
            $wish,
            [
                "name" => $editWish->getName(),
                "important" => $editWish->getImportant() ?? false,
                "wishlists" => new ArrayCollection($editWish->getWishlists())
            ]
        );

        return $wish;
    }

    public function switchFulfilled(Wish $wish) : void
    {
        $this->wishRepository->sets(
            $wish,
            [
                "fulfilled" => !$wish->getFulfilled()
            ]
        );
    }

    public function remove(Wish $wish) : void
    {
        foreach($wish->getSubscriptions() as $wishSubscription)
            $this->wishSubscriptionService->remove($wishSubscription);
            
        foreach($wish->getFields() as $wishField)
            $this->wishFieldService->remove($wishField);
            
        foreach($wish->getLinks() as $wishLink)
            $this->wishLinkService->remove($wishLink);
        
        $this->wishRepository->remove($wish);
    }
}