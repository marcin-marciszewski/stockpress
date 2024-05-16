<?php

namespace App\Service\Contracts;

interface GetTempInterface
{
    /**
     * Get the current temperature for Katowice, Poland.
     *
     * @return float|null The current temperature in Celsius, or null if the API request failed.
     */
    public function getTempKatowice(): ?float;
}
