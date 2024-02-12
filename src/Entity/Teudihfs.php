<?php

namespace App\Entity;

use App\Repository\TeudihfsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeudihfsRepository::class)]
class Teudihfs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ifeuzh = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIfeuzh(): ?string
    {
        return $this->ifeuzh;
    }

    public function setIfeuzh(string $ifeuzh): static
    {
        $this->ifeuzh = $ifeuzh;

        return $this;
    }
}
