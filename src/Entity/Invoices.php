<?php

namespace App\Entity;

use App\Repository\InvoicesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoicesRepository::class)]
class Invoices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_emission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $due_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PDF_content = null;

    #[ORM\Column(length: 100)]
    private ?string $payment_method = null;

    #[ORM\OneToOne(inversedBy: 'invoices', cascade: ['persist', 'remove'])]
    private ?Operations $operation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->date_emission;
    }

    public function setDateEmission(\DateTimeInterface $date_emission): static
    {
        $this->date_emission = $date_emission;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->due_date;
    }

    public function setDueDate(\DateTimeInterface $due_date): static
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function getPDFContent(): ?string
    {
        return $this->PDF_content;
    }

    public function setPDFContent(?string $PDF_content): static
    {
        $this->PDF_content = $PDF_content;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(string $payment_method): static
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getOperation(): ?Operations
    {
        return $this->operation;
    }

    public function setOperation(?Operations $operation): static
    {
        $this->operation = $operation;

        return $this;
    }
}
