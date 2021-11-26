<?php

namespace App\Controller\Wishlist;

use App\Controller\Controller;
use App\Entity\Wish\Wish;
use App\Entity\Wishlist\Subscription\WishlistSubscription;
use App\Entity\Wishlist\Wishlist;
use App\Model\Wishlist\Action\CreateWishlist;
use App\Model\Wishlist\Action\EditWishlist;
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
        $user = $this->getUser();
        $this->denyAccessUnlessGranted(WishlistVoter::ACTION_SHOW, $wishlist);
        
        return $this->render('wishlist/show.html.twig', [ // @todo create template
            'controller_name' => 'WishlistController',
            'pageTitle' => "Lista", //@todo Translation
            'wishlist' => $wishlist,
            'wishlists' =>  $user ? $this->wishlistService->getsOwned($user) : new ArrayCollection()
        ]);
    }

    #[Route('/list/my', name: 'wishlist_show_my')]
    public function showOwned(): Response
    {
        $user = $this->getUser();

        return $this->render('wishlist/list.html.twig', [
            'controller_name' => 'WishlistController',
            'pageTitle' => "Moje listy", //@todo Translation
            'wishlists' => $this->wishlistService->getsOwned($user)
        ]);
    }

    #[Route('/list/friend', name: 'wishlist_show_friend')]
    public function showSubscribed(): Response
    {
        $user = $this->getUser();

        return $this->render('wishlist/list.html.twig', [
            'controller_name' => 'WishlistController',
            'pageTitle' => "Listy znajomych", //@todo Translation
            'wishlists' => $this->wishlistService->getsSubscribed($user)
        ]);
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
        $this->wishlistService->create(
            $this->getUser(),
            $createWishlist
        );
        
        return $this->redirectToRoute('wishlist_show_my');
    }

    #[Route('/list/edit/{wishlist}', name: 'wishlist_edit')]
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

        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/list/{wishlist}/remove', name: 'wishlist_remove', requirements: ['wishlist' => '\d+'])]
    public function remove(Wishlist $wishlist): Response
    {
        $this->denyAccessUnlessGranted(WishlistVoter::ACTION_REMOVE, $wishlist);
        $this->wishlistService->remove(
            $wishlist
        );
        return $this->redirectToRoute('wishlist_show_my');
    }

    #[Route('/list/{wishlist}/favorite', name: 'wishlist_favorite_switch', requirements: ['wishlist' => '\d+'])]
    public function switchFavorite(Wishlist $wishlist, Request $request) : Response
    {
        $this->denyAccessUnlessGranted(WishlistVoter::ACTION_SET_FAVORITE, $wishlist);
        $this->wishlistService->switchFavorite(
            $wishlist,
            $this->getUser()
        );

        return $this->redirect($request->headers->get('referer'));
    }
}
