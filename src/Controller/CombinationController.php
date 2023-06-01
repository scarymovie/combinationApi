<?php

namespace App\Controller;

use App\Entity\Combination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

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
		$inputString = $request->get('data');

		if (empty($inputString)) {
			return new Response('Input string is empty', Response::HTTP_BAD_REQUEST);
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
	}
}
