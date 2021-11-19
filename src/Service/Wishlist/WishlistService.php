<?php

namespace App\Service\Wishlist;

use App\Entity\User\User;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wishlist\Action\CreateWishlist;
use App\Model\Wishlist\Action\EditWishlist;
use App\Model\Wishlist\Action\Subscription\CreateWishlistSubscription;
use App\Repository\Wishlist\WishlistRepository;
use App\Service\Wishlist\Subscription\WishlistSubscriptionService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class WishlistService
{
    public function __construct(
        private WishlistSubscriptionService $wishlistSubscriptionService,
        private WishlistRepository $wishlistRepository
    )
    {}

    /** 
     * @param int[] $ids
     * @return Collection<Wishlist> 
     */
    public function gets(array $ids) : Collection
    {
        return new ArrayCollection(
            $this
                ->wishlistRepository
                ->finds($ids)
        );
    }

    /** @return Collection<Wishlist> */
    public function getsOwned(User $user) : Collection
    {
        return new ArrayCollection(
            array_values(
                array_filter(
                    $this
                        ->wishlistRepository
                        ->findByUser($user),
                    fn(Wishlist $wishlist) => $wishlist->isOwner($user)
                )
            )
        );
    }

    /** @return Collection<Wishlist> */
    public function getsSubscribed(User $user) : Collection
    {
        return new ArrayCollection(
            array_values(
                array_filter(
                    $this
                        ->wishlistRepository
                        ->findByUser($user),
                    fn(Wishlist $wishlist) => !$wishlist->isOwner($user)
                )
            )
        );
    }

    public function create(User $user, CreateWishlist $createWishlist) : Wishlist
    {
        $wishlist = $this->wishlistRepository->create(
            $createWishlist->getName()
        );

        $this->wishlistSubscriptionService->create(
            $wishlist,
            (new CreateWishlistSubscription())
                ->set(
                    [
                        "userEmail" => $user->getEmail(),
                        "role" => WishlistSubscription::ROLE_OWNER
                    ]
                )
        );

        return $wishlist;
    }

    public function edit(Wishlist $wishlist, EditWishlist $editWishlist) : Wishlist
    {
        $this->wishlistRepository->sets(
            $wishlist,
            [
                "name" => $editWishlist->getName(),
                "publicAvailable" => $editWishlist->getPublicAvailable() ?? false
            ]
        );

        return $wishlist;
    }

    public function switchFavorite(
        Wishlist $wishlist, User $user
    )
    {
        $wishlistSubscription = $wishlist->getSubscription($user);
        $this->wishlistSubscriptionService->switchFavorite($wishlistSubscription);
    }

    public function remove(Wishlist $wishlist) : void
    {
        foreach($wishlist->getSubscriptions() as $wishlistSubscription)
            $this->wishlistSubscriptionService->remove($wishlistSubscription);

        $this->wishlistRepository->remove($wishlist);
    }
}