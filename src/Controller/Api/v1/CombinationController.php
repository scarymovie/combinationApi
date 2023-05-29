<?php

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CombinationController extends AbstractController
{
	#[Route('/api/v1/combination', name: 'app_api_v1_combination')]
	public function generateCombinations(Request $request): JsonResponse
	{
		$inputString = $request->get('data');
		$combinations = $this->getCombinations($inputString);

		$response = [
			'variants' => $combinations,
			'count' => count($combinations),
		];

		return new JsonResponse($response);
	}

	private function getCombinations(string $inputString): array
	{
		$characters = str_split($inputString);
		$results = [];
		$this->createPossibleArrays($characters, '', $results);
		return array_values($results);
	}

	private function createPossibleArrays(array $characters, string $current, array &$results): void
	{
		if (empty($characters)) {
			$results[] = $current;
			return;
		}

		$visited = [];

		foreach ($characters as $i => $char) {
			if (isset($visited[$char])) {
				continue;
			}

			$visited[$char] = true;
			$newCharacters = $characters;
			array_splice($newCharacters, $i, 1);
			$this->createPossibleArrays($newCharacters, $current . $char, $results);
		}
	}
}
