<?php

namespace App\Entity\Wish\Link;

use App\Entity\DoctrineEntity;
use App\Entity\Wish\Wish;
use App\Repository\Wish\Link\WishLinkRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: WishLinkRepository::class)]
class WishLink extends DoctrineEntity
{
    #[ManyToOne(inversedBy: "links", targetEntity: Wish::class)]
    private Wish $wish;

    #[Column(type: "text")]
    private string $rawLink;

    public function getWish() : Wish
    {
        return $this->wish;
    }

    public function setWish(Wish $wish) : self
    {
        $this->wish = $wish;

        return $this;
    }

    public function getRawLink() : string
    {
        return $this->rawLink;
    }

    public function setRawLink(string $rawLink) : self
    {
        $this->rawLink = $rawLink;

        return $this;
    }
}