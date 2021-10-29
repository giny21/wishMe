<?php

namespace App\Controller\User;

use App\Controller\Controller;
use App\Model\User\Action\CreateUser;
use App\Model\User\Action\SignInUser;
use App\Service\User\UserService;
use App\Validator\User\UserValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    public function __construct(
        private UserValidator $userValidator,
        private UserService $userService
    )
    {   
    }

    #[Route('/user/create', name: 'user_create')]
    public function create(Request $request): Response
    {
        // @todo check user not logged
        /** @var CreateUser */
        $createUser = $this->deserialize(
            $request->getContent(),
            CreateUser::class
        );
        $this->userValidator->validateCreate($createUser);
        $this->userService->create($createUser);

        return $this->redirectToRoute('user_sign_in');
    }

    #[Route('/user/sign-in', name: 'user_sign_in')]
    public function signIn(Request $request): Response
    {
        // @todo check user not logged
        /** @var SignInUser */
        $signInUser = $this->deserialize(
            $request->getContent(),
            SignInUser::class
        );

        $user = $this->userService->signIn($signInUser);

        return $this->render('user/index.html.twig', [ // @todo create template
            'controller_name' => 'UserController',
            'user' => $user
        ]);
    }

    #[Route('/user/sign-out', name: 'user_sign_out')]
    public function signOut(): Response
    {
        $user = $this->getUser();
        $this->userService->signOut($user);

        return $this->render('index.html.twig', [ // @todo create template
            'controller_name' => 'UserController'
        ]);
    }
}