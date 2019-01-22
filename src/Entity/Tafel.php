<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TafelRepository")
 */
class Tafel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Personen;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Naam;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPersonen(): ?int
    {
        return $this->Personen;
    }

    public function setPersonen(int $Personen): self
    {
        $this->Personen = $Personen;

        return $this;
    }

    public function getNaam(): ?string
    {
        return $this->Naam;
    }

    public function setNaam(string $Naam): self
    {
        $this->Naam = $Naam;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getNaam();
    }
}
