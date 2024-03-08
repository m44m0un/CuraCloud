<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
 

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Regex(
        pattern: "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^\da-zA-Z]).{8,}$/",
        message: "Password must have at least 1 (uppercase,lowercase,number,symbol)."
    )]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    #[ORM\Column(nullable: true)]
    private ?string $firstName = null;
    
    #[Assert\Length(min: 2, max: 255)]
    #[ORM\Column(nullable: true)]
    private ?string $lastName = null;
    
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: "/^\d{8}$/",
        message: "Phone number should be 8 digits."
    )]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $phoneNumber = null;
    
    #[Assert\Date]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $birthDate = null;


    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $gender = null;
    
    #[Assert\Length(min: 3)]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $inscriptionDate = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $speciality = null;
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $certification = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $public_or_private = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $pharmacytype = null;

   
 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    
    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;
    
        return $this;
    }
    
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    
    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;
    
        return $this;
    }
    
    
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }
    
    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;
    
        return $this;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function setBirthDate(?string $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }
    
    public function setGender(?bool $gender): static
    {
        $this->gender = $gender;
    
        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getInscriptionDate(): ?\DateTimeInterface
    {
        return $this->inscriptionDate;
    }

    public function setInscriptionDate(?\DateTimeInterface $inscriptionDate): self
    {
        $this->inscriptionDate = $inscriptionDate;

        return $this;
    }

    public function getSpeciality(): ?string
    {
        return $this->speciality;
    }
    
    public function setSpeciality(?string $speciality): static
    {
        $this->speciality = $speciality;
    
        return $this;
    }

    public function getCertification(): ?string
    {
        return $this->certification;
    }
    
    public function setCertification(?string $certification): static
    {
        $this->certification = $certification;
    
        return $this;
    }

    public function getPharmacytype(): ?bool
    {
        return $this->pharmacytype;
    }
    
    public function setPharmacytype(?bool $pharmacytype): static
    {
        $this->pharmacytype = $pharmacytype;
    
        return $this;
    }

    public function getPublicOrPrivate(): ?bool
    {
        return $this->public_or_private;
    }
    
    public function setPublicOrPrivate(?bool $public_or_private): static
    {
        $this->public_or_private = $public_or_private;
    
        return $this;
    }
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function __toString()
    {
        // If you want to return the user's id as a string representation
        return strval($this->getId());
    }

    // Dans votre entité User
public function getFullName(): string
{
    return $this->getFirstName() . ' ' . $this->getLastName();
}

}
