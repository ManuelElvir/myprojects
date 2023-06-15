<?php

namespace App\Entity;

use App\Repository\ProjectSettingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: ProjectSettingRepository::class)]
class ProjectSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'projectSetting', cascade: ['persist', 'remove'])]
    private ?Project $project = null;

    #[JoinTable(name: 'project_setting_status')]
    #[ORM\ManyToMany(targetEntity: Status::class)]
    private Collection $project_status;

    #[JoinTable(name: 'project_setting_milestone_status')]
    #[ORM\ManyToMany(targetEntity: Status::class)]
    private Collection $milestone_status;

    #[JoinTable(name: 'project_setting_task_status')]
    #[ORM\ManyToMany(targetEntity: Status::class)]
    private Collection $task_status;

    public function __construct()
    {
        $this->project_status = new ArrayCollection();
        $this->milestone_status = new ArrayCollection();
        $this->task_status = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Status>
     */
    public function getProjectStatus(): Collection
    {
        return $this->project_status;
    }

    public function addProjectStatus(Status $projectStatus): self
    {
        if (!$this->project_status->contains($projectStatus)) {
            $this->project_status->add($projectStatus);
        }

        return $this;
    }

    public function removeProjectStatus(Status $projectStatus): self
    {
        $this->project_status->removeElement($projectStatus);

        return $this;
    }

    /**
     * @return Collection<int, Status>
     */
    public function getMilestoneStatus(): Collection
    {
        return $this->milestone_status;
    }

    public function addMilestoneStatus(Status $milestoneStatus): self
    {
        if (!$this->milestone_status->contains($milestoneStatus)) {
            $this->milestone_status->add($milestoneStatus);
        }

        return $this;
    }

    public function removeMilestoneStatus(Status $milestoneStatus): self
    {
        $this->milestone_status->removeElement($milestoneStatus);

        return $this;
    }

    /**
     * @return Collection<int, Status>
     */
    public function getTaskStatus(): Collection
    {
        return $this->task_status;
    }

    public function addTaskStatus(Status $taskStatus): self
    {
        if (!$this->task_status->contains($taskStatus)) {
            $this->task_status->add($taskStatus);
        }

        return $this;
    }

    public function removeTaskStatus(Status $taskStatus): self
    {
        $this->task_status->removeElement($taskStatus);

        return $this;
    }
}
