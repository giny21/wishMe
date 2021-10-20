<?php

namespace App\Repository\Wish\Field;

use App\Entity\Wish\Field\WishField;
use App\Entity\Wish\Wish;
use App\Repository\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WishField|null find($id, $lockMode = null, $lockVersion = null)
 * @method WishField|null findOneBy(array $criteria, array $orderBy = null)
 * @method WishField[]    findAll()
 * @method WishField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishFieldRepository extends DoctrineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WishField::class);
    }

    public function create(Wish $wish, string $name, string $value) : WishField
    {
        $wishField = new WishField();

        $wishField
            ->setName($name)
            ->setValue($value);

        $wish
            ->addField($wishField);

        $this->save($wishField);
        return $wishField;
    }
}
