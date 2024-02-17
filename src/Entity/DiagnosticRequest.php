<?php

namespace App\Entity;

use App\Repository\DiagnosticRequestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiagnosticRequestRepository::class)]
class DiagnosticRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $analyseType = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $doctorNotes = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $radioType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnalyseType(): ?string
    {
        return $this->analyseType;
    }

    public function setAnalyseType(string $analyseType): static
    {
        $this->analyseType = $analyseType;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDoctorNotes(): ?string
    {
        return $this->doctorNotes;
    }

    public function setDoctorNotes(?string $doctorNotes): static
    {
        $this->doctorNotes = $doctorNotes;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getRadioType(): ?string
    {
        return $this->radioType;
    }

    public function setRadioType(?string $radioType): static
    {
        $this->radioType = $radioType;

        return $this;
    }
}
