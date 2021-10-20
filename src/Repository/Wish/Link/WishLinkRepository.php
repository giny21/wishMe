<?php

namespace App\Repository\Wish\Link;

use App\Entity\Wish\Link\WishLink;
use App\Entity\Wish\Wish;
use App\Repository\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WishLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method WishLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method WishLink[]    findAll()
 * @method WishLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishLinkRepository extends DoctrineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WishLink::class);
    }

    public function create(Wish $wish, string $rawLink) : WishLink
    {
        $wishLink = new WishLink();

        $wishLink
            ->setRawLink($rawLink);

        $wish
            ->addLink($wishLink);

        $this->save($wishLink);
        return $wishLink;
    }
}
