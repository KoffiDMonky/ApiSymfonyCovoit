<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrajetRepository::class)
 */
class Trajet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personne", inversedBy="trajets")
     * @ORM\JoinTable(name="trajet_personne")
     */
    private $personne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville",cascade={"persist"})
     * @ORM\JoinColumn(name="ville_dep_id", referencedColumnName="id")
     */
    private $ville_dep;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville",cascade={"persist"})
     * @ORM\JoinColumn(name="ville_arr_id", referencedColumnName="id")
     */
    private $ville_arr;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbKms;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $DateTrajet;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="Trajet")
     */
    private $inscriptions;

    public function __construct()
    {
        $this->personne = new ArrayCollection();
        $this->inscriptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|personne[]
     */
    public function getPersonne(): Collection
    {
        return $this->personne;
    }

    public function addPersonne(personne $personne): self
    {
        if (!$this->personne->contains($personne)) {
            $this->personne[] = $personne;
        }

        return $this;
    }

    public function removePersonne(personne $personne): self
    {
        $this->personne->removeElement($personne);

        return $this;
    }

    public function getVilleDep(): ?ville
    {
        return $this->ville_dep;
    }

    public function setVilleDep(?ville $ville_dep): self
    {
        $this->ville_dep = $ville_dep;

        return $this;
    }

    public function getVilleArr(): ?ville
    {
        return $this->ville_arr;
    }

    public function setVilleArr(?ville $ville_arr): self
    {
        $this->ville_arr = $ville_arr;

        return $this;
    }

    public function getNbKms(): ?int
    {
        return $this->nbKms;
    }

    public function setNbKms(?int $nbKms): self
    {
        $this->nbKms = $nbKms;

        return $this;
    }

    public function getDateTrajet(): ?\DateTimeInterface
    {
        return $this->DateTrajet;
    }

    public function setDateTrajet(?\DateTimeInterface $DateTrajet): self
    {
        $this->DateTrajet = $DateTrajet;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->setTrajet($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getTrajet() === $this) {
                $inscription->setTrajet(null);
            }
        }

        return $this;
    }
}
