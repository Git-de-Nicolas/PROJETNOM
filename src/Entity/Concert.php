<?php

namespace App\Entity;

use App\Repository\ConcertRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcertRepository::class)
 */
class Concert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $heure;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duree;

    /**
     * @ORM\ManyToOne(targetEntity=Artiste::class, inversedBy="concerts") //le problème était là
     */
    private $artiste;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dateConcert;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $heureConcert;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?\DateTimeInterface
    {
        return $this->heure;
    }

    public function setHeure(?\DateTimeInterface $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getArtiste(): ?artiste
    {
        return $this->artiste;
    }

    public function setArtiste(?artiste $artiste): self
    {
        $this->artiste = $artiste;

        return $this;
    }

    public function getDateConcert(): ?string
    {
        return $this->dateConcert;
    }

    public function setDateConcert(?string $dateConcert): self
    {
        $this->dateConcert = $dateConcert;

        return $this;
    }

    public function getHeureConcert(): ?string
    {
        return $this->heureConcert;
    }

    public function setHeureConcert(?string $heureConcert): self
    {
        $this->heureConcert = $heureConcert;

        return $this;
    }
}
