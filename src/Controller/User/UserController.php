<?php

namespace App\Controller\User;

use App\Controller\Controller;
use App\Controller\HomeController;
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
        if($this->getUser())
            return $this->redirectToRoute('wishlist_show_my');

        if($request->getMethod() === "POST"){
            /** @var CreateUser */
            $createUser = $this->deserialize(
                $request->request->all(),
                CreateUser::class
            );
            $this->userValidator->validateCreate($createUser);
            $this->userService->create($createUser);
        
            $this->signIn($request);
            return $this->redirectToRoute('wishlist_show_my');
        }
            
        return $this->render('user/sign-up-form.html.twig', [
            'controller_name' => 'UserController'
        ]);
    }

    #[Route('/user/sign-in', name: 'user_sign_in')]
    public function signIn(Request $request): Response
    {
        if($this->getUser())
            return $this->redirectToRoute('wishlist_show_my');
            
        /** @var SignInUser */
        $signInUser = $this->deserialize(
            $request->request->all(),
            SignInUser::class
        );
    
        $this->userValidator->validateSignIn($signInUser);
        $this->userService->signIn($signInUser);
        
        return $this->redirectToRoute('wishlist_show_my');
    }

    #[Route('/user/sign-out', name: 'user_sign_out')]
    public function signOut(): Response
    {
        $this->userService->signOut();

        return $this->redirectToRoute('home_show');
    }
}