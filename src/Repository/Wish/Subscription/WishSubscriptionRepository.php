<?php

namespace App\Repository\Wish\Subscription;

use App\Entity\User\User;
use App\Entity\Wish\Subscription\WishSubscription;
use App\Entity\Wish\Wish;
use App\Repository\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WishSubscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method WishSubscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method WishSubscription[]    findAll()
 * @method WishSubscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishSubscriptionRepository extends DoctrineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WishSubscription::class);
    }

    public function create(Wish $wish, User $user) : WishSubscription
    {
        $wishSubscription = new WishSubscription();

        $wish->addSubscription($wishSubscription);
        $user->addWishSubscription($wishSubscription);

        $this->save($wishSubscription);
        return $wishSubscription;
    }
}
