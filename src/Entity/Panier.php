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

    #[ORM\Column]
    private ?int $panierTotal = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?Profile $profile = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?Paint $paint = null;

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

    public function getPanierTotal(): ?int
    {
        return $this->panierTotal;
    }

    public function setPanierTotal(int $panierTotal): static
    {
        $this->panierTotal = $panierTotal;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): static
    {
        $this->profile = $profile;

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
}
