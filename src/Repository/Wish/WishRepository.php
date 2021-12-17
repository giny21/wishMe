<?php

namespace App\Repository\Wish;

use App\Entity\User\User;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Repository\DoctrineRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends DoctrineRepository
{
    private CONST LIMIT_PER_PAGE = 20;

    private CONST SORTS = [
        ["wish.id", "DESC"]
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    /** @param Collection<Wishlist> $wishlists */
    public function create(string $name, bool $important, Collection $wishlists) : Wish
    {
        $wish = new Wish();

        $wish
            ->setName($name)
            ->setWishlists($wishlists)
            ->setImportant($important)
            ->setFulfilled(false);
            
        $this->save($wish);
        return $wish;
    }

    /** @return Wish[] */
    public function findByUser(User $user) : array
    {
        return $this
            ->createQueryBuilder('wish')
            ->leftJoin('wish.subscriptions', 'wishSubscription')
            ->where('wishSubscription.user = :userId')
            ->addOrderBy('wish.id', 'DESC')
            ->setParameter('userId', $user->getId())
            ->getQuery()
            ->getResult();
    }

    public function findByUserPerPage(User $user, int $page, int $sort, int $role) : array
    {
        $query = $this
            ->createQueryBuilder('wish')
            ->leftJoin('wish.subscriptions', 'wishSubscription')
            ->where('wishSubscription.user = :userId')
            ->setParameter('userId', $user->getId());

        if($role)
            $query
                ->leftJoin('wish.wishlists', 'wishlist')
                ->leftJoin('wishlist.subscriptions', 'wishlistSubscription')
                ->andWhere('wishlistSubscription.role = :role')
                ->setParameter('role', $role);

        return $query
            ->addOrderBy(...self::SORTS[$sort])
            ->setFirstResult($page * self::LIMIT_PER_PAGE)
            ->setMaxResults(self::LIMIT_PER_PAGE)
            ->getQuery()
            ->getResult();
    }
}
