<?php

namespace App\Controller\Wish\Field;

use App\Controller\ApiController;
use App\Entity\Wish\Field\WishField;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wish\Action\Field\CreateWishField;
use App\Service\Wish\Field\WishFieldService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishFieldController extends ApiController
{
    public function __construct(
        private WishFieldService $wishFieldService
    )
    {   
    }

    #[Route('/list/{id}/wish/{id}/field/create', name: 'wish_field_create')]
    public function create(Wishlist $wishlist, Wish $wish, Request $request): Response
    {
        // @todo check access to wishlist and wish
        /** @var CreateWishField */
        $createWishField = $this->deserialize(
            $request->getContent(),
            CreateWishField::class
        );

        $wish = $this->wishFieldService->create(
            $wish,
            $createWishField
        );

        return $this->render('wish/wish/index.html.twig', [ // @todo create template
            'controller_name' => 'WishController',
            'wish' => $wish
        ]);
    }

    #[Route('/list/{id}/wish/{id}/field/{id}/remove', name: 'wish_field_remove')]
    public function remove(Wishlist $wishlist, Wish $wish, WishField $wishField): Response
    {
        // @todo check access to wishlist and wish
        $this->wishFieldService->remove(
            $wishField
        );

        return $this->render('wish/wish/index.html.twig', [ // @todo create template
            'controller_name' => 'WishController',
            'wish' => $wish
        ]);
    }
}
