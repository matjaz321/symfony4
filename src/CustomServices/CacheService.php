<?php

namespace App\CustomServices;

use App\Entity\Hotel;
use App\Repository\ReviewRepository;
use Psr\SimpleCache\CacheInterface;

/**
 * Class CacheService
 *
 * @package \App\CustomServices
 */
class CacheService {

  /**
   * @var \App\Repository\ReviewRepository
   */
  private $reviewRepository;

  /**
   * @var \Psr\SimpleCache\CacheInterface
   */
  private $filesystemCache;

  /**
   * CacheService constructor.
   *
   * @param \App\Repository\ReviewRepository $reviewRepository
   * @param \Psr\SimpleCache\CacheInterface  $filesystemCache
   */
  public function __construct(ReviewRepository $reviewRepository, CacheInterface $filesystemCache) {
    $this->reviewRepository = $reviewRepository;
    $this->filesystemCache = $filesystemCache;
  }

  /**
   * Function will get cached review or get random review if cache doesn't exist.
   * @param \App\Entity\Hotel $hotel
   *
   * @return mixed|null
   * @throws \Psr\SimpleCache\InvalidArgumentException
   */
  public function getRandomReview(Hotel $hotel) {
    // Load cache and set hotel key.
    $hotelKey = 'random_review_' . $hotel->getId();
    // If cache doesn't exist or cache is invalid get new review.
    if (!$this->filesystemCache->has($hotelKey)) {
      $randomReview = $this->reviewRepository->findRandomReviewForToday($hotel);
      $this->filesystemCache->set($hotelKey, $randomReview, 300);
    }
    else {
      // Get cached review.
      $randomReview = $this->filesystemCache->get($hotelKey);
    }

    // Return random review.
    return $randomReview;
  }
}
