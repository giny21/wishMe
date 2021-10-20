<?php

namespace App\Repository\Wishlist;

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
            ->setName($name);

        $this->save($wishlist);
        return $wishlist;
    }
}
