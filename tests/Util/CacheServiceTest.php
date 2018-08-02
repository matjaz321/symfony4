<?php

namespace App\Tests\Util;

use App\CustomServices\CacheService;
use App\Entity\Hotel;
use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class CacheServiceTest
 *
 * @package \App\Tests\Util
 */
class CacheServiceTest extends KernelTestCase {

  /**
   * @var \Doctrine\ORM\EntityManager
   */
  private $entityManager;

  /**
   * {@inheritDoc}
   */
  protected function setUp() {
    $kernel = self::bootKernel();

    $this->entityManager = $kernel->getContainer()
      ->get('doctrine')
      ->getManager();
  }

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

    $this->entityManager->persist($hotel);
    $this->entityManager->persist($review);
    $this->entityManager->flush();

    $reviewRepository = $this
      ->getMockBuilder(ReviewRepository::class)
      ->disableOriginalConstructor()
      ->getMock();

    $reviewRepository->expects($this->any())
      ->method('findRandomReviewForToday')
      ->willReturn($review);

    $cacheInterface = $this
      ->getMockBuilder('Psr\SimpleCache\CacheInterface')
      ->disableOriginalConstructor()
      ->getMock();

    $cacheService = new CacheService($reviewRepository, $cacheInterface);
    $this->assertEquals($review, $cacheService->getRandomReview($hotel));

    $cacheInterface->expects($this->any())
      ->method('set')
      ->with('random_review_' . $hotel->getId(), $review, 300);

    $cacheService = new CacheService($reviewRepository, $cacheInterface);
    $this->assertEquals($review, $cacheService->getRandomReview($hotel));

    $cacheInterface->expects($this->once())
      ->method('has')
      ->with('random_review_' . $hotel->getId())
      ->willReturn(TRUE);

    $cacheInterface->expects($this->once())
      ->method('get')
      ->with('random_review_' . $hotel->getId())
      ->willReturn($review);

    $cacheService = new CacheService($reviewRepository, $cacheInterface);
    $this->assertEquals($review, $cacheService->getRandomReview($hotel));
  }
}
