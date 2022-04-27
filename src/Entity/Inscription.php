<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="inscriptions", cascade={"persist"})
     */
    private $Personne;

    /**
     * @ORM\ManyToOne(targetEntity=Trajet::class, inversedBy="inscriptions", cascade={"persist"})
     */
    private $Trajet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonne(): ?personne
    {
        return $this->Personne;
    }

    public function setPersonne(?personne $Personne): self
    {
        $this->Personne = $Personne;

        return $this;
    }

    public function getTrajet(): ?trajet
    {
        return $this->Trajet;
    }

    public function setTrajet(?trajet $Trajet): self
    {
        $this->Trajet = $Trajet;

        return $this;
    }
}
