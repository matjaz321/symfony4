<?php

namespace App\Controller;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Twig\Environment;

/**
 * Class ExceptionController
 *
 * @package \App\Controller
 */
class ExceptionController extends \Symfony\Bundle\TwigBundle\Controller\ExceptionController {

  /**
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  private $requestStack;

  /**
   * ExceptionController constructor.
   *
   * @param \Twig\Environment $twig
   * @param                   $debug
   */
  public function __construct(\Twig\Environment $twig, bool $debug = FALSE, RequestStack $requestStack) {
    parent::__construct($twig, $debug);
    $this->requestStack = $requestStack;
  }

  public function showException(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null) {
    $code = $exception->getStatusCode();

    $route = $this->requestStack->getMasterRequest()->attributes->get('_route');
    $id = $this->requestStack->getMasterRequest()->attributes->get('hotelId');

    if ($code == 404 && $route === 'review_random') {

      return new Response($this->twig->render(
        'error404.html.twig',
        [
          'id' =>$id,
        ]
      ));
    } else {
      return parent::showAction($request, $exception, $logger);
    }
  }

}
