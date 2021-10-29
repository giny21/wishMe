<?php

namespace App\Controller;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    #[Route('/', name: 'home_show')]
    public function show(): Response
    {
        if($user = $this->getUser())
            return $this->render('user/index.html.twig', [ // @todo create template
                'controller_name' => 'UserController',
                'user' => $user
            ]);
        
        return $this->render('index.html.twig', [ // @todo create template
            'controller_name' => 'UserController'
        ]);
    }
}