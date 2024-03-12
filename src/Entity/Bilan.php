<?php

namespace App\Entity;

use App\Repository\BilanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


#[ORM\Entity(repositoryClass: BilanRepository::class)]
#[Vich\Uploadable]
class Bilan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $realisationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $result = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $labComment = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $submissionDate = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'id_bilan')]
    private ?DiagnosticRequest $diagnosticRequest = null;


    #[ORM\Column(length: 255 , nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'resultats' , fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

      /**
       * @ORM\Column(type="datetime")
       */

    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRealisationDate(): ?\DateTimeInterface
    {
        return $this->realisationDate;
    }

    public function setRealisationDate(\DateTimeInterface $realisationDate): static
    {
        $this->realisationDate = $realisationDate;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): static
    {
        $this->result = $result;

        return $this;
    }

    public function getLabComment(): ?string
    {
        return $this->labComment;
    }

    public function setLabComment(?string $labComment): static
    {
        $this->labComment = $labComment;

        return $this;
    }

    public function getSubmissionDate(): ?\DateTimeInterface
    {
        return $this->submissionDate;
    }

    public function setSubmissionDate(\DateTimeInterface $submissionDate): static
    {
        $this->submissionDate = $submissionDate;

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

    public function getDiagnosticRequest(): ?DiagnosticRequest
    {
        return $this->diagnosticRequest;
    }

    public function setDiagnosticRequest(?DiagnosticRequest $diagnosticRequest): static
    {
        $this->diagnosticRequest = $diagnosticRequest;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }



    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;

        // Si l'image est définie, il est nécessaire de changer également la date de mise à jour pour que VichUploaderBundle fonctionne correctement.
        if ($imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }




}
