<?php

namespace App\Controller;

use App\Model\Action;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class ApiController extends AbstractController
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