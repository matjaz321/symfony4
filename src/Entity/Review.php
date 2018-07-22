<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewRepository")
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks()
 */
class Review {

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="integer")
   * @Assert\NotBlank()
   */
  private $rating;

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
   * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="reviews")
   * @ORM\JoinColumn(name="hotel_id", referencedColumnName="id")
   **/
  private $hotel;

  /**
   * @return mixed
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return mixed
   */
  public function getRating() {
    return $this->rating;
  }

  /**
   * @param mixed $rating
   */
  public function setRating($rating): void {
    $this->rating = $rating;
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

  /**
   * @return mixed
   */
  public function getHotel() {
    return $this->hotel;
  }

  /**
   * @param mixed $hotel
   */
  public function setHotel($hotel): void {
    $this->hotel = $hotel;
  }
}
