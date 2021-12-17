<?php

namespace App\Controller\Wishlist;

use App\Controller\Controller;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wishlist\Action\CreateWishlist;
use App\Model\Wishlist\Action\EditWishlist;
use App\Model\Wishlist\Action\SearchWishlist;
use App\Security\Voter\Wishlist\WishlistVoter;
use App\Service\Wishlist\WishlistService;
use App\Validator\Wishlist\WishlistValidator;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishlistController extends Controller
{
    public function __construct(
        SerializerInterface $serializer,
        private WishlistValidator $wishlistValidator,
        private WishlistService $wishlistService
    )
    {   
        parent::__construct($serializer);
    }

    #[Route('/list/{wishlist}', name: 'wishlist_show', requirements: ['wishlist' => '\d+'])]
    public function show(Wishlist $wishlist): Response
    {
        $this->denyAccessUnlessGranted(WishlistVoter::ACTION_SHOW, $wishlist);

        return $this->respond(
            [
                "wishlist" => $wishlist
            ]
        );
    }

    #[Route('/list/page/{page}/{sort}/{role}', name: 'wishlist_get_ids_by_page')]
    public function getIdsByPage(?int $page = 0, ?int $sort = 0, ?int $role = 0) : Response
    {
        $user = $this->getUser();

        return $this->respond(
            [
                "wishlists" => $this
                    ->wishlistService
                    ->getsUser($user, $page, $sort, $role)
                    ->map(
                        fn(Wishlist $wishlist) => $wishlist->getId()
                    )
            ]
        );
    }

    #[Route('/list/search', name: 'wishlist_search')]
    public function search(Request $request): Response
    {
        $user = $this->getUser();

        /** @var SearchWishlist */
        $searchWishlist = $this->deserialize(
            $request,
            SearchWishlist::class
        );

        $wishlists = $this->wishlistService->search($user, $searchWishlist);

        return $this->respond(
            [
                "wishlists" => $wishlists
            ]
        );
    }

    #[Route('/list/create', name: 'wishlist_create')]
    public function create(Request $request): Response
    {
        /** @var CreateWishlist */
        $createWishlist = $this->deserialize(
            $request,
            CreateWishlist::class
        );

        $this->wishlistValidator->validateCreate($createWishlist);
        $wishlist = $this->wishlistService->create(
            $this->getUser(),
            $createWishlist
        );

        return $this->respond(
            [
                "wishlist" => $wishlist
            ]
        );
    }

    #[Route('/list/{wishlist}/edit', name: 'wishlist_edit')]
    public function edit(Wishlist $wishlist, Request $request): Response
    {
        $this->denyAccessUnlessGranted(WishlistVoter::ACTION_EDIT, $wishlist);

        /** @var EditWishlist */
        $editWishlist = $this->deserialize(
            $request,
            EditWishlist::class
        );
        
        $this->wishlistValidator->validateEdit($editWishlist);
        $this->wishlistService->edit(
            $wishlist,
            $editWishlist
        );

        return $this->respond(
            [
                'wishlist' => $wishlist
            ]
        );
    }

    #[Route('/list/{wishlist}/remove', name: 'wishlist_remove', requirements: ['wishlist' => '\d+'])]
    public function remove(Wishlist $wishlist): Response
    {
        $this->denyAccessUnlessGranted(WishlistVoter::ACTION_REMOVE, $wishlist);
        $this->wishlistService->remove(
            $wishlist
        );

        return $this->respond();
    }

    #[Route('/list/{wishlist}/favorite', name: 'wishlist_favorite_switch', requirements: ['wishlist' => '\d+'])]
    public function switchFavorite(Wishlist $wishlist, Request $request) : Response
    {
        $this->denyAccessUnlessGranted(WishlistVoter::ACTION_SET_FAVORITE, $wishlist);
        $this->wishlistService->switchFavorite(
            $wishlist,
            $this->getUser()
        );

        return $this->respond();
    }
}
