<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'ownedTasks')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'assignedTasks')]
    private ?User $assignedTo = null;

    #[ORM\OneToMany(mappedBy: 'task', targetEntity: File::class)]
    private Collection $files;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Milestone $milestone = null;

    #[ORM\ManyToOne(inversedBy: 'tasks')]
    private ?Project $project = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'tasks')]
    private Collection $tags;

    #[ORM\OneToOne(mappedBy: 'task', cascade: ['persist', 'remove'])]
    private ?Discussion $discussion = null;

    #[ORM\Column(type: 'datetime')]
    protected DateTime $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected DateTime $updatedAt;
    public function __construct()
    {
        $this->files = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getAssignedTo(): ?User
    {
        return $this->assignedTo;
    }

    public function setAssignedTo(?User $assignedTo): self
    {
        $this->assignedTo = $assignedTo;

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
            $file->setTask($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getTask() === $this) {
                $file->setTask(null);
            }
        }

        return $this;
    }

    public function getMilestone(): ?Milestone
    {
        return $this->milestone;
    }

    public function setMilestone(?Milestone $milestone): self
    {
        $this->milestone = $milestone;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

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

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getDiscussion(): ?Discussion
    {
        return $this->discussion;
    }

    public function setDiscussion(?Discussion $discussion): self
    {
        // unset the owning side of the relation if necessary
        if ($discussion === null && $this->discussion !== null) {
            $this->discussion->setTask(null);
        }

        // set the owning side of the relation if necessary
        if ($discussion !== null && $discussion->getTask() !== $this) {
            $discussion->setTask($this);
        }

        $this->discussion = $discussion;

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
}
