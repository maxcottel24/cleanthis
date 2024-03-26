<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    #[ORM\Column(nullable: true)]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finished_at = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $floor_space = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    private ?meeting $meeting = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    private ?TypeOperation $typeOperation = null;

    #[ORM\Column(nullable: true)]
    private ?int $cleanliness = null;

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
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): static
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finished_at;
    }

    public function setFinishedAt(\DateTimeInterface $finished_at): static
    {
        $this->finished_at = $finished_at;

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

    public function getFloorSpace(): ?string
    {
        return $this->floor_space;
    }

    public function setFloorSpace(string $floor_space): static
    {
        $this->floor_space = $floor_space;

        return $this;
    }

    public function getMeeting(): ?meeting
    {
        return $this->meeting;
    }

    public function setMeeting(?meeting $meeting): static
    {
        $this->meeting = $meeting;

        return $this;
    }

    public function getTypeOperation(): ?TypeOperation
    {
        return $this->typeOperation;
    }

    public function setTypeOperation(?TypeOperation $typeOperation): static
    {
        $this->typeOperation = $typeOperation;

        return $this;
    }

    public function getCleanliness(): ?int
    {
        return $this->cleanliness;
    }

    public function setCleanliness(?int $cleanliness): static
    {
        $this->cleanliness = $cleanliness;

        return $this;
    }
}
