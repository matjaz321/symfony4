<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HotelRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 */
class Hotel {

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   * @Assert\Length(min=5)
   */
  private $name;

  /**
   * @ORM\Column(type="text")
   * @Assert\NotBlank()
   * @Assert\Length(min=5)
   */
  private $description;

  /**
   * @ORM\Column(type="datetime")
   * @Assert\NotBlank()
   */
  private $created_at;

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @param mixed $name
   */
  public function setName($name): void {
    $this->name = $name;
  }

  /**
   * @return mixed
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * @param mixed $description
   */
  public function setDescription($description): void {
    $this->description = $description;
  }

  /**
   * @return mixed
   */
  public function getCreatedAt() {
    return $this->created_at;
  }

  /**
   * @ORM\PrePersist()
   */
  public function setCreatedAtOnPersist(): void {
    $this->created_at = new \DateTime();
  }
}
