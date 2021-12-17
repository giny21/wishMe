<?php

namespace App\Controller\Wish;

use App\Controller\Controller;
use App\Entity\Wish\Wish;
use App\Model\Wish\Action\CreateWish;
use App\Model\Wish\Action\EditWish;
use App\Security\Voter\Wish\WishVoter;
use App\Security\Voter\Wishlist\WishlistVoter;
use App\Service\Wish\WishService;
use App\Service\Wishlist\WishlistService;
use App\Validator\Wish\WishValidator;
use Exception;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends Controller
{
    public function __construct(
        SerializerInterface $serializer,
        private WishValidator $wishValidator,
        private WishService $wishService,
        private WishlistService $wishlistService
    )
    {   
        parent::__construct($serializer);
    }

    #[Route('/wish/{wish}', name: 'wish_show', requirements: ['wish' => '\d+'])]
    public function show(Wish $wish): Response
    {
        $user = $this->getUser();

        return $this->respond(
            [
                "wish" => $wish
            ]
        );
    }
    
    #[Route('/wish/page/{page}/{sort}/{role}', name: 'wish_get_ids_by_page')]
    public function getIdsByPage(?int $page = 0, ?int $sort = 0, ?int $role = 0): Response
    {
        $user = $this->getUser();

        return $this->respond(
            [
                "wishes" => $this
                    ->wishService
                    ->getsUser($user, $page, $sort, $role)
                    ->map(
                        fn(Wish $wish) => $wish->getId()
                    )
            ]
        );
    }

    #[Route('/wish/{wish}/remove', name: 'wish_remove', requirements: ['wish' => '\d+'])]
    public function remove(Wish $wish, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_REMOVE, $wish);

        $this->wishService->remove(
            $wish
        );

        return $this->respond();
    }

    #[Route('/wish/create', name: 'wish_create')]
    public function create(Request $request): Response
    {
        /** @var CreateWish */
        $createWish = $this->deserialize(
            $request,
            CreateWish::class
        );
        $this->wishValidator->validateCreate($createWish);
        
        foreach($createWish->getWishlists() as $wishlist)
            $this->denyAccessUnlessGranted(WishlistVoter::ACTION_EDIT, $wishlist);

        $wish = $this->wishService->create(
            $createWish,
            $this->getUser()
        );

        return $this->respond(
            [
                "wish" => $wish
            ]
        );
    }

    #[Route('/wish/{wish}/edit', name: 'wish_edit')]
    public function edit(Wish $wish, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_EDIT, $wish);

        /** @var EditWish */
        $editWish = $this->deserialize(
            $request,
            EditWish::class
        );
        $this->wishValidator->validateEdit($editWish);
        
        foreach($editWish->getWishlists() as $wishlist)
            $this->denyAccessUnlessGranted(WishlistVoter::ACTION_EDIT, $wishlist);

        $this->wishService->edit(
            $wish,
            $editWish
        );

        return $this->respond(
            [
                'wish' => $wish
            ]
        );
    }

    #[Route('/wish/{wish}/fulfilled', name: 'wish_fulfilled_switch', requirements: ['wish' => '\d+'])]
    public function switchFulfilled(Wish $wish, Request $request): Response
    {
        // if($this->getUser())
        $this->denyAccessUnlessGranted(WishVoter::ACTION_SET_FULFILLED, $wish);

        $this->wishService->switchFulfilled($wish);

        return $this->respond();
    }
}
