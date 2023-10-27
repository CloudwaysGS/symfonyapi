<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Repository\RegisterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Controller\RegisterController;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RegisterRepository::class)]

#[ApiResource(
    operations: [
        new GetCollection(),  // Opération GET personnalisée
        new Post(
            denormalizationContext: ['groups' => ['register:write']]
        ),
    ]
)]


class Register
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups('register:write')]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'Username ne peut pas etre vide')]
    private ?string $username = null;

    #[Groups('register:write')]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Username ne peut pas etre vide')]

    private ?string $password = null;

    #[Groups('register:write')]
    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $role = [];

    #[ORM\OneToOne(mappedBy: 'register', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(?array $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setRegister(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getRegister() !== $this) {
            $user->setRegister($this);
        }

        $this->user = $user;

        return $this;
    }

    public function __toString()
    {
        return $this->role;
    }
}
