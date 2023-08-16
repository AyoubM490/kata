<?php

namespace App;

class StringCalculator
{
    const MAX_NUMBER_ALLOWED = 1000;

    protected $delimiter = ",|\n";

    public function add(string $numbers)
    {

        if (! $numbers) {
            return 0;
        }

        $numbers = $this->parseString($numbers);

        $this->disallowNegatives($numbers);

        return array_sum(
            $this->ignoreGreaterThan1000($numbers)
        );
    }

    /**
     * @param array $numbers
     * @return void
     * @throws \Exception
     */
    public function disallowNegatives(array $numbers)
    {
        foreach ($numbers as $number) {
            if ($number < 0) {
                throw new \Exception('Negative numbers are disallowed');
            }
        }

        return $this;
    }

    protected function parseString(string $numbers)
    {
        $customDelimiter = '\/\/(.)\n';

        if (preg_match("/{$customDelimiter}/", $numbers, $matches)) {
            $this->delimiter = $matches[1];

            $numbers = str_replace($matches[0], '', $numbers);
        }

        return preg_split("/{$this->delimiter}/", $numbers);
    }

    /**
     * @param array $numbers
     * @return array
     */
    public function ignoreGreaterThan1000(array $numbers)
    {
        $numbers = array_filter($numbers, fn($number) => $number <= self::MAX_NUMBER_ALLOWED);
        return $numbers;
    }
}