<?php

namespace App\Tests\Util;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ReviewControllerTest
 *
 * @package \App\Tests\Util
 */
class ReviewControllerTest extends WebTestCase {

  public function testShowRandomReview() {
    $client = self::createClient();
    $client->request('get', '/10/today/review');
    /* @var \Symfony\Component\HttpFoundation\Response $response */
    $response = $client->getResponse();
    $this->assertSame(404, $response->getStatusCode());

    $client->request('get', '/23“/today/review');
    /* @var \Symfony\Component\HttpFoundation\Response $response */
    $response = $client->getResponse();
    $this->assertSame(200, $response->getStatusCode());

    $client->request('get', '/23“/today/review');
    /* @var \Symfony\Component\HttpFoundation\Response $response */
    $response = $client->getResponse();
    $this->assertContains('Proin eget tortor risus.', $response->getContent());
  }
}
