<?php

namespace App\Controller;

use App\Repository\HotelRepository;
use App\Repository\ReviewRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
   * ReviewController constructor.
   *
   * @param \App\Repository\ReviewRepository $reviewRepository
   * @param \App\Repository\HotelRepository  $hotelRepository
   */
  public function __construct(ReviewRepository $reviewRepository, HotelRepository $hotelRepository) {
    $this->reviewRepository = $reviewRepository;
    $this->hotelRepository = $hotelRepository;
  }

  /**
   * @Route("/{hotelId}/today/review", name="review_random")
   */
  public function showRandomReview($hotelId) {
    // Check if hotel with this ID exists in the database.
    if (!($hotel = $this->hotelRepository->find($hotelId))) {
      throw $this->createNotFoundException("The hotel $hotelId was not found.");
    }

    // Get all reviews for today's date and filter hotel.
    $randomReview = $this->reviewRepository->findRandomReviewForToday($hotel);
    // Display this review.
    return $this->render('reviews/random-review.html.twig', [
      'review' => $randomReview,
    ]);
  }
}
