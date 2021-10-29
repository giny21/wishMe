<?php

namespace App\Controller\Wishlist;

use App\Controller\Controller;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wishlist\Action\CreateWishlist;
use App\Service\Wishlist\WishlistService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishlistController extends Controller
{
    public function __construct(
        private WishlistService $wishlistService
    )
    {   
    }

    #[Route('/list/{wishlist.id}', name: 'wishlist_show')]
    public function show(Wishlist $wishlist)
    {
        return $this->render('wishlist/wishlist/index.html.twig', [ // @todo create template
            'controller_name' => 'WishlistController',
            'wishlist' => $wishlist
        ]);
    }

    #[Route('/list/create', name: 'wishlist_create')]
    public function create(Request $request): Response
    {
        /** @var CreateWishlist */
        $createWishlist = $this->deserialize(
            $request->getContent(),
            CreateWishlist::class
        );

        $this->wishlistService->create(
            $this->getUser(),
            $createWishlist
        );

        return $this->render('user/index.html.twig', [ // @todo create template
            'controller_name' => 'UserController',
            'user' => $this->getUser()
        ]);
    }

    #[Route('/list/{wishlist.id}/remove', name: 'wishlist_remove')]
    public function remove(Wishlist $wishlist): Response
    {
        // @todo check access to wishlist and wish
        $this->wishlistService->remove(
            $wishlist
        );

        return $this->render('user/index.html.twig', [ // @todo create template
            'controller_name' => 'UserController',
            'user' => $this->getUser()
        ]);
    }
}
