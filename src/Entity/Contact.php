<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="contact")
 * @UniqueEntity(fields="nom", message="nom is already taken.")
 * @UniqueEntity(fields="prenom", message="Prénom is already taken.")
 * @UniqueEntity(fields="telephone", message="Télephone is already taken.")
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     * 
     */
    private $prenom;

    /**
     * @ORM\Column(type="bigint", unique=true)
     * 
     * 
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }
}
