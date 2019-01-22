<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReserveringRepository")
 */
class Reservering
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Klant;

    /**
     * @ORM\Column(type="date")
     */
    private $Datum;

    /**
     * @ORM\Column(type="integer")
     */
    private $aantalpersonen;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tafel")
     */
    private $Tafel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bestelling", mappedBy="Reservering")
     */
    private $bestellings;

    public function __construct()
    {
        $this->Tafel = new ArrayCollection();
        $this->bestellings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKlant(): ?string
    {
        return $this->Klant;
    }

    public function setKlant(string $Klant): self
    {
        $this->Klant = $Klant;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->Datum;
    }

    public function setDatum(\DateTimeInterface $Datum): self
    {
        $this->Datum = $Datum;

        return $this;
    }

    public function getAantalpersonen(): ?int
    {
        return $this->aantalpersonen;
    }

    public function setAantalpersonen(int $aantalpersonen): self
    {
        $this->aantalpersonen = $aantalpersonen;

        return $this;
    }

    /**
     * @return Collection|Tafel[]
     */
    public function getTafel(): Collection
    {
        return $this->Tafel;
    }

    public function addTafel(Tafel $tafel): self
    {
        if (!$this->Tafel->contains($tafel)) {
            $this->Tafel[] = $tafel;
        }

        return $this;
    }

    public function removeTafel(Tafel $tafel): self
    {
        if ($this->Tafel->contains($tafel)) {
            $this->Tafel->removeElement($tafel);
        }

        return $this;
    }

    /**
     * @return Collection|Bestelling[]
     */
    public function getBestellings(): Collection
    {
        return $this->bestellings;
    }

    public function addBestelling(Bestelling $bestelling): self
    {
        if (!$this->bestellings->contains($bestelling)) {
            $this->bestellings[] = $bestelling;
            $bestelling->setReservering($this);
        }

        return $this;
    }

    public function removeBestelling(Bestelling $bestelling): self
    {
        if ($this->bestellings->contains($bestelling)) {
            $this->bestellings->removeElement($bestelling);
            // set the owning side to null (unless already changed)
            if ($bestelling->getReservering() === $this) {
                $bestelling->setReservering(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getKlant() . ' ' . $this->getId();
    }
}
