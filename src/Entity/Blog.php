<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: BlogRepository::class)]
#[Vich\Uploadable]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $content = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $title = null;

    #[Vich\UploadableField(mapping: "blog_images", fileNameProperty: "image")]
    #[Assert\Image(
        maxSize: "5M",
        mimeTypes: ["image/jpeg", "image/png", "image/gif"]
    )]
    private ?File $imageFile = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $submissionDate = null;

    #[ORM\OneToMany(mappedBy: "blogId", targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
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

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->submissionDate = new \DateTimeImmutable(); // Update submission date on file change
        }
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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
        }
    }

    public function setSubmissionDate(?\DateTimeInterface $submissionDate = null): self
    {
        $this->submissionDate = $submissionDate ?? new \DateTime();
        $this->setSubmissionDateValue(); // Call the method to ensure the value is set

        return $this;
    }

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
            $comment->setBlogId($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
       if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
if ($comment->getBlogId() === $this) {
                $comment->setBlogId(null);
            }
        }

        return $this;
    }
}