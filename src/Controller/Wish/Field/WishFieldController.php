<?php

namespace App\Controller\Wish\Field;

use App\Controller\Controller;
use App\Entity\Wish\Field\WishField;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wish\Action\Field\CreateWishField;
use App\Security\Voter\Wish\Subscription\WishSubscriptionVoter;
use App\Security\Voter\Wish\WishVoter;
use App\Service\Wish\Field\WishFieldService;
use App\Validator\Wish\Field\WishFieldValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishFieldController extends Controller
{
    public function __construct(
        private WishFieldValidator $wishFieldValidator,
        private WishFieldService $wishFieldService
    )
    {   
    }

    #[Route('/wish/{wish}/field/create', name: 'wish_field_create')]
    public function create(Wish $wish, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_EDIT, $wish);

        /** @var CreateWishField */
        $createWishField = $this->deserialize(
            $request->request->all(),
            CreateWishField::class
        );

        $this->wishFieldValidator->validateCreate($createWishField);

        $wish = $this->wishFieldService->create(
            $wish,
            $createWishField
        );

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/wish/{wish}/field/{wishField}/remove', name: 'wish_field_remove')]
    public function remove(Wish $wish, WishField $wishField, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_EDIT, $wish);

        $this->wishFieldService->remove(
            $wishField
        );
        
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/wish/{wish}/field/{wishField}/important', name: 'wish_field_remove')]
    public function switchImportant(Wish $wish, WishField $wishField, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_EDIT, $wish);

        $this->wishFieldService->switchImportant(
            $wishField
        );
        
        return $this->redirect($request->headers->get('referer'));
    }
}
