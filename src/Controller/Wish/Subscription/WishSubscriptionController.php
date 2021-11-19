<?php

namespace App\Controller\Wish\Subscription;

use App\Controller\Controller;
use App\Entity\Wish\Subscription\WishSubscription;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Security\Voter\Wish\Subscription\WishSubscriptionVoter;
use App\Security\Voter\Wish\WishVoter;
use App\Service\Wish\Subscription\WishSubscriptionService;
use App\Validator\Wish\Subscription\WishSubscriptionValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishSubscriptionController extends Controller
{
    public function __construct(
        private WishSubscriptionValidator $wishSubscriptionValidator,
        private WishSubscriptionService $wishSubscriptionService
    )
    {   
    }

    #[Route('/wish/{wish}/subscription/create', name: 'wish_subscription_create')]
    public function create(Wish $wish, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_CREATE_SUBSCRIPTION, $wish);

        $user = $this->getUser();
        $this->wishSubscriptionValidator->validateCreate($user, $wish);
        
        $wish = $this->wishSubscriptionService->create(
            $wish,
            $user
        );

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/wish/{wish}/subscription/{wishSubscription}/remove', name: 'wish_subscription_remove')]
    public function remove(Wish $wish, WishSubscription $wishSubscription, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishSubscriptionVoter::ACTION_REMOVE, $wishSubscription);
        
        $this->wishSubscriptionService->remove(
            $wishSubscription
        );

        return $this->redirect($request->headers->get('referer'));
    }
}
