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

        // najjem nzid later attributes like :(chronicConditions, pastInfections, or familyGeneticHistory)
        //                                     :smokingStatus, alcoholConsumption, exerciseFrequency
        //                                     : mentalHealthHistory ,dental health or stressLevels (maybe)
        //                                     : emergencyContactName, relationshipToPatient, emergencyContactPhone
                                    // maybe 

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the patient's medical history.")]
    private ?string $medicalHistory = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the patient's surgical history.")]
    private ?string $surgicalHistory = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the patient's family history.")]
    private ?string $familyHistory = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the patient's allergies.")]
    private ?string $allergies = null;

    #[ORM\Column]
        #[Assert\Range(
            min: 50,
            max: 250,
            notInRangeMessage: 'You must be between {{ min }}cm and {{ max }}cm tall to enter',
        )]
    
    private ?float $height = null;

    #[ORM\Column]
    #[Assert\Range(
        min: 25,
        max: 250,
        notInRangeMessage: 'You must be between {{ min }}Kg and {{ max }}Kg tall to enter',
    )]
    private ?float $weight = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the patient's blood type.")]
    private ?string $bloodType = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the patient's diagnosed diseases.")]
    private ?string $diseases = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the patient's current medications.")]
    private ?string $medications = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the patient's vaccination history.")]
    private ?string $vaccines = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please enter the patient's name.")]
    #[Assert\Length(
          min: 2,
          max: 100,
          minMessage: "The patient's name must be at least {{ limit }} characters long.",
          maxMessage: "The patient's name cannot be longer than {{ limit }} characters."
          )]
    private ?string $patientName = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $id_patient = null;

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

    public function getPatientName(): ?string
    {
        return $this->patientName;
    }

    public function setPatientName(string $patientName): static
    {
        $this->patientName = $patientName;

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
}
