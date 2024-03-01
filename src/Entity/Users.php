<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface , PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_of_birthday = null;

    #[ORM\Column(length: 10)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $job_title = null;

    #[ORM\Column(nullable: true)]
    private ?int $unit = null;

    #[ORM\Column(nullable: true)]
    private ?int $serial_worker = null;

    #[ORM\Column(nullable: true)]
    private ?int $surpervisor = null;

    #[ORM\ManyToMany(targetEntity: Meeting::class, inversedBy: 'users')]
    private Collection $meetings;

    #[ORM\OneToMany(targetEntity: Address::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $addresses;


    public function __construct()
    {
        $this->meetings = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateOfBirthday(): ?\DateTimeInterface
    {
        return $this->date_of_birthday;
    }

    public function setDateOfBirthday(\DateTimeInterface $date_of_birthday): static
    {
        $this->date_of_birthday = $date_of_birthday;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->job_title;
    }

    public function setJobTitle(?string $job_title): static
    {
        $this->job_title = $job_title;

        return $this;
    }

    public function getUnit(): ?int
    {
        return $this->unit;
    }

    public function setUnit(?int $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getSerialWorker(): ?int
    {
        return $this->serial_worker;
    }

    public function setSerialWorker(?int $serial_worker): static
    {
        $this->serial_worker = $serial_worker;

        return $this;
    }

    public function getSurpervisor(): ?int
    {
        return $this->surpervisor;
    }

    public function setSurpervisor(?int $surpervisor): static
    {
        $this->surpervisor = $surpervisor;

        return $this;
    }

    /**
     * @return Collection<int, Meeting>
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Meeting $meeting): static
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings->add($meeting);
        }

        return $this;
    }

    public function removeMeeting(Meeting $meeting): static
    {
        $this->meetings->removeElement($meeting);

        return $this;
    }
    
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    public function eraseCredentials()
    {
        // Ne rien faire ici si vous utilisez un système de hachage sécurisé pour stocker les mots de passe
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): static
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }
}