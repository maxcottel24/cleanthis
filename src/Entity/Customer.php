<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'customers')]
    private ?Users $user = null;

    #[ORM\OneToMany(targetEntity: Appointements::class, mappedBy: 'customer')]
    private Collection $appointements;

    #[ORM\ManyToMany(targetEntity: Images::class, mappedBy: 'customers')]
    private Collection $images;

    public function __construct()
    {
        $this->appointements = new ArrayCollection();
        $this->images = new ArrayCollection();
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
            $appointement->setCustomer($this);
        }

        return $this;
    }

    public function removeAppointement(Appointements $appointement): static
    {
        if ($this->appointements->removeElement($appointement)) {
            // set the owning side to null (unless already changed)
            if ($appointement->getCustomer() === $this) {
                $appointement->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->addCustomer($this);
        }

        return $this;
    }

    public function removeImage(Images $image): static
    {
        if ($this->images->removeElement($image)) {
            $image->removeCustomer($this);
        }

        return $this;
    }
}
