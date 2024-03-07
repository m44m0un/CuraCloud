<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use PSR\Log\LoggerInterface;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    
    private ?\DateTimeInterface $submissionDate = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Blog $blogId = null;

    public function __construct()
    {
        $this->setSubmissionDateValue(); // Call the method in the constructor
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
    #[ORM\PrePersist]

    public function getSubmissionDate(): ?\DateTimeInterface
    {
        return $this->submissionDate;
    }
    #[ORM\PrePersist]
    public function setSubmissionDateValue(): void
    {
        if ($this->submissionDate === null) {
            $this->submissionDate = new \DateTime();
            // $logger->debug('Debug: setSubmissionDateValue called!');
            
        }
    }
    
    public function setSubmissionDate(\DateTimeInterface $submissionDate = null): static
    {
        $this->submissionDate = $submissionDate ?? new \DateTime();
        $this->setSubmissionDateValue(); // Call the method to ensure the value is set
    
        return $this;
    }

    public function getBlogId(): ?Blog
    {
        return $this->blogId;
    }

    public function setBlogId(?Blog $blogId): static
    {
        $this->blogId = $blogId;

        return $this;
    }
}
