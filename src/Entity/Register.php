<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Repository\RegisterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RegisterRepository::class)]

#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['register:read:all']]
        ),  // Opération GET personnalisée
        new Post(
            normalizationContext: ['groups' => ['register:read']],
            denormalizationContext: ['groups' => ['registers:write']]

        ),
        new Get(
        ),
    ]
)]

#[UniqueEntity('username', message: 'Cet utilisateur existe deja.')]

class Register
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['register:read','registers:write', 'register:read:all'])]
    private ?int $id = null;

    #[Groups(['register:read','registers:write', 'register:read:all'])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Username ne peut pas être vide')]
    #[Assert\Length(max: 25, maxMessage: 'Trop long')]
    private ?string $username = null;

    #[Groups(['register:read','registers:write', 'register:read:all'])]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'password ne peut pas etre vide')]
    #[Assert\Length(max: 25, maxMessage: 'Trop long')]

    private ?string $password = null;

    #[Groups(['register:read','registers:write','register:read:all'])]
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


}
