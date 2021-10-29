<?php

namespace App\Controller\Wish;

use App\Controller\Controller;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wish\Action\AddWishField;
use App\Model\Wish\Action\AddWishLink;
use App\Model\Wish\Action\CreateWish;
use App\Service\Wish\WishService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends Controller
{
    public function __construct(
        private WishService $wishService
    )
    {   
    }

    #[Route('/list/{wishlist.id}/wish/{wish.id}', name: 'wish_show')]
    public function show(Wishlist $wishlist, Wish $wish): Response
    {
        return $this->render('wish/wish/index.html.twig', [ // @todo create template
            'controller_name' => 'WishlistController',
            'wish' => $wish
        ]);
    }

    #[Route('/list/{wishlist.id}/wish/create', name: 'wish_create')]
    public function create(Wishlist $wishlist, Request $request): Response
    {
        // @todo check access to wishlist and wish
        /** @var CreateWish */
        $createWish = $this->deserialize(
            $request->getContent(),
            CreateWish::class
        );

        $this->wishService->create(
            $wishlist,
            $this->getUser(),
            $createWish
        );

        return $this->render('wishlist/wishlist/index.html.twig', [ // @todo create template
            'controller_name' => 'WishlistController',
            'wishlist' => $wishlist
        ]);
    }

    #[Route('/list/{wishlist.id}/wish/{wish.id}/remove', name: 'wish_create')]
    public function remove(Wishlist $wishlist, Wish $wish): Response
    {
        // @todo check access to wishlist and wish
        $this->wishService->remove(
            $wish
        );

        return $this->render('user/index.html.twig', [ // @todo create template
            'controller_name' => 'UserController',
            'user' => $this->getUser()
        ]);
    }
}
