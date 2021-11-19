<?php

namespace App\Repository\Wishlist;

use App\Entity\User\User;
use App\Entity\Wishlist\Wishlist;
use App\Repository\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wishlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wishlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wishlist[]    findAll()
 * @method Wishlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishlistRepository extends DoctrineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wishlist::class);
    }

    public function create(string $name) : Wishlist
    {
        $wishlist = new Wishlist();

        $wishlist
            ->setName($name)
            ->setPublicAvailable(false);

        $this->save($wishlist);
        return $wishlist;
    }

    /** @return Wishlist[] */
    public function findByUser(User $user) : array
    {
        return $this
            ->createQueryBuilder('wishlist')
            ->leftJoin('wishlist.subscriptions', 'wishlistSubscription')
            ->where('wishlistSubscription.user = :userId')
            ->addOrderBy('wishlistSubscription.favorite', 'DESC')
            ->addOrderBy('wishlist.id', 'DESC')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }
}
