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
        if($this->getUser())
            return $this->redirectToRoute('wishlist_show_my');
        
        return $this->render('home/index.html.twig', [
            'controller_name' => 'UserController'
        ]);
    }
}