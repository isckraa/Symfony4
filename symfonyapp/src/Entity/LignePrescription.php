<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LignePrescriptionRepository")
 */
class LignePrescription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $posologie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ordonnance", inversedBy="lignePrescriptions")
     */
    private $ordonnance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Medicament", inversedBy="lignePrescriptions")
     */
    private $medicament;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosologie(): ?string
    {
        return $this->posologie;
    }

    public function setPosologie(string $posologie): self
    {
        $this->posologie = $posologie;

        return $this;
    }

    public function getOrdonnance(): ?Ordonnance
    {
        return $this->ordonnance;
    }

    public function setOrdonnance(?Ordonnance $ordonnance): self
    {
        $this->ordonnance = $ordonnance;

        return $this;
    }

    public function getMedicament(): ?Medicament
    {
        return $this->medicament;
    }

    public function setMedicament(?Medicament $medicament): self
    {
        $this->medicament = $medicament;

        return $this;
    }
}
