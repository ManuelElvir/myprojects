<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $name = null;

    #[ORM\Column(length: 60)]
    private ?string $value = null;

    #[ORM\ManyToMany(targetEntity: Permission::class, inversedBy: 'roles')]
    private Collection $permissions;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: Teammate::class)]
    private Collection $teammates;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->teammates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, Permission>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(Permission $permission): self
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions->add($permission);
        }

        return $this;
    }

    public function removePermission(Permission $permission): self
    {
        $this->permissions->removeElement($permission);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setRole($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getRole() === $this) {
                $user->setRole(null);
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
            $teammate->setRole($this);
        }

        return $this;
    }

    public function removeTeammate(Teammate $teammate): self
    {
        if ($this->teammates->removeElement($teammate)) {
            // set the owning side to null (unless already changed)
            if ($teammate->getRole() === $this) {
                $teammate->setRole(null);
            }
        }

        return $this;
    }
}
