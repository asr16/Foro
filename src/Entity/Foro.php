<?php

namespace App\Entity;

use App\Repository\ForoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ForoRepository::class)
 */
class Foro
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Hilo::class, mappedBy="HiloForo")
     */
    private $hilos;

    public function __construct()
    {
        $this->hilos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Hilo[]
     */
    public function getHilos(): Collection
    {
        return $this->hilos;
    }

    public function addHilo(Hilo $hilo): self
    {
        if (!$this->hilos->contains($hilo)) {
            $this->hilos[] = $hilo;
            $hilo->setHiloForo($this);
        }

        return $this;
    }

    public function removeHilo(Hilo $hilo): self
    {
        if ($this->hilos->removeElement($hilo)) {
            // set the owning side to null (unless already changed)
            if ($hilo->getHiloForo() === $this) {
                $hilo->setHiloForo(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->getTitle();
    }
}
