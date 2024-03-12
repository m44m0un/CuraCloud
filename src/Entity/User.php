<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Likes;
use App\Entity\Blog;
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
    #[ORM\Column(nullable:true)]
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

    #[ORM\Column(nullable: true)]
    private ?bool $isbanned = null;

    public function __construct()
    {
        $this->inscriptionDate= new \DateTime();
        $this->isbanned= 0;
        $this->blogs = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->dislikes = new ArrayCollection();
        $this->streams = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

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
    public function getPassword(): ?string
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

    public function Isbanned(): ?bool
    {
        return $this->isbanned;
    }

    public function setIsbanned(?bool $isbanned): static
    {
        $this->isbanned = $isbanned;

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

        /////BLOG ASSOCIATION START /////////
        #[ORM\OneToMany(mappedBy: "author", targetEntity: Blog::class, orphanRemoval: true)]
        private Collection $blogs;
    
        /**
         * @return Collection<int, Blog>
         */
        public function getBlogs(): Collection
        {
            return $this->blogs;
        }
    
        public function addBlog(Blog $blog): self
        {
            if (!$this->blogs->contains($blog)) {
                $this->blogs->add($blog);
                $blog->setAuthor($this);
            }
    
            return $this;
        }
    
        public function removeBlog(Blog $blog): self
        {
            if ($this->blogs->removeElement($blog)) {
                // set the owning side to null (unless already changed)
                if ($blog->getAuthor() === $this) {
                    $blog->setAuthor(null);
                }
            }
    
            return $this;
        }
    
    
    
        ////// BLOG ASSOCIATION END////////
    
    
    
        /////LIKE ASSOCIATION START ////////////
        #[ORM\OneToMany(mappedBy: 'user', targetEntity: Likes::class, orphanRemoval: true)]
        private Collection $likes;
    
    
        // ... (Existing code)
    
        /**
         * @return Collection<int, Like>
         */
        public function getLikes(): Collection
        {
            return $this->likes;
        }
    
        public function addLike(Likes $like): self
        {
            if (!$this->likes->contains($like)) {
                $this->likes->add($like);
                $like->setUser($this);
            }
    
            return $this;
        }
    
        public function removeLike(Likes $like): self
        {
            if ($this->likes->removeElement($like)) {
                // set the owning side to null (unless already changed)
                if ($like->getUser() === $this) {
                    $like->setUser(null);
                }
            }
    
            return $this;
        }
    
    
    
        ///LIKE ASSOCIATION END/////////
    
    
        ///// DISLIKE ASSOCIATION START ////////////
        #[ORM\OneToMany(mappedBy: 'user', targetEntity: Dislike::class, orphanRemoval: true)]
        private Collection $dislikes;
    
        // ... (existing code)
    
        /**
         * @return Collection<int, Dislike>
         */
        public function getDislikes(): Collection
        {
            return $this->dislikes;
        }
    
        public function addDislike(Dislike $dislike): self
        {
            if (!$this->dislikes->contains($dislike)) {
                $this->dislikes->add($dislike);
                $dislike->setUser($this);
            }
    
            return $this;
        }
    
        public function removeDislike(Dislike $dislike): self
        {
            if ($this->dislikes->removeElement($dislike)) {
                // set the owning side to null (unless already changed)
                if ($dislike->getUser() === $this) {
                    $dislike->setUser(null);
                }
            }
    
            return $this;
        }
    
    
    
        //////DISLIKE ASSOCIATION END///////
    
    
    
    
        /////STREAM ASSOCIATION START/////
    
        #[ORM\OneToMany(mappedBy: 'user', targetEntity: Stream::class, orphanRemoval: true)]
        private Collection $streams;
    
    
        /**
         * @return Collection<int, Stream>
         */
        public function getStreams(): Collection
        {
            return $this->streams;
        }
    
        public function addStream(Stream $stream): self
        {
            if (!$this->streams->contains($stream)) {
                $this->streams->add($stream);
                $stream->setUser($this);
            }
    
            return $this;
        }
    
        public function removeStream(Stream $stream): self
        {
            if ($this->streams->removeElement($stream)) {
                // set the owning side to null (unless already changed)
                if ($stream->getUser() === $this) {
                    $stream->setUser(null);
                }
            }
    
            return $this;
        }
    
    
    
    
        /////STREAM ASSOCIATION END ///////////
    
    
        ////MESSAGE STREAM ASSOCIATION /////
    
        #[ORM\OneToMany(mappedBy: 'user', targetEntity: MessageStream::class)]
        private $messages;
    
    
        /**
         * @return Collection|MessageStream[]
         */
        public function getMessages(): Collection
        {
            return $this->messages;
        }
    
    
    
        /////MESSAGE ASSOCIATION END//////
    
    
    
        //COMMENTS ASSOCIATION START ////
    
        #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;
    
    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }
    
    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUser($this);
        }
    
        return $this;
    }
    
    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }
    
        return $this;
    }
    
    
     //////COMMENTS ASSOCIATION END/////
        
    
}
