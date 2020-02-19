<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 */
class Program
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
     * @ORM\Column(type="date", nullable=true)
     */
    private $registration;

    /**
     * @ORM\Column(type="date")
     */
    private $startdate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $enddate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="programs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Kids", mappedBy="programs")
     */
    private $kids;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $important;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    public function __construct()
    {
        $this->kids = new ArrayCollection();
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

    public function getRegistration(): ?\DateTimeInterface
    {
        return $this->registration;
    }

    public function setRegistration(?\DateTimeInterface $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartDate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->enddate;
    }

    public function setEndDate(?\DateTimeInterface $enddate): self
    {
        $this->enddate = $enddate;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function __toString(){
    return $this->getName();
    }

    /**
    * @return Collection|Kids[]
    */
    public function getKids(): Collection
    {
      return $this->kids;
    }

    public function addKid(Kids $kid): self
    {
      if (!$this->kids->contains($kid)) {
          $this->kids[] = $kid;
          $kid->addProgram($this);
      }

      return $this;
    }

    public function removeKid(Kids $kid): self
    {
      if ($this->kids->contains($kid)) {
          $this->kids->removeElement($kid);
          $kid->removeProgram($this);
      }

      return $this;
    }

    public function getImportant(): ?string
    {
      return $this->important;
    }

    public function setImportant(?string $important): self
    {
      $this->important = $important;

      return $this;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

//    public function __toString(){
//      $this->getStartDate();
//      $this->getEndDate();
//      $this->getRegistration();
//      return $this;
//    }
}
