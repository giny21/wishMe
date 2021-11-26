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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends Controller
{
    public function __construct(
        private WishValidator $wishValidator,
        private WishService $wishService,
        private WishlistService $wishlistService
    )
    {   
    }

    #[Route('/wish/my', name: 'wish_show_my')]
    public function showOwned(): Response
    {
        $user = $this->getUser();

        return $this->render('wish/list.html.twig', [
            'controller_name' => 'WishController',
            'pageTitle' => "Moje życzenia", //@todo Translation
            'wishes' => $this->wishService->getsOwned($user)->toArray(),
            'wishlists' => $this->wishlistService->getsOwned($user)
        ]);
    }

    #[Route('/wish/friend', name: 'wish_show_friend')]
    public function showSubscribed(): Response
    {
        $user = $this->getUser();

        return $this->render('wish/list.html.twig', [
            'controller_name' => 'WishController',
            'pageTitle' => "Życzenia znajomych", //@todo Translation
            'wishes' => $this->wishService->getsSubscribed($user),
        ]);
    }

    #[Route('/wish/{wish}/remove', name: 'wish_remove', requirements: ['wish' => '\d+'])]
    public function remove(Wish $wish, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_REMOVE, $wish);

        $this->wishService->remove(
            $wish
        );

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/wish/create', name: 'wish_create')]
    public function create(Request $request): Response
    {
        /** @var CreateWish */
        $createWish = $this->deserialize(
            $request,
            CreateWish::class,
            [
                'wishlists' => fn(array $ids) => $this->wishlistService->gets($ids)->toArray()
            ]
        );
        $this->wishValidator->validateCreate($createWish);
        
        foreach($createWish->getWishlists() as $wishlist)
            $this->denyAccessUnlessGranted(WishlistVoter::ACTION_EDIT, $wishlist);

        $this->wishService->create(
            $createWish,
            $this->getUser()
        );

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/wish/edit/{wish}', name: 'wish_edit')]
    public function edit(Wish $wish, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishVoter::ACTION_EDIT, $wish);

        /** @var EditWish */
        $editWish = $this->deserialize(
            $request,
            EditWish::class,
            [
                'wishlists' => fn(array $ids) => $this->wishlistService->gets($ids)->toArray()
            ]
        );
        $this->wishValidator->validateEdit($editWish);
        
        foreach($editWish->getWishlists() as $wishlist)
            $this->denyAccessUnlessGranted(WishlistVoter::ACTION_EDIT, $wishlist);

        $this->wishService->edit(
            $wish,
            $editWish
        );

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/wish/{wish}/fulfilled', name: 'wish_fulfilled_switch', requirements: ['wish' => '\d+'])]
    public function switchFulfilled(Wish $wish, Request $request): Response
    {
        // if($this->getUser())
        $this->denyAccessUnlessGranted(WishVoter::ACTION_SET_FULFILLED, $wish);

        $this->wishService->switchFulfilled($wish);

        return $this->redirect($request->headers->get('referer'));
    }
}
