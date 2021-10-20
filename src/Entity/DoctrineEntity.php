<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

abstract class DoctrineEntity
{
    #[Id, Column(type:"integer"), GeneratedValue(strategy: "AUTO")]
    protected ?int $id = null;

    public function __construct()
    {}

    public function getId(): ?int
    {
        return $this->id;
    }
}