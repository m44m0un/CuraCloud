<?php
namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
class Appointment
{

        // najjem nzid later attributes like :(Duration: Expected or allocated duration of the appointment.
        // :Location: The location of the appointment, which could be a physical address for in-person visits or a link for telehealth sessions.
        //         :ReminderSent: Indicates whether a reminder (email, SMS, etc.) has been sent to the patient.
        //           :InsuranceInformation: Details about the patient’s insurance that may be relevant for the appointment.
        //           :FollowUpRequired: Indicates whether a follow-up appointment is necessary.


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The description cannot be blank.")]
    #[Assert\Length(
        max: 255,
        maxMessage: "The description cannot be longer than {{ limit }} characters."
    )]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The status cannot be blank.")]
    #[Assert\Choice(choices: ['accepted','scheduled', 'completed', 'declined'], message: "Choose a valid status.")]
    private ?string $status ='Scheduled';

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: "The start date cannot be null.")]
    #[Assert\Type(\DateTimeInterface::class, message: "The start date must be a valid date.")]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message: "The end date cannot be null.")]
    #[Assert\Type(\DateTimeInterface::class, message: "The end date must be a valid date.")]
    #[Assert\GreaterThan(propertyPath: 'startDate', message: "The end date must be after the start date.")]
    private ?\DateTimeInterface $endDate = null;
    

    #[ORM\ManyToOne]
    private ?User $id_user = null;

    #[ORM\ManyToOne]
    private ?User $id_doctor = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

  
    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdDoctor(): ?User
    {
        return $this->id_doctor;
    }

    public function setIdDoctor(?User $id_doctor): static
    {
        $this->id_doctor = $id_doctor;

        return $this;
    }

}