<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'date')]
    private $birthDate;

    #[ORM\Column(type: 'string', length: 255)]
    private $bloodGroup;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $size;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $weight;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $updatedAt;

    #[ORM\ManyToOne(inversedBy: 'patients')]
    private ?User $user = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private $antMedic;

    #[ORM\Column(type: 'text', nullable: true)]
    private $allergies;

    #[ORM\Column(type: 'text', nullable: true)]
    private $vaccins;

    #[ORM\Column(type: 'text', nullable: true)]
    private $tabac;

    #[ORM\Column(type: 'text', nullable: true)]
    private $alcool;

    #[ORM\Column(type: 'text', nullable: true)]
    private $stupefiants;

    #[ORM\Column(type: 'text', nullable: true)]
    private $sommeil;

    #[ORM\Column(type: 'text', nullable: true)]
    private $alimentation;

    #[ORM\Column(type: 'text', nullable: true)]
    private $activitePhysique;

    #[ORM\Column(type: 'text', nullable: true)]
    private $employeur;



    #[ORM\OneToMany(targetEntity: EmergencyContact::class, mappedBy: 'patient', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $emergencyContacts;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->emergencyContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstName;
    }

    public function setFirstname(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthdate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getBloodGroup(): ?string
    {
        return $this->bloodGroup;
    }

    public function setBloodGroup(string $bloodGroup): self
    {
        $this->bloodGroup = $bloodGroup;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getAntMedic(): ?string
    {
        return $this->antMedic;
    }

    public function setAntMedic(?string $antMedic): self
    {
        $this->antMedic = $antMedic;

        return $this;
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function setAllergies(?string $allergies): self
    {
        $this->allergies = $allergies;

        return $this;
    }

    public function getVaccins(): ?string
    {
        return $this->vaccins;
    }

    public function setVaccins(?string $vaccins): self
    {
        $this->vaccins = $vaccins;

        return $this;
    }

    public function getTabac(): ?string
    {
        return $this->tabac;
    }

    public function setTabac(?string $tabac): self
    {
        $this->tabac = $tabac;

        return $this;
    }

    public function getAlcool(): ?string
    {
        return $this->alcool;
    }

    public function setAlcool(?string $alcool): self
    {
        $this->alcool = $alcool;

        return $this;
    }

    public function getStupefiants(): ?string
    {
        return $this->stupefiants;
    }

    public function setStupefiants(?string $stupefiants): self
    {
        $this->stupefiants = $stupefiants;

        return $this;
    }

    public function getSommeil(): ?string
    {
        return $this->sommeil;
    }

    public function setSommeil(?string $sommeil): self
    {
        $this->sommeil = $sommeil;

        return $this;
    }

    public function getAlimentation(): ?string
    {
        return $this->alimentation;
    }

    public function setAlimentation(?string $alimentation): self
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    public function getActivitePhysique(): ?string
    {
        return $this->activitePhysique;
    }

    public function setActivitePhysique(?string $activitePhysique): self
    {
        $this->activitePhysique = $activitePhysique;

        return $this;
    }

    public function getEmployeur(): ?string
    {
        return $this->employeur;
    }

    public function setEmployeur(?string $employeur): self
    {
        $this->employeur = $employeur;

        return $this;
    }


    public function getEmergencyContacts(): Collection
    {
        return $this->emergencyContacts;
    }

    public function addEmergencyContact(EmergencyContact $contact): self
    {
        if (!$this->emergencyContacts->contains($contact)) {
            $this->emergencyContacts[] = $contact;
            $contact->setPatient($this);
        }

        return $this;
    }

    public function removeEmergencyContact(EmergencyContact $contact): self
    {
        if ($this->emergencyContacts->contains($contact)) {
            $this->emergencyContacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getPatient() === $this) {
                $contact->setPatient(null);
            }
        }

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    private function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
