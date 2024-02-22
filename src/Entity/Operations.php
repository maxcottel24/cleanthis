<?php

namespace App\Entity;

use App\Repository\OperationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationsRepository::class)]
class Operations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?bool $is_valid = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $discount = null;

    #[ORM\Column(nullable: true)]
    private ?int $final_price = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    private ?typeOperation $type = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    private ?appointements $appointement = null;

    #[ORM\ManyToMany(targetEntity: employee::class, inversedBy: 'operations')]
    private Collection $employees;

    #[ORM\OneToOne(mappedBy: 'operation', cascade: ['persist', 'remove'])]
    private ?Invoices $invoices = null;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isIsValid(): ?bool
    {
        return $this->is_valid;
    }

    public function setIsValid(bool $is_valid): static
    {
        $this->is_valid = $is_valid;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getFinalPrice(): ?int
    {
        return $this->final_price;
    }

    public function setFinalPrice(?int $final_price): static
    {
        $this->final_price = $final_price;

        return $this;
    }

    public function getType(): ?typeOperation
    {
        return $this->type;
    }

    public function setType(?typeOperation $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAppointement(): ?appointements
    {
        return $this->appointement;
    }

    public function setAppointement(?appointements $appointement): static
    {
        $this->appointement = $appointement;

        return $this;
    }

    /**
     * @return Collection<int, employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(employee $employee): static
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
        }

        return $this;
    }

    public function removeEmployee(employee $employee): static
    {
        $this->employees->removeElement($employee);

        return $this;
    }

    public function getInvoices(): ?Invoices
    {
        return $this->invoices;
    }

    public function setInvoices(?Invoices $invoices): static
    {
        // unset the owning side of the relation if necessary
        if ($invoices === null && $this->invoices !== null) {
            $this->invoices->setOperation(null);
        }

        // set the owning side of the relation if necessary
        if ($invoices !== null && $invoices->getOperation() !== $this) {
            $invoices->setOperation($this);
        }

        $this->invoices = $invoices;

        return $this;
    }
}
