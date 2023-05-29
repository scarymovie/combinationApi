<?php

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CombinationController extends AbstractController
{
	#[Route('/api/v1/combination', name: 'app_api_v1_combination')]
	public function generateCombinations(Request $request)
	{
		$inputString = $request->get('data');
		$combinations = $this->getCombinations($inputString);

		$response = [
			'variants' => $combinations,
			'count' => count($combinations),
		];

		return new JsonResponse($response);
	}

	private function getCombinations($inputString)
	{
		$set = str_split($inputString);
		$results = [];
		$this->createPossibleArrays($set, '', $results);
		return array_values($results);
	}

	private function createPossibleArrays($set, $current, &$results, $iter = 0)
	{
		if (empty($set)) {
			$results[] = $current;
			return;
		}

		$visited = [];

		for ($i = 0; $i < count($set); $i++) {
			$char = $set[$i];

			if (isset($visited[$char])) {
				continue;
			}

			$visited[$char] = true;
			$newSet = $set;

			array_splice($newSet, $i, 1);
			$this->createPossibleArrays($newSet, $current . $char, $results, $iter++);
		}
	}
}
