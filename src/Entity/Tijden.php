<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TijdenRepository")
 */
class Tijden
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
    private $Dag;

    /**
     * @ORM\Column(type="time")
     */
    private $Starttijd;

    /**
     * @ORM\Column(type="time")
     */
    private $Eindtijd;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDag(): ?string
    {
        return $this->Dag;
    }

    public function setDag(string $Dag): self
    {
        $this->Dag = $Dag;

        return $this;
    }

    public function getStarttijd(): ?\DateTimeInterface
    {
        return $this->Starttijd;
    }

    public function setStarttijd(\DateTimeInterface $Starttijd): self
    {
        $this->Starttijd = $Starttijd;

        return $this;
    }

    public function getEindtijd(): ?\DateTimeInterface
    {
        return $this->Eindtijd;
    }

    public function setEindtijd(\DateTimeInterface $Eindtijd): self
    {
        $this->Eindtijd = $Eindtijd;

        return $this;
    }
}
