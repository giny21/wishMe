<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Model\Action;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class Controller extends AbstractController
{
    public function deserialize(mixed $content, string $class) : Action
    {
        $serializer = new Serializer(
            [new GetSetMethodNormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->deserialize(
            $content, 
            $class, 
            "json"
        );
    }
}