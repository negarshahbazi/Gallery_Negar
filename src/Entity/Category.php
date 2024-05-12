<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Paint::class, mappedBy: 'category')]
    private Collection $paints;

    #[ORM\Column(length: 255)]
    private ?string $explique = null;

    #[ORM\Column(length: 255)]
    private ?string $year = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $famous = null;

    #[ORM\Column(length: 255)]
    private ?string $readMore = null;



    public function __construct()
    {
        $this->paints = new ArrayCollection();
    }
    public function __toString(): string
    {
        return $this->getName(); // Assuming getName() returns the category name
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $paint->setCategory($this);
        }

        return $this;
    }

    public function removePaint(Paint $paint): static
    {
        if ($this->paints->removeElement($paint)) {
            // set the owning side to null (unless already changed)
            if ($paint->getCategory() === $this) {
                $paint->setCategory(null);
            }
        }

        return $this;
    }

    public function getExplique(): ?string
    {
        return $this->explique;
    }

    public function setExplique(string $explique): static
    {
        $this->explique = $explique;

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(string $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getFamous(): ?string
    {
        return $this->famous;
    }

    public function setFamous(string $famous): static
    {
        $this->famous = $famous;

        return $this;
    }

    public function getReadMore(): ?string
    {
        return $this->readMore;
    }

    public function setReadMore(string $readMore): static
    {
        $this->readMore = $readMore;

        return $this;
    }

 
}
