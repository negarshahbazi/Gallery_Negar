<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $panierCount = null;

    

   

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?Paint $paint = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPanierCount(): ?int
    {
        return $this->panierCount;
    }

    public function setPanierCount(int $panierCount): static
    {
        $this->panierCount = $panierCount;

        return $this;
    }

 

  

  

    public function getPaint(): ?Paint
    {
        return $this->paint;
    }

    public function setPaint(?Paint $paint): static
    {
        $this->paint = $paint;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
