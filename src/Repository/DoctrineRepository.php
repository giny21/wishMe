<?php

namespace App\Repository;

use App\Entity\DoctrineEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

abstract class DoctrineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    protected function lock(DoctrineEntity $subject) : DoctrineEntity
    {
        $id = $subject->getId();
        $entityManager = $this->_em;
        $connection = $entityManager->getConnection();

        $connection->beginTransaction();
        try{
            return $this->find($id, LockMode::PESSIMISTIC_WRITE);
        }
        catch(ORMException $e){
            throw new \Exception("Entity not found");
        }
    }

    public function unlock(DoctrineEntity $subject) : void
    {
        $entityManager = $this->_em;
        $connection = $entityManager->getConnection();

        try {
            $entityManager->persist($subject);
            $entityManager->flush($subject);
        } catch (\Exception $e) {
            $connection->rollBack();
            throw $e;
        }

        $connection->commit();
    }

    protected function save(DoctrineEntity $subject) : void
    {
        $entityManager = $this->_em;
        $entityManager->persist($subject);
        $entityManager->flush($subject);
    }

    public function remove(DoctrineEntity $subject) : void
    {
        $entityManager = $this->_em;
        $entityManager->remove($subject);
        $entityManager->flush($subject);
    }

    public function refresh(DoctrineEntity $subject) : void
    {
        $entityManager = $this->_em;
        $entityManager->refresh($subject);
    }

    // public function set(DoctrineEntity $entity, string $field, $value, ?bool $lock = true) : void
    // {
    //     $setter = "set".ucfirst($field);
    //     if(method_exists($entity, $setter)){
    //         if($lock) {
    //             $entity = $this->lock($entity);
    //             $entity->$setter($value);
    //             $this->unlock($entity);
    //         }
    //         else
    //             $entity->$setter($value);
    //     }
    //     else
    //         throw new MethodNotAllowedException(get_class_methods(get_class($entity)), "Wrong setter field $setter");
    // }
}