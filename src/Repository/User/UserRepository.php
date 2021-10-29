<?php

namespace App\Repository\User;

use App\Entity\User\User;
use App\Repository\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends DoctrineRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
        parent::__construct($registry, User::class);
    }

    public function create(string $email, string $password) : User
    {
        $user = new User();

        $user
            ->setEmail($email)
            ->setPassword(
                $this
                    ->userPasswordHasher  
                    ->hashPassword($user, $password)
            );
        
        $this->save($user);
        
        return $user;
    }
}
