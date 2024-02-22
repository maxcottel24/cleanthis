<?php

namespace App\Entity;

use App\Repository\AddressesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressesRepository::class)]
class Addresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    private ?string $zipcode = null;

    #[ORM\Column(length: 100)]
    private ?string $city = null;

    #[ORM\Column(length: 200)]
    private ?string $street = null;

    #[ORM\ManyToOne(inversedBy: 'addresses')]
    private ?Users $user = null;

    #[ORM\OneToMany(targetEntity: Appointements::class, mappedBy: 'address')]
    private Collection $appointements;

    public function __construct()
    {
        $this->appointements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
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
            $appointement->setAddress($this);
        }

        return $this;
    }

    public function removeAppointement(Appointements $appointement): static
    {
        if ($this->appointements->removeElement($appointement)) {
            // set the owning side to null (unless already changed)
            if ($appointement->getAddress() === $this) {
                $appointement->setAddress(null);
            }
        }

        return $this;
    }
}
