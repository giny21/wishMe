<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Exception\InvalidNonActionClassException;
use App\Model\Action;
use JMS\Serializer\Serializer as JMSSerializer;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 *  @method User getUser() 
 */
abstract class Controller extends AbstractController
{
    public function __construct(
        protected SerializerInterface $serializer
    )
    {}
    
    public function deserialize(Request $request, string $class, ?array $overrides = []) : Action
    {
        if(!is_subclass_of($class, Action::class))
            throw new InvalidNonActionClassException();

        if($request->isXmlHttpRequest())
            $action = $this->jmsDeserialize(
                $request->getContent(), 
                $class, 
                "json"
            );
        else
            $action = $this->defaultDeserialize(
                json_encode($request->request->all()),
                $class
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

    private function defaultDeserialize(string $data, string $class) : Action
    {
        $serializer = new Serializer(
            [new PropertyNormalizer()],
            [new JsonEncoder()]
        );

        return $serializer->deserialize(
            $data, 
            $class, 
            "json"
        );
    }

    private function jmsDeserialize(string $data, string $class) : Action
    {
        return $this
            ->serializer
            ->deserialize($data, $class, "json");
    }

    public function respond(?array $data = []) : JsonResponse
    {
        return new JsonResponse(
            data: $this->serialize($data),
            json: true
        );
    }

    public function serialize(mixed $data) : string
    {
        return $this
            ->serializer
            ->serialize($data ?? "", "json");
    }
}