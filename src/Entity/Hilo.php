<?php

namespace App\Entity;

use App\Repository\HiloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HiloRepository::class)
 */
class Hilo
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $visible;

    /**
     * @ORM\OneToMany(targetEntity=comentarios::class, mappedBy="hilo", orphanRemoval=true)
     */
    private $HiloComentario;

    /**
     * @ORM\ManyToOne(targetEntity=foro::class, inversedBy="hilos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $HiloForo;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="UserHilo")
     */
    private $user;

    public function __construct()
    {
        $this->HiloComentario = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVisible(): ?int
    {
        return $this->visible;
    }

    public function setVisible(int $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @return Collection|comentarios[]
     */
    public function getHiloComentario(): Collection
    {
        return $this->HiloComentario;
    }

    public function addHiloComentario(comentarios $hiloComentario): self
    {
        if (!$this->HiloComentario->contains($hiloComentario)) {
            $this->HiloComentario[] = $hiloComentario;
            $hiloComentario->setHilo($this);
        }

        return $this;
    }

    public function removeHiloComentario(comentarios $hiloComentario): self
    {
        if ($this->HiloComentario->removeElement($hiloComentario)) {
            // set the owning side to null (unless already changed)
            if ($hiloComentario->getHilo() === $this) {
                $hiloComentario->setHilo(null);
            }
        }

        return $this;
    }

    public function getHiloForo(): ?foro
    {
        return $this->HiloForo;
    }

    public function setHiloForo(?foro $HiloForo): self
    {
        $this->HiloForo = $HiloForo;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
