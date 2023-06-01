<?php

namespace App\Controller;

use App\Entity\Combination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class CombinationController extends AbstractController
{
	private Environment $twig;

	public function __construct(Environment $twig)
	{
		$this->twig = $twig;
	}

	#[Route('/combination', name: 'combination')]
	public function index(Request $request): Response
	{
		try {
			$inputString = $request->get('data');

			if (empty($inputString)) {
				throw new \InvalidArgumentException('Input string is empty');
			}

			$combination = new Combination($inputString);

			$response = [
				'variants' => $combination->getVariants(),
				'count' => $combination->getCount(),
			];

			return new Response(
				$this->twig->render('combination/index.html.twig', $response),
				Response::HTTP_OK
			);
		} catch (\InvalidArgumentException $e) {
			return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}
	}

}
