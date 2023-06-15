<?php

namespace App\Entity;

use App\Repository\MilestoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MilestoneRepository::class)]
class Milestone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'milestones')]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'milestones')]
    private ?Project $project = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $dependencies = [];

    #[ORM\ManyToOne(inversedBy: 'ownedMilestones')]
    private ?User $owner = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $planned_start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $planned_end_date = null;

    #[ORM\OneToMany(mappedBy: 'milestone', targetEntity: Task::class)]
    private Collection $tasks;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'milestones')]
    private Collection $tags;

    #[ORM\OneToOne(mappedBy: 'milestone', cascade: ['persist', 'remove'])]
    private ?Discussion $discussion = null;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
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

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

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

    public function getDependencies(): array
    {
        return $this->dependencies;
    }

    public function setDependencies(?array $dependencies): self
    {
        $this->dependencies = $dependencies;

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

    public function getPlannedStartDate(): ?\DateTimeInterface
    {
        return $this->planned_start_date;
    }

    public function setPlannedStartDate(?\DateTimeInterface $planned_start_date): self
    {
        $this->planned_start_date = $planned_start_date;

        return $this;
    }

    public function getPlannedEndDate(): ?\DateTimeInterface
    {
        return $this->planned_end_date;
    }

    public function setPlannedEndDate(?\DateTimeInterface $planned_end_date): self
    {
        $this->planned_end_date = $planned_end_date;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setMilestone($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getMilestone() === $this) {
                $task->setMilestone(null);
            }
        }

        return $this;
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
            $this->discussion->setMilestone(null);
        }

        // set the owning side of the relation if necessary
        if ($discussion !== null && $discussion->getMilestone() !== $this) {
            $discussion->setMilestone($this);
        }

        $this->discussion = $discussion;

        return $this;
    }
}
