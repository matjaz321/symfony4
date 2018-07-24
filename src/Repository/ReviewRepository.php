<?php

namespace App\Repository;

use App\Entity\Hotel;
use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Review|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Review|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = NULL, $limit = NULL, $offset = NULL)
 */
class ReviewRepository extends ServiceEntityRepository {
  public function __construct(RegistryInterface $registry) {
    parent::__construct($registry, Review::class);
  }

  /**
   * Function will get all reviews for Hotel, by today's date..
   *
   * @param \App\Entity\Hotel $hotel
   *
   * @return mixed
   */
  public function findRandomReviewForToday(Hotel $hotel) {
    $reviews = $this->createQueryBuilder('r')
      ->select('r')
      ->andWhere('r.hotel = :id')
      ->andWhere("r.created_at > :date")
      ->setParameter('date', date("Y-m-d", time()))
      ->setParameter('id', $hotel->getId())
      ->orderBy('r.created_at', 'DESC')
      ->getQuery()
      ->getResult();

    // If there is no reviews return empty array.
    if (empty($reviews)) {
      return [];
    }

    // Get random review from array of revies.
    $randomKey = array_rand($reviews);
    /* @var \App\Entity\Review $randomReview*/
    return $reviews[$randomKey];
  }

  //    /**
  //     * @return Review[] Returns an array of Review objects
  //     */
  /*
  public function findByExampleField($value)
  {
      return $this->createQueryBuilder('r')
          ->andWhere('r.exampleField = :val')
          ->setParameter('val', $value)
          ->orderBy('r.id', 'ASC')
          ->setMaxResults(10)
          ->getQuery()
          ->getResult()
      ;
  }
  */

  /*
  public function findOneBySomeField($value): ?Review
  {
      return $this->createQueryBuilder('r')
          ->andWhere('r.exampleField = :val')
          ->setParameter('val', $value)
          ->getQuery()
          ->getOneOrNullResult()
      ;
  }
  */
}
