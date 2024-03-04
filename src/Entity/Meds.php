<?php

namespace App\Entity;

use App\Repository\MedsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedsRepository::class)]
class Meds
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Please enter a name")]
    #[Assert\Length(min: 3, max: 120, minMessage: "Your name should be at least {{ limit }} characters")]
    #[ORM\Column(length: 120)]
    private ?string $name = null;

    #[Assert\NotBlank(message: "Please enter a dose")]
    #[Assert\Type(type: 'numeric', message: 'Please enter a valid dose')]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $dose = null;

    #[Assert\NotBlank(message: "Please enter a price")]
    #[Assert\Type(type: 'float', message: 'Please enter a valid price')]
    #[ORM\Column(type: 'float')]
    private ?float $price = null;

    #[ORM\ManyToMany(targetEntity: Prescription::class, mappedBy: 'medications')]
    private Collection $prescriptions;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDose(): ?string
    {
        return $this->dose;
    }

    public function setDose(string $dose): static
    {
        $this->dose = $dose;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Prescription>
     */
    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(Prescription $prescription): static
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions->add($prescription);
            $prescription->addMedication($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): static
    {
        if ($this->prescriptions->removeElement($prescription)) {
            $prescription->removeMedication($this);
        }

        return $this;
    }

}