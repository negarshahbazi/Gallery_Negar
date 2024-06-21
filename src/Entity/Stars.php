<?php

namespace App\Entity;

use App\Repository\StarsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StarsRepository::class)]
class Stars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stars')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'stars')]
    private ?Paint $paint = null;

    #[ORM\Column]
    private ?int $gradeCount = null;

    #[ORM\Column]
    private ?int $gradeTotal = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPaint(): ?Paint
    {
        return $this->paint;
    }

    public function setPaint(?Paint $paint): static
    {
        $this->paint = $paint;

        return $this;
    }

    public function getGradeCount(): ?int
    {
        return $this->gradeCount;
    }

    public function setGradeCount(int $gradeCount): static
    {
        $this->gradeCount = $gradeCount;

        return $this;
    }

    public function getGradeTotal(): ?int
    {
        return $this->gradeTotal;
    }

    public function setGradeTotal(int $gradeTotal): static
    {
        $this->gradeTotal = $gradeTotal;

        return $this;
    }
}
