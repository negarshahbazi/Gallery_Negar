<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
class Status
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[ORM\OneToMany(targetEntity: Paint::class, mappedBy: 'status')]
    private Collection $paints;

    public function __construct()
    {
        $this->paints = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return Collection<int, Paint>
     */
    public function getPaints(): Collection
    {
        return $this->paints;
    }

    public function addPaint(Paint $paint): static
    {
        if (!$this->paints->contains($paint)) {
            $this->paints->add($paint);
            $paint->setStatus($this);
        }

        return $this;
    }

    public function removePaint(Paint $paint): static
    {
        if ($this->paints->removeElement($paint)) {
            // set the owning side to null (unless already changed)
            if ($paint->getStatus() === $this) {
                $paint->setStatus(null);
            }
        }

        return $this;
    }
}
