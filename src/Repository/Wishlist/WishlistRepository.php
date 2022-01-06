<?php

namespace App\Repository\Wishlist;

use App\Entity\User\User;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wishlist\Action\SearchWishlist;
use App\Repository\DoctrineRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wishlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wishlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wishlist[]    findAll()
 * @method Wishlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishlistRepository extends DoctrineRepository
{
    private CONST LIMIT_PER_PAGE = 20;

    private CONST SORTS = [
        ["wishlist.id", "DESC"]
    ];

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
            ->addOrderBy('wishlist.id', 'DESC')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function findByUserPerPage(User $user, int $page, int $sort, int $role) : array
    {
        $query = $this
            ->createQueryBuilder('wishlist')
            ->leftJoin('wishlist.subscriptions', 'wishlistSubscription')
            ->where('wishlistSubscription.user = :userId')
            ->setParameter('userId', $user->getId());

        if($role)
            $query
                ->andWhere('wishlistSubscription.role = :role')
                ->setParameter('role', $role);

        return $query
            ->addOrderBy(...self::SORTS[$sort])
            //->setFirstResult($page * self::LIMIT_PER_PAGE)
            //->setMaxResults(self::LIMIT_PER_PAGE)
            ->getQuery()
            ->getResult();
    }

    public function findByUserAndSearchOptions(User $user, SearchWishlist $searchWishlist) : array
    {
        $query = $this
            ->createQueryBuilder('wishlist')
            ->leftJoin('wishlist.subscriptions', 'wishlistSubscription')
            ->where('wishlistSubscription.user = :userId')
            ->setParameter('userId', $user->getId());

        if($name = $searchWishlist->getName())
            $query
                ->andWhere('wishlist.name Like :name')
                ->setParameter('name', $name.'%');

        if($role = $searchWishlist->getRole())
            $query
                ->andWhere('wishlistSubscription.role = :role')
                ->setParameter('role', $role);

        return $query
            ->getQuery()
            ->getResult();
    }
}
