<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PostsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostsRepository::class)]
#[ApiResource]
class Posts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
