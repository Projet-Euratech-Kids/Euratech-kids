<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Program", mappedBy="category", orphanRemoval=true)
     */
    private $programs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Workshop", mappedBy="category", orphanRemoval=true)
     */
    private $workshops;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
        $this->workshops = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
            $program->setCategory($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->contains($program)) {
            $this->programs->removeElement($program);
            // set the owning side to null (unless already changed)
            if ($program->getCategory() === $this) {
                $program->setCategory(null);
            }
        }

        return $this;
    }

  public function __toString(){
    return $this->getName();
  }

  /**
   * @return Collection|Workshop[]
   */
  public function getWorkshops(): Collection
  {
      return $this->workshops;
  }

  public function addWorkshop(Workshop $workshop): self
  {
      if (!$this->workshops->contains($workshop)) {
          $this->workshops[] = $workshop;
          $workshop->setCategory($this);
      }

      return $this;
  }

  public function removeWorkshop(Workshop $workshop): self
  {
      if ($this->workshops->contains($workshop)) {
          $this->workshops->removeElement($workshop);
          // set the owning side to null (unless already changed)
          if ($workshop->getCategory() === $this) {
              $workshop->setCategory(null);
          }
      }

      return $this;
  }
}
