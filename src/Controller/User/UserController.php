<?php

namespace App\Controller\User;

use App\Controller\Controller;
use App\Model\User\Action\CreateUser;
use App\Model\User\Action\SignInUser;
use App\Service\User\UserService;
use App\Validator\User\UserValidator;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    public function __construct(
        SerializerInterface $serializer,
        private UserValidator $userValidator,
        private UserService $userService
    )
    {   
        parent::__construct($serializer);
    }

    #[Route('/user/create', name: 'user_create')]
    public function createAction(Request $request): Response
    {
        if($user = $this->getUser())
            return $this->respond(
                [
                    "user" => $user
                ]
            );

        /** @var CreateUser */
        $createUser = $this->deserialize(
            $request,
            CreateUser::class
        );

        $this->userValidator->validateCreate($createUser);
        $this->userService->create($createUser);
        
        return $this->signInAction($request);
    }

    #[Route('/user/sign-in', name: 'user_sign_in')]
    public function signInAction(Request $request): Response
    {
        if($this->getUser())
            return $this->respond();
            
        /** @var SignInUser */
        $signInUser = $this->deserialize(
            $request,
            SignInUser::class
        );
    
        $this->userValidator->validateSignIn($signInUser);
        $user = $this->userService->signIn($signInUser);

        return $this->respond(
            [
                "user" => $user
            ]
        );
    }

    #[Route('/user/sign-out', name: 'user_sign_out')]
    public function signOut(): Response
    {
        $this->userService->signOut();

        return $this->redirectToRoute('home_show');
    }
}