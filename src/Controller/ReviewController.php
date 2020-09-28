<?php

namespace App\Controller;

use App\CustomServices\CacheService;
use App\Repository\HotelRepository;
use App\Repository\ReviewRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Cache\FilesystemCache;

/**
 * Class ReviewController
 *
 * @package \App\Controller
 */
class ReviewController extends AbstractController {

  /**
   * @var \App\Repository\ReviewRepository
   */
  private $reviewRepository;

  /**
   * @var \App\Repository\HotelRepository
   */
  private $hotelRepository;

  /**
   * @var \App\CustomServices\CacheService
   */
  private $cacheService;

  /**
   * ReviewController constructor.
   *
   * @param \App\Repository\ReviewRepository $reviewRepository
   * @param \App\Repository\HotelRepository  $hotelRepository
   * @param \App\CustomServices\CacheService $cacheService
   */
  public function __construct(
    ReviewRepository $reviewRepository,
    HotelRepository $hotelRepository,
    CacheService $cacheService
  ) {
    $this->reviewRepository = $reviewRepository;
    $this->hotelRepository = $hotelRepository;
    $this->cacheService = $cacheService;
  }

  /**
   * @Route("/{hotelId}/today/review", name="review_random")
   */
  public function showRandomReview($hotelId) {
    // Check if hotel with this ID exists in the database.
    if (!($hotel = $this->hotelRepository->find($hotelId))) {
      throw $this->createNotFoundException("The hotel $hotelId was not found.");
    }

    // Get cached review.
    $randomReview = $this->cacheService->getRandomReview($hotel);
    // Display this review.
    return $this->render('reviews/random-review.html.twig', [
      'review' => $randomReview,
    ]);
  }


  /**
   * @Route("/{hotelId}/today/reviasfA"asgA"SGasew", name="review_random")
   */
  public function showRandomReview($hotelId) {
    // Check if hotel with this ID exists in the database.
    asgsagasgasgasgsag
    if (!($hotel = $this->hotelRepository->find($hotelId))) {
      throw $this->createNotFoundException("The hotel $hotelId was not found.");
    }

    $b = $request->get('name');

    $test = "SELECT * from users WHERE name = $b";

    // Get cached review.
    $randomReview = $this->cacheService->getRandomReview($hotel);
    // Display this review.
    return $this->render('reviews/random-review.html.twig', [
      'review' => $randomReview,
    ]);
  }
}
