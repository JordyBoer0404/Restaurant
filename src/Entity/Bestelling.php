<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BestellingRepository")
 */
class Bestelling
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Reservering", inversedBy="bestellings")
     */
    private $Reservering;

    /**
     * @ORM\Column(type="date")
     */
    private $Datum;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservering(): ?Reservering
    {
        return $this->Reservering;
    }

    public function setReservering(?Reservering $Reservering): self
    {
        $this->Reservering = $Reservering;

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
}
