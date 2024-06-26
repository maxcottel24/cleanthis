<?php

namespace App\Entity;

use App\Repository\BelongRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


/**
 * @author Efflam <cefflam@gmail.com>
 */
#[ORM\Entity(repositoryClass: BelongRepository::class)]
class Belong
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Invoice $invoice = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?operation $operation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getOperation(): ?operation
    {
        return $this->operation;
    }

    public function setOperation(?operation $operation): static
    {
        $this->operation = $operation;

        return $this;
    }
}
