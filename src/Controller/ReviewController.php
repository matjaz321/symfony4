<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\ReviewRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ReviewController
 *
 * @package \App\Controller
 */
class ReviewController extends AbstractController {

  private $reviewRepository;

  public function __construct(ReviewRepository $reviewRepository) {
    $this->reviewRepository = $reviewRepository;
  }

  /**
   * @Route("/{hotelId}/today/review", name="review_random")
   */
  public function showRandomReview(Hotel $hotelId) {
    // Get all reviews for today's date and filter hotel.
    $reviews = $this->reviewRepository->findRandomReviewForToday($hotelId);
    // Get random review from array of revies.
    $randomKey = array_rand($reviews);
    /* @var \App\Entity\Review $randomReview*/
    $randomReview = $reviews[$randomKey];
    $createdAt = $randomReview->getCreatedAt();

    // Display this review.
    return $this->render('reviews/random-review.html.twig', [
      'review' => $randomReview,
      'created_at' => $createdAt,
    ]);
  }
}
