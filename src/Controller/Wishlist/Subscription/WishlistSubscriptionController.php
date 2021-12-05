<?php

namespace App\Controller\Wishlist\Subscription;

use App\Controller\Controller;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wishlist\Action\Subscription\CreateWishlistSubscription;
use App\Security\Voter\Wishlist\Subscription\WishlistSubscriptionVoter;
use App\Security\Voter\Wishlist\WishlistVoter;
use App\Service\Wishlist\Subscription\WishlistSubscriptionService;
use App\Validator\Wishlist\Subscription\WishlistSubscriptionValidator;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishlistSubscriptionController extends Controller
{
    public function __construct(
        SerializerInterface $serializer,
        private WishlistSubscriptionValidator $wishlistSubscriptionValidator,
        private WishlistSubscriptionService $wishlistSubscriptionService
    )
    {   
        parent::__construct($serializer);
    }

    #[Route('/list/{wishlist}/subscription/create', name: 'wishlist_subscription_create')]
    public function create(Wishlist $wishlist, Request $request): Response
    {
        /** @var CreateWishlistSubscription */
        $createWishlistSubscription = $this->deserialize(
            $request,
            CreateWishlistSubscription::class
        );
        $this->denyAccessUnlessGranted(WishlistVoter::ACTION_EDIT, $wishlist);

        $this->wishlistSubscriptionValidator->validateCreate($wishlist, $createWishlistSubscription);
        $wishlist = $this->wishlistSubscriptionService->create(
            $wishlist,
            $createWishlistSubscription
        );

        return $this->respond(
            [
                "wishlist" => $wishlist
            ]
        );
    }

    #[Route('/list/{wishlist}/subscription/{wishlistSubscription}/remove', name: 'wishlist_subscription_remove')]
    public function remove(Wishlist $wishlist, WishlistSubscription $wishlistSubscription): Response
    {
        $this->denyAccessUnlessGranted(WishlistSubscriptionVoter::ACTION_REMOVE, $wishlistSubscription);

        $this->wishlistSubscriptionValidator->validateRemove($wishlist, $wishlistSubscription);
        $this->wishlistSubscriptionService->remove(
            $wishlistSubscription
        );

        return $this->respond(
            [
                "wishlist" => $wishlist
            ]
        );
    }
}
