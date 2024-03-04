<?php

namespace App\Entity;

use App\Repository\DiagnosticRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DiagnosticRequestRepository::class)]
class DiagnosticRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Please choose a type of analysis.")]
    private ?string $analyseType = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Please choose a status.")]
    private ?string $status = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $doctorNotes = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message:"Please choose a type of radiologie.")]
    private ?string $radioType = null;

    #[ORM\OneToMany(mappedBy: 'idDiagnosticRequest', targetEntity: Bilan::class)]
    private Collection $idBilan;

    #[ORM\OneToMany(mappedBy: 'diagnosticRequest', targetEntity: Bilan::class)]
    private Collection $id_bilan;

    public function __construct()
    {
        $this->idBilan = new ArrayCollection();
        $this->id_bilan = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Bilan>
     */
    public function getIdBilan(): Collection
    {
        return $this->idBilan;
    }

    public function addIdBilan(Bilan $idBilan): static
    {
        if (!$this->idBilan->contains($idBilan)) {
            $this->idBilan->add($idBilan);
            $idBilan->setIdDiagnosticRequest($this);
        }

        return $this;
    }

    public function removeIdBilan(Bilan $idBilan): static
    {
        if ($this->idBilan->removeElement($idBilan)) {
            // set the owning side to null (unless already changed)
            if ($idBilan->getIdDiagnosticRequest() === $this) {
                $idBilan->setIdDiagnosticRequest(null);
            }
        }

        return $this;
    }
}
