<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $visible;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=hilo::class, mappedBy="user")
     */
    private $UserHilo;

    /**
     * @ORM\OneToMany(targetEntity=comentarios::class, mappedBy="user")
     */
    private $UserComentarios;

    public function __construct()
    {
        $this->UserHilo = new ArrayCollection();
        $this->UserComentarios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|hilo[]
     */
    public function getUserHilo(): Collection
    {
        return $this->UserHilo;
    }

    public function addUserHilo(hilo $userHilo): self
    {
        if (!$this->UserHilo->contains($userHilo)) {
            $this->UserHilo[] = $userHilo;
            $userHilo->setUser($this);
        }

        return $this;
    }

    public function removeUserHilo(hilo $userHilo): self
    {
        if ($this->UserHilo->removeElement($userHilo)) {
            // set the owning side to null (unless already changed)
            if ($userHilo->getUser() === $this) {
                $userHilo->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|comentarios[]
     */
    public function getUserComentarios(): Collection
    {
        return $this->UserComentarios;
    }

    public function addUserComentario(comentarios $userComentario): self
    {
        if (!$this->UserComentarios->contains($userComentario)) {
            $this->UserComentarios[] = $userComentario;
            $userComentario->setUser($this);
        }

        return $this;
    }

    public function removeUserComentario(comentarios $userComentario): self
    {
        if ($this->UserComentarios->removeElement($userComentario)) {
            // set the owning side to null (unless already changed)
            if ($userComentario->getUser() === $this) {
                $userComentario->setUser(null);
            }
        }

        return $this;
    }
}
