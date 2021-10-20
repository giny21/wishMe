<?php

namespace App\Repository\Wish;

use App\Entity\User\User;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Repository\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Wish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wish[]    findAll()
 * @method Wish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishRepository extends DoctrineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }

    public function create(Wishlist $wishlist, string $name) : Wish
    {
        $wish = new Wish();

        $wish
            ->setName($name);
            
        $wishlist
            ->addWish($wish);

        $this->save($wish);
        return $wish;
    }
}
