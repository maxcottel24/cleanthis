<?php

namespace App\Entity;

use App\Repository\AppointementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointementsRepository::class)]
class Appointements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_appointement = null;

    #[ORM\ManyToOne(inversedBy: 'appointements')]
    private ?addresses $address = null;

    #[ORM\ManyToOne(inversedBy: 'appointements')]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'appointements')]
    private ?employee $employee = null;

    #[ORM\OneToMany(targetEntity: Operations::class, mappedBy: 'appointement')]
    private Collection $operations;

    public function __construct()
    {
        $this->operations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateAppointement(): ?\DateTimeImmutable
    {
        return $this->date_appointement;
    }

    public function setDateAppointement(\DateTimeImmutable $date_appointement): static
    {
        $this->date_appointement = $date_appointement;

        return $this;
    }

    public function getAddress(): ?addresses
    {
        return $this->address;
    }

    public function setAddress(?addresses $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getEmployee(): ?employee
    {
        return $this->employee;
    }

    public function setEmployee(?employee $employee): static
    {
        $this->employee = $employee;

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
            $operation->setAppointement($this);
        }

        return $this;
    }

    public function removeOperation(Operations $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getAppointement() === $this) {
                $operation->setAppointement(null);
            }
        }

        return $this;
    }
}
