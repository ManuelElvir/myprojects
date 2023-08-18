<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: File::class)]
    private Collection $files;

    #[ORM\Column(nullable: true)]
    private ?int $repliedTo = null;
    
    #[ORM\Column(type: 'datetime')]
    protected DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected DateTime $updatedAt;

    #[ORM\PrePersist]
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
    }

    #[ORM\PreUpdate]
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
            $file->setComment($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getComment() === $this) {
                $file->setComment(null);
            }
        }

        return $this;
    }

    public function getRepliedTo(): ?int
    {
        return $this->repliedTo;
    }

    public function setRepliedTo(?int $repliedTo): self
    {
        $this->repliedTo = $repliedTo;

        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function toModel(): \App\Model\Comment
    {
        $model = new \App\Model\Comment();
        $model->content = $this->content;
        $model->authorName = $this->owner->getFullName();
        $model->sentAt = $this->createdAt;

        /**
         * @var File $file
         */
        foreach ($this->files as $file) {
            $commentFile = new \App\Model\File();
            $commentFile->filename = $file->getFileName();
            $commentFile->url = $file->getUrl();
            $commentFile->ownerName = $file->getOwner()->getFullName();

            $model->files[] = $commentFile;
        }

        return $model;
    }
}
