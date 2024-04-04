<?php

namespace App\Entity;

use App\Repository\MeetingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeetingRepository::class)]
class Meeting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $reservedAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Users::class, mappedBy: 'meetings')]
    private Collection $users;

    #[ORM\ManyToOne(inversedBy: 'meetings')]
    private ?Address $address = null;

    #[ORM\OneToMany(targetEntity: Operation::class, mappedBy: 'meeting')]
    private Collection $operations;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $floor_space = null;

    #[ORM\Column]
    private ?int $status = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->operations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservedAt(): ?\DateTimeImmutable
    {
        return $this->reservedAt;
    }

    public function setReservedAt(\DateTimeImmutable $reservedAt): static
    {
        $this->reservedAt = $reservedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addMeeting($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeMeeting($this);
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, Operation>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operation $operation): static
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
            $operation->setMeeting($this);
        }

        return $this;
    }

    public function removeOperation(Operation $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getMeeting() === $this) {
                $operation->setMeeting(null);
            }
        }

        return $this;
    }

    public function getFloorSpace(): ?string
    {
        return $this->floor_space;
    }

    public function setFloorSpace(string $floor_space): static
    {
        $this->floor_space = $floor_space;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }
   
    public function __toString(): string
    {
        return $this->description;
    }

    public function getUserWithJobTitleNull(): ?Users
{
    foreach ($this->getUsers() as $user) {
        if ($user->getJobTitle() === "Null") {
            return $user;
        }
    }
    return null; // Aucun utilisateur correspondant trouvé
}
}
