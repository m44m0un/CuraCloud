<?php


// src/Entity/Stream.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Stream
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title;

    #[ORM\Column(type: 'text')]
    private ?string $description;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt;

    #[ORM\Column(type: 'boolean')]
    private bool $isActive;

    public function __construct(User $user, string $title)
    {
        $this->user = $user;
        $this->title = $title;
        $this->createdAt = new \DateTimeImmutable();
        $this->isActive = true; // Set the isActive field to true by default
        $this->messages = new ArrayCollection();
    }
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }


    //////MESSAGE STREAM ASSOCIATION ///////

    #[ORM\OneToMany(mappedBy: 'stream', targetEntity: MessageStream::class)]
    private $messages;

    /**
     * @return Collection|MessageStream[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }
}

