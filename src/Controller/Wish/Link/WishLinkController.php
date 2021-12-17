<?php

namespace App\Controller\Wish\Link;

use App\Controller\Controller;
use App\Entity\Wish\Link\WishLink;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wish\Action\Link\CreateWishLink;
use App\Security\Voter\Wish\WishVoter;
use App\Service\Wish\Link\WishLinkService;
use App\Validator\Wish\Link\WishLinkValidator;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishLinkController extends Controller
{
    public function __construct(
        SerializerInterface $serializer,
        private WishLinkValidator $wishLinkValidator,
        private WishLinkService $wishLinkService
    )
    {   
        parent::__construct($serializer);
    }

    #[Route('/wish/{wish}/link/create', name: 'wish_link_create')]
    public function create(Wish $wish, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_EDIT, $wish);

        /** @var CreateWishLink */
        $createWishLink = $this->deserialize(
            $request,
            CreateWishLink::class
        );

        $this->wishLinkValidator->validateCreate($createWishLink);

        $wish = $this->wishLinkService->create(
            $wish,
            $createWishLink
        );

        return $this->respond(
            [
                "wish" => $wish
            ]
        );
    }

    #[Route('/wish/{wish}/link/{wishLink}/remove', name: 'wish_link_remove')]
    public function remove(Wish $wish, WishLink $wishLink, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_EDIT, $wish);

        $this->wishLinkService->remove(
            $wishLink
        );

        return $this->respond(
            [
                "wish" => $wish
            ]
        );
    }
}
