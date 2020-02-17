<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"mail"}, message="There is already an account with this mail")
 */
class User implements UserInterface
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
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Kids", mappedBy="user", orphanRemoval=true)
     */
    private $kids;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    public function __construct()
    {
        $this->kids = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
//        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

  /**
   * @inheritDoc
   */
  public function getSalt()
  {
    // TODO: Implement getSalt() method.
  }

  /**
   * @inheritDoc
   */
  public function getUsername()
  {
    // TODO: Implement getUsername() method.
  }

  /**
   * @inheritDoc
   */
  public function eraseCredentials()
  {
    // TODO: Implement eraseCredentials() method.
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
          $kid->setUser($this);
      }

      return $this;
  }

  public function removeKid(Kids $kid): self
  {
      if ($this->kids->contains($kid)) {
          $this->kids->removeElement($kid);
          // set the owning side to null (unless already changed)
          if ($kid->getUser() === $this) {
              $kid->setUser(null);
          }
      }

      return $this;
  }
  public function __toString(){
    return $this->getMail();
  }

  public function getLastname(): ?string
  {
      return $this->lastname;
  }

  public function setLastname(string $lastname): self
  {
      $this->lastname = $lastname;

      return $this;
  }
}
