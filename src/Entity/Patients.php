<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PatientsRepository;
use App\Traits\DateTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PatientsRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['name'], message: 'Ce patient existe déjà')]
class Patients
{
    use DateTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Le nom doit contenir au moins 3 caractères', maxMessage: 'Le nom doit contenir au plus 255 caractères')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Le prénom doit contenir au moins 3 caractères', maxMessage: 'Le prénom doit contenir au plus 255 caractères')]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255, minMessage: 'L\'âge doit contenir au moins 3 caractères', maxMessage: 'L\'âge doit contenir au plus 255 caractères')]
    private ?string $age = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Le téléphone doit contenir au moins 3 caractères', maxMessage: 'Le téléphone doit contenir au plus 255 caractères')]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Le contact d\'urgence doit contenir au moins 3 caractères', maxMessage: 'Le contact d\'urgence doit contenir au plus 255 caractères')]
    private ?string $contact_urgence = null;

    /*AUTORISER LES CARACTERES SPECIAUX*/
    #[ORM\Column(length: 255)]    
    private ?string $groupe_sanguin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255, minMessage: 'La taille doit contenir au moins 3 caractères', maxMessage: 'La taille doit contenir au plus 255 caractères')]
    private ?string $taille = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255, minMessage: 'Le poids doit contenir au moins 3 caractères', maxMessage: 'Le poids doit contenir au plus 255 caractères')]
    private ?string $poids = null;

    #[ORM\ManyToOne(inversedBy: 'Patients')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getContactUrgence(): ?string
    {
        return $this->contact_urgence;
    }

    public function setContactUrgence(string $contact_urgence): static
    {
        $this->contact_urgence = $contact_urgence;

        return $this;
    }

    public function getGroupeSanguin(): ?string
    {
        return $this->groupe_sanguin;
    }

    public function setGroupeSanguin(string $groupe_sanguin): static
    {
        $this->groupe_sanguin = $groupe_sanguin;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?string
    {
        return $this->poids;
    }

    public function setPoids(string $poids): static
    {
        $this->poids = $poids;

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
