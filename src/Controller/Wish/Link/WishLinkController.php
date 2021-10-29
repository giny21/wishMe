<?php

namespace App\Controller\Wish\Link;

use App\Controller\Controller;
use App\Entity\Wish\Link\WishLink;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wish\Action\Link\CreateWishLink;
use App\Service\Wish\Link\WishLinkService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishLinkController extends Controller
{
    public function __construct(
        private WishLinkService $wishLinkService
    )
    {   
    }

    #[Route('/list/{wishlist.id}/wish/{wish.id}/link/create', name: 'wish_link_create')]
    public function create(Wishlist $wishlist, Wish $wish, Request $request): Response
    {
        // @todo check access to wishlist and wish
        /** @var CreateWishLink */
        $createWishLink = $this->deserialize(
            $request->getContent(),
            CreateWishLink::class
        );

        $wish = $this->wishLinkService->create(
            $wish,
            $createWishLink
        );

        return $this->render('wish/wish/index.html.twig', [ // @todo create template
            'controller_name' => 'WishController',
            'wish' => $wish
        ]);
    }

    #[Route('/list/{wishlist.id}/wish/{wish.id}/link/{wishLink.id}/remove', name: 'wish_link_remove')]
    public function remove(Wishlist $wishlist, Wish $wish, WishLink $wishLink): Response
    {
        // @todo check access to wishlist and wish
        $this->wishLinkService->remove(
            $wishLink
        );

        return $this->render('wish/wish/index.html.twig', [ // @todo create template
            'controller_name' => 'WishController',
            'wish' => $wish
        ]);
    }
}
