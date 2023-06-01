<?php

namespace App\Entity;

class Combination
{
	private string $inputString;
	private array $variants = [];
	private int $count;

	public function __construct(string $inputString)
	{
		$this->inputString = $inputString;
		$this->generateCombinations();
	}

	public function getInputString(): string
	{
		return $this->inputString;
	}

	public function getVariants(): array
	{
		return $this->variants;
	}

	public function getCount(): int
	{
		return $this->count;
	}

	private function generateCombinations(): void
	{
		$characters = str_split($this->inputString);
		$results = [];
		$this->createPossibleArrays($characters, '', $results);
		$this->variants = array_values($results);
		$this->count = count($results);
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