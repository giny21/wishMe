<?php

namespace App\Service\Wish\Field;

use App\Entity\Wish\Field\WishField;
use App\Entity\Wish\Wish;
use App\Model\Wish\Action\Field\CreateWishField;
use App\Repository\Wish\Field\WishFieldRepository;

class WishFieldService
{
    public function __construct(
        private WishFieldRepository $wishFieldRepository
    )
    {}

    public function create(Wish $wish, CreateWishField $createWishField) : Wish
    {
        $this->wishFieldRepository->create(
            $wish,
            $createWishField->getName(),
            $createWishField->getValue()
        );

        return $wish;
    }

    public function switchImportant(WishField $wishField) : void
    {
        $this->wishFieldRepository->sets(
            $wishField,
            [
                "important" => !$wishField->getImportant()
            ]
        );
    }

    public function remove(
        WishField $wishField
    ) : void
    {
        $wishField
            ->getWish()
            ->removeField($wishField);

        $this->wishFieldRepository->remove($wishField);
    }
}