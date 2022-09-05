<?php

namespace App\Entity;

use App\Repository\DrinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DrinkRepository::class)]
class Drink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $year = null;

    #[ORM\ManyToMany(targetEntity: Bar::class, inversedBy: 'drinks')]
    private Collection $bar;

    public function __construct()
    {
        $this->bar = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }
  
    /**
     * @return Collection<int, Bar>
     */
    public function getBar(): Collection
    {
        return $this->bar;
    }

    public function addBar(Bar $bar): self
    {
        if (!$this->bar->contains($bar)) {
            $this->bar->add($bar);
        }

        return $this;
    }

    public function removeBar(Bar $bar): self
    {
        $this->bar->removeElement($bar);

        return $this;
    }

}
