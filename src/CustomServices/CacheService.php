<?php

namespace App\CustomServices;

use App\Entity\Hotel;
use App\Repository\ReviewRepository;
use Symfony\Component\Cache\Simple\FilesystemCache;

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
   * CacheService constructor.
   *
   * @param \App\Repository\ReviewRepository $reviewRepository
   */
  public function __construct(ReviewRepository $reviewRepository) {
    $this->reviewRepository = $reviewRepository;
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
    $cache = new FilesystemCache();
    $hotelKey = 'random_review_' . $hotel->getId();
    // If cache doesn't exist or cache is invalid get new review.
    if (!$cache->has($hotelKey)) {
      $randomReview = $this->reviewRepository->findRandomReviewForToday($hotel);
      $cache->set($hotelKey, $randomReview, 300);
    }
    else {
      // Get cached review.
      $randomReview = $cache->get($hotelKey);
    }

    // Return random review.
    return $randomReview;
  }
}
