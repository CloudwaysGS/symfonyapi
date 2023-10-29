<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\PostsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: PostsRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),  // Opération GET personnalisée
        new Post(
            denormalizationContext: ['groups' => ['post:write']],
            normalizationContext: ['groups' => ['post:read']]

        ),
        new Get(),
    ]
)]

class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'titre ne peut pas etre vide')]
    #[Groups('post:write')]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'contenu ne peut pas etre vide')]
    #[Groups('post:write')]
    private ?string $contenu = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'auteur ne peut pas etre vide')]
    #[Assert\Email(message:'L adresse e-mail n est pas valide.')]
    #[Groups('post:write')]
    private ?string $auteur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'email ne peut pas etre vide')]
    #[Assert\Email(message:'L adresse e-mail n est pas valide.')]
    #[Groups('post:write')]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
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
}
