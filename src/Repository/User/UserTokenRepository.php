<?php

namespace App\Repository\User;

use App\Entity\User\User;
use App\Entity\User\UserToken;
use App\Repository\DoctrineRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserToken[]    findAll()
 * @method UserToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTokenRepository extends DoctrineRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    public function create(User $user, string $token) : UserToken
    {
        $userToken = new UserToken();

        $userToken
            ->setToken($token)
            ->setUser($user);
        
        $this->save($userToken);
        
        return $userToken;
    }
}
