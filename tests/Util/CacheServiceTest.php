<?php

namespace App\Tests\Util;

use App\CustomServices\CacheService;
use App\Entity\Hotel;
use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

/**
 * Class CacheServiceTest
 *
 * @package \App\Tests\Util
 */
class CacheServiceTest extends TestCase {

  public function testGetRandomReview() {
    $hotel = new Hotel();
    $hotel->setName('hotel123');
    $hotel->setDescription('lorem loremloremlorem');
    $hotel->setCreatedAtOnPersist();

    $review = new Review();
    $review->setRating(5);
    $review->setDescription('skdsdgsdgsdg');
    $review->setCreatedAtOnPersist();
    $review->setHotel($hotel);

    $reviewRepository = $this
      ->getMockBuilder(ReviewRepository::class)
      ->disableOriginalConstructor()
      ->getMock();

    $reviewRepository->expects($this->any())
      ->method('findRandomReviewForToday')
      ->willReturn($review);


    $cacheService = new CacheService($reviewRepository);
    $this->assertEquals($review, $cacheService->getRandomReview($hotel));
  }
}
