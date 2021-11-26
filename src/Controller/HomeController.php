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
        $user = $this->getUser();
        return $this->render(
            'base.html.twig',
            [
                'user' => $this->serialize($user)
            ]
        );
    }
}