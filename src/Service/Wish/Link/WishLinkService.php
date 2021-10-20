<?php

namespace App\Service\Wish\Link;

use App\Entity\Wish\Link\WishLink;
use App\Entity\Wish\Wish;
use App\Model\Wish\Action\Link\CreateWishLink;
use App\Repository\Wish\Field\WishFieldRepository;
use App\Repository\Wish\Link\WishLinkRepository;

class WishLinkService
{
    public function __construct(
        private WishLinkRepository $wishLinkRepository
    )
    {}

    public function create(Wish $wish, CreateWishLink $createWishLink) : Wish
    {
        $this->wishLinkRepository->create(
            $wish,
            $createWishLink->getRawLink()
        );

        return $wish;
    }

    public function remove(
        WishLink $wishLink
    ) : void
    {
        $wishLink
            ->getWish()
            ->removeLink($wishLink);

        $this->wishLinkRepository->remove($wishLink);
    }
}