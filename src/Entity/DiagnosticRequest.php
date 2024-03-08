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

    #[ORM\OneToMany(mappedBy: 'diagnosticRequest', targetEntity: Bilan::class)]
    private Collection $diagnosticBilans;

    #[ORM\ManyToOne]
    private ?User $id_patient = null;



    public function __construct()
    {
        $this->diagnosticBilans = new ArrayCollection();
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
    public function getDiagnosticBilans(): Collection
    {
        return $this->diagnosticBilans;
    }

    public function addDiagnosticBilan(Bilan $bilan): static
    {
        if (!$this->diagnosticBilans->contains($bilan)) {
            $this->diagnosticBilans->add($bilan);
            // No need to explicitly set the relationship here
        }

        return $this;
    }

    public function removeDiagnosticBilan(Bilan $bilan): static
    {
        if ($this->diagnosticBilans->removeElement($bilan)) {
            // set the owning side to null (unless already changed)
            if ($bilan->getDiagnosticRequest() === $this) {
                $bilan->setDiagnosticRequest(null);
            }
        }

        return $this;
    }

    public function getIdPatient(): ?User
    {
        return $this->id_patient;
    }

    public function setIdPatient(?User $id_patient): static
    {
        $this->id_patient = $id_patient;

        return $this;
    }

    public function getUserName(): ?string
{
    // Vérifiez si l'utilisateur associé existe
    $user = $this->getIdPatient();
    
    // Si l'utilisateur existe, retournez son nom complet (prénom + nom)
    if ($user) {
        return $user->getFirstName() . ' ' . $user->getLastName();
    }

    // Si l'utilisateur n'existe pas, retournez null ou un autre valeur par défaut
    return null;
}
}
