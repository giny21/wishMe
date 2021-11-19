<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Exception\InvalidNonActionClassException;
use App\Model\Action;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 *  @method User getUser() 
 */
abstract class Controller extends AbstractController
{
    public function deserialize(array $content, string $class, ?array $overrides = []) : Action
    {
        if(!is_subclass_of($class, Action::class))
            throw new InvalidNonActionClassException();

        $serializer = new Serializer(
            [new PropertyNormalizer()],
            [new JsonEncoder()]
        );

        $action = $serializer->deserialize(
            json_encode($content), 
            $class, 
            "json"
        );

        foreach($overrides as $field => &$value){
            if(property_exists($action, $field)){
                $getter = "get".ucfirst($field);
                $value = $value($action->$getter());
            }
        }
        $action->set($overrides);

        return $action;
    }
}