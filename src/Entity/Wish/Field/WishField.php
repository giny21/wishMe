<?php

namespace App\Entity\Wish\Field;

use App\Entity\DoctrineEntity;
use App\Entity\Wish\Wish;
use App\Repository\Wish\Field\WishFieldRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity(repositoryClass: WishFieldRepository::class)]
class WishField extends DoctrineEntity
{
    #[ManyToOne(inversedBy: "fields", targetEntity: Wish::class)]
    private Wish $wish;

    #[Column(type: "text")]
    private string $name;

    #[Column(type: "text", nullable: true)]
    private string $value;

    #[Column(type: "boolean")]
    private bool $important;

    public function getWish() : Wish
    {
        return $this->wish;
    }

    public function setWish(Wish $wish) : self
    {
        $this->wish = $wish;

        return $this;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public function setValue(string $value) : self
    {
        $this->value = $value;

        return $this;
    }

    public function getImportant() : bool
    {
        return $this->important;
    }

    public function setImportant(bool $important) : self
    {
        $this->important = $important;

        return $this;
    }
}
