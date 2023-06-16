<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $username = null;

    #[ORM\Column(length: 40, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $first_name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $last_name = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar_url = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Team::class)]
    private Collection $teams;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Teammate::class, orphanRemoval: true)]
    private Collection $teammates;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Project::class)]
    private Collection $ownedProjects;

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'users')]
    private Collection $projects;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Milestone::class)]
    private Collection $ownedMilestones;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: File::class)]
    private Collection $files;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Task::class)]
    private Collection $ownedTasks;

    #[ORM\OneToMany(mappedBy: 'assignedTo', targetEntity: Task::class)]
    private Collection $assignedTasks;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Comment::class)]
    private Collection $comments;
    
    
    #[ORM\Column(type: 'datetime')]
    protected DateTime $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected DateTime $updated;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->teammates = new ArrayCollection();
        $this->ownedProjects = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->ownedMilestones = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->ownedTasks = new ArrayCollection();
        $this->assignedTasks = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function setAvatarUrl(?string $avatar_url): self
    {
        $this->avatar_url = $avatar_url;

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    #[ORM\PreUpdate]
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setOwner($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getOwner() === $this) {
                $team->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Teammate>
     */
    public function getTeammates(): Collection
    {
        return $this->teammates;
    }

    public function addTeammate(Teammate $teammate): self
    {
        if (!$this->teammates->contains($teammate)) {
            $this->teammates->add($teammate);
            $teammate->setUser($this);
        }

        return $this;
    }

    public function removeTeammate(Teammate $teammate): self
    {
        if ($this->teammates->removeElement($teammate)) {
            // set the owning side to null (unless already changed)
            if ($teammate->getUser() === $this) {
                $teammate->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getOwnedProjects(): Collection
    {
        return $this->ownedProjects;
    }

    public function addOwnedProject(Project $ownedProject): self
    {
        if (!$this->ownedProjects->contains($ownedProject)) {
            $this->ownedProjects->add($ownedProject);
            $ownedProject->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedProject(Project $ownedProject): self
    {
        if ($this->ownedProjects->removeElement($ownedProject)) {
            // set the owning side to null (unless already changed)
            if ($ownedProject->getOwner() === $this) {
                $ownedProject->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addUser($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->removeElement($project)) {
            $project->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Milestone>
     */
    public function getOwnedMilestones(): Collection
    {
        return $this->ownedMilestones;
    }

    public function addOwnedMilestone(Milestone $ownedMilestone): self
    {
        if (!$this->ownedMilestones->contains($ownedMilestone)) {
            $this->ownedMilestones->add($ownedMilestone);
            $ownedMilestone->setOwner($this);
        }

        return $this;
    }

    public function removeOwnedMilestone(Milestone $ownedMilestone): self
    {
        if ($this->ownedMilestones->removeElement($ownedMilestone)) {
            // set the owning side to null (unless already changed)
            if ($ownedMilestone->getOwner() === $this) {
                $ownedMilestone->setOwner(null);
            }
        }

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
            $file->setOwner($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getOwner() === $this) {
                $file->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getOwnedTasks(): Collection
    {
        return $this->ownedTasks;
    }

    public function addOwnedTask(Task $ownedTask): self
    {
        if (!$this->ownedTasks->contains($ownedTask)) {
            $this->ownedTasks->add($ownedTask);
            $ownedTask->setCreatedBy($this);
        }

        return $this;
    }

    public function removeOwnedTask(Task $ownedTask): self
    {
        if ($this->ownedTasks->removeElement($ownedTask)) {
            // set the owning side to null (unless already changed)
            if ($ownedTask->getCreatedBy() === $this) {
                $ownedTask->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getAssignedTasks(): Collection
    {
        return $this->assignedTasks;
    }

    public function addAssignedTask(Task $assignedTask): self
    {
        if (!$this->assignedTasks->contains($assignedTask)) {
            $this->assignedTasks->add($assignedTask);
            $assignedTask->setAssignedTo($this);
        }

        return $this;
    }

    public function removeAssignedTask(Task $assignedTask): self
    {
        if ($this->assignedTasks->removeElement($assignedTask)) {
            // set the owning side to null (unless already changed)
            if ($assignedTask->getAssignedTo() === $this) {
                $assignedTask->setAssignedTo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setOwner($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getOwner() === $this) {
                $comment->setOwner(null);
            }
        }

        return $this;
    }
}
