<?php

namespace App\Repository\Wishlist\Subscription;

use App\Entity\User\User;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Repository\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WishlistSubscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method WishlistSubscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method WishlistSubscription[]    findAll()
 * @method WishlistSubscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishlistSubscriptionRepository extends DoctrineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WishlistSubscription::class);
    }

    public function create(
        Wishlist $wishlist, 
        User $user, 
        ?int $role = WishlistSubscription::ROLE_SUBSCRIBER
    ) : WishlistSubscription
    {
        $wishlistSubscription = new WishlistSubscription();

        $wishlistSubscription
            ->setRole($role);
            
        $wishlist
            ->addSubscription($wishlistSubscription);
        $user
            ->addWishlistSubscription($wishlistSubscription);

        $this->save($wishlistSubscription);
        return $wishlistSubscription;
    }
}
