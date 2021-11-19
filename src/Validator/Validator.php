<?php

namespace App\Validator;

use App\Entity\DoctrineEntity;
use App\Model\Action;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class Validator
{
    public function __construct(private ValidatorInterface $validator)
    {  
    }

    protected function validate(Action $action) : ConstraintViolationList
    {
        return $this->validator->validate($action);
    }

    protected function addViolation(
        ConstraintViolationList $violations, 
        string $reason, 
        array $params, 
        Action|DoctrineEntity $object, 
        mixed $invalidValue
    ) : self
    {
        $violations->add(
            new ConstraintViolation(
                $reason,
                null,
                $params,
                $object,
                null,
                $invalidValue,
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            )
        );
        return $this;
    }
}