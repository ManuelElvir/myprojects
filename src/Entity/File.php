<?php

namespace App\Entity;

use App\Repository\FileRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $file_name = null;

    #[ORM\Column]
    private ?float $file_size = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'files')]
    private ?FileType $fileType = null;

    #[ORM\ManyToOne(inversedBy: 'files')]
    private ?User $owner = null;

    #[ORM\ManyToOne(inversedBy: 'files')]
    private ?Task $task = null;

    #[ORM\ManyToOne(inversedBy: 'files')]
    private ?Comment $comment = null;
    
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function setFileName(string $file_name): self
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function getFileSize(): ?float
    {
        return $this->file_size;
    }

    public function setFileSize(float $file_size): self
    {
        $this->file_size = $file_size;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getFileType(): ?FileType
    {
        return $this->fileType;
    }

    public function setFileType(?FileType $fileType): self
    {
        $this->fileType = $fileType;

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

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

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

    public function toModel(): \App\Model\File
    {
        $model = new \App\Model\File();
        $model->filename = $this->file_name;
        $model->ownerName = $this->owner->getFullName();
        $model->type = $this->fileType->getName();
        $model->createdAt = $this->createdAt;
        $model->url = $this->url;

        return $model;
    }

}
