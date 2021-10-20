<?php

namespace App\Controller\Wish\Subscription;

use App\Controller\ApiController;
use App\Entity\Wish\Subscription\WishSubscription;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Service\Wish\Subscription\WishSubscriptionService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishSubscriptionController extends ApiController
{
    public function __construct(
        private WishSubscriptionService $wishSubscriptionService
    )
    {   
    }

    #[Route('/list/{id}/wish/{id}/subscription/create', name: 'wish_subscription_create')]
    public function create(Wishlist $wishlist, Wish $wish): Response
    {
        // @todo check access to wishlist and wish

        $wish = $this->wishSubscriptionService->create(
            $wish,
            $this->getUser()
        );

        return $this->render('wish/wish/index.html.twig', [ // @todo create template
            'controller_name' => 'WishController',
            'wish' => $wish
        ]);
    }

    #[Route('/list/{id}/wish/{id}/subscription/{id}/remove', name: 'wish_subscription_remove')]
    public function remove(Wishlist $wishlist, Wish $wish, WishSubscription $wishSubscription): Response
    {
        // @todo check access to wishlist and wish
        $this->wishSubscriptionService->remove(
            $wishSubscription
        );

        return $this->render('wish/wish/index.html.twig', [ // @todo create template
            'controller_name' => 'WishController',
            'wish' => $wish
        ]);
    }
}
