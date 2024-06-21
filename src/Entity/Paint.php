<?php

namespace App\Entity;

use App\Repository\PaintRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaintRepository::class)]
class Paint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Photo $photo = null;

    #[ORM\Column]
    private ?int $sizeW = null;

    #[ORM\Column]
    private ?int $sizeH = null;

    #[ORM\Column]
    private ?int $sizeD = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeOfWork = null;

    #[ORM\ManyToOne(inversedBy: 'paints')]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'paints')]
    private ?Status $status = null;


    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'paint')]
    private Collection $messages;

    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'paint')]
    private Collection $paniers;

    /**
     * @var Collection<int, Stars>
     */
    #[ORM\OneToMany(targetEntity: Stars::class, mappedBy: 'paint')]
    private Collection $stars;

    #[ORM\Column]
    private ?int $gradeCount = null;

    #[ORM\Column]
    private ?int $gradeTotal = null;

    public function __construct()
    {
        $this->stars = new ArrayCollection();
    }

   

 
  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPhoto(): ?Photo
    {
        return $this->photo;
    }

    public function setPhoto(?Photo $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSizeW(): ?int
    {
        return $this->sizeW;
    }

    public function setSizeW(int $sizeW): static
    {
        $this->sizeW = $sizeW;

        return $this;
    }

    public function getSizeH(): ?int
    {
        return $this->sizeH;
    }

    public function setSizeH(int $sizeH): static
    {
        $this->sizeH = $sizeH;

        return $this;
    }

    public function getSizeD(): ?int
    {
        return $this->sizeD;
    }

    public function setSizeD(int $sizeD): static
    {
        $this->sizeD = $sizeD;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getTypeOfWork(): ?string
    {
        return $this->typeOfWork;
    }

    public function setTypeOfWork(?string $typeOfWork): static
    {
        $this->typeOfWork = $typeOfWork;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

 

    

  

    /**
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setPaint($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getPaint() === $this) {
                $message->setPaint(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    /**
     * @return Collection<int, Stars>
     */
    public function getStars(): Collection
    {
        return $this->stars;
    }

    public function addStar(Stars $star): static
    {
        if (!$this->stars->contains($star)) {
            $this->stars->add($star);
            $star->setPaint($this);
        }

        return $this;
    }

    public function removeStar(Stars $star): static
    {
        if ($this->stars->removeElement($star)) {
            // set the owning side to null (unless already changed)
            if ($star->getPaint() === $this) {
                $star->setPaint(null);
            }
        }

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
