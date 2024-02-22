<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?Users $user = null;

    #[ORM\Column]
    private ?int $superior = null;

    #[ORM\OneToMany(targetEntity: Appointements::class, mappedBy: 'employee')]
    private Collection $appointements;

    #[ORM\ManyToMany(targetEntity: Operations::class, mappedBy: 'employees')]
    private Collection $operations;

    public function __construct()
    {
        $this->appointements = new ArrayCollection();
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getSuperior(): ?int
    {
        return $this->superior;
    }

    public function setSuperior(int $superior): static
    {
        $this->superior = $superior;

        return $this;
    }

    /**
     * @return Collection<int, Appointements>
     */
    public function getAppointements(): Collection
    {
        return $this->appointements;
    }

    public function addAppointement(Appointements $appointement): static
    {
        if (!$this->appointements->contains($appointement)) {
            $this->appointements->add($appointement);
            $appointement->setEmployee($this);
        }

        return $this;
    }

    public function removeAppointement(Appointements $appointement): static
    {
        if ($this->appointements->removeElement($appointement)) {
            // set the owning side to null (unless already changed)
            if ($appointement->getEmployee() === $this) {
                $appointement->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Operations>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(Operations $operation): static
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
            $operation->addEmployee($this);
        }

        return $this;
    }

    public function removeOperation(Operations $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            $operation->removeEmployee($this);
        }

        return $this;
    }
}
