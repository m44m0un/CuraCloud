<?php

namespace App\Entity;

use App\Repository\MedicalRecordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedicalRecordRepository::class)]
class MedicalRecord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Medical history cannot be blank.")]
    #[Assert\Length(max: 255, maxMessage: "Medical history must be at most {{ limit }} characters.")]
    private ?string $medicalHistory = null;

    #[ORM\Column(length: 255)]
    private ?string $surgicalHistory = null;

    #[ORM\Column(length: 255)]
    private ?string $familyHistory = null;

    #[ORM\Column(length: 255)]
    private ?string $allergies = null;

    #[ORM\Column]
    private ?float $height = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column(length: 255)]
    private ?string $bloodType = null;

    #[ORM\Column(length: 255)]
    private ?string $diseases = null;

    #[ORM\Column(length: 255)]
    private ?string $medications = null;

    #[ORM\Column(length: 255)]
    private ?string $vaccines = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedicalHistory(): ?string
    {
        return $this->medicalHistory;
    }

    public function setMedicalHistory(string $medicalHistory): static
    {
        $this->medicalHistory = $medicalHistory;

        return $this;
    }

    public function getSurgicalHistory(): ?string
    {
        return $this->surgicalHistory;
    }

    public function setSurgicalHistory(string $surgicalHistory): static
    {
        $this->surgicalHistory = $surgicalHistory;

        return $this;
    }

    public function getFamilyHistory(): ?string
    {
        return $this->familyHistory;
    }

    public function setFamilyHistory(string $familyHistory): static
    {
        $this->familyHistory = $familyHistory;

        return $this;
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function setAllergies(string $allergies): static
    {
        $this->allergies = $allergies;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getBloodType(): ?string
    {
        return $this->bloodType;
    }

    public function setBloodType(string $bloodType): static
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    public function getDiseases(): ?string
    {
        return $this->diseases;
    }

    public function setDiseases(string $diseases): static
    {
        $this->diseases = $diseases;

        return $this;
    }

    public function getMedications(): ?string
    {
        return $this->medications;
    }

    public function setMedications(string $medications): static
    {
        $this->medications = $medications;

        return $this;
    }

    public function getVaccines(): ?string
    {
        return $this->vaccines;
    }

    public function setVaccines(string $vaccines): static
    {
        $this->vaccines = $vaccines;

        return $this;
    }
}
