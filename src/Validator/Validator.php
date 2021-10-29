<?php

namespace App\Validator;

use App\Model\Action;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class Validator
{
    protected function validate(Action $action) : ConstraintViolationList
    {
        return Validation::createValidator()->validate($action);
    }

    protected function addViolation(
        ConstraintViolationList $violations, 
        string $reason, 
        array $params, 
        Action $action, 
        mixed $invalidValue
    ) : self
    {
        $violations->add(
            new ConstraintViolation(
                $reason,
                null,
                $params,
                $action,
                null,
                null,
                $invalidValue
            )
        );
        return $this;
    }
}