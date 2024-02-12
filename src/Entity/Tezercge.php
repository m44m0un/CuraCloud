<?php

namespace App\Entity;

use App\Repository\TezercgeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TezercgeRepository::class)]
class Tezercge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
