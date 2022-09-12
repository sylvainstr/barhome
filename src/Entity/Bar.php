<?php

namespace App\Entity;

use App\Repository\BarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: BarRepository::class)]
class Bar
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $name = null;

  #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
  private $created_at;

  #[ORM\OneToOne(targetEntity:"User", inversedBy:"bar")]
  #[ORM\JoinColumn(name:"user_id", referencedColumnName:"id")]
  private ?User $user = null;

  #[ORM\ManyToMany(targetEntity: Drink::class, mappedBy: 'bar', cascade: ['persist'])]
  private Collection $drinks;

  #[Gedmo\Slug(fields: ["name"])]
  #[ORM\Column(length: 255)]
  private ?string $slug = null;

  public function __toString()
  {
    return $this->name;
  }

  public function __construct()
  {
    $this->setCreatedAt(new \DateTimeImmutable());
    $this->drinks = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
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

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->created_at;
  }

  public function setCreatedAt(\DateTimeImmutable $created_at): self
  {
    $this->created_at = $created_at;

    return $this;
  }

  /**
   * @return Collection<int, Drink>
   */
  public function getDrinks(): Collection
  {
      return $this->drinks;
  }

  public function addDrink(Drink $drink): self
  {
      if (!$this->drinks->contains($drink)) {
          $this->drinks->add($drink);
          $drink->addBar($this);
      }

      return $this;
  }

  public function removeDrink(Drink $drink): self
  {
      if ($this->drinks->removeElement($drink)) {
          $drink->removeBar($this);
      }

      return $this;
  }

  /**
   * Get the value of user
   */ 
  public function getUser()
  {
    return $this->user;
  }

  /**
   * Set the value of user
   *
   * @return  self
   */ 
  public function setUser($user)
  {
    $this->user = $user;

    return $this;
  }

  public function getSlug(): ?string
  {
      return $this->slug;
  }

  public function setSlug(string $slug): self
  {
      $this->slug = $slug;

      return $this;
  }
}
