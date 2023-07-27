<?php

namespace App\Services;

class CalculateService
{
    public function calculBMI(int $weight, int $size): float
    {
        $formatSize = $size / 100;

        return floatval(number_format($weight / ($formatSize * $formatSize), 2));
    }

    public function calculBFP(bool $isMale, float $bmi, int $age): float
    {
        $formatBMI = number_format($bmi, 0);

        if ($isMale === true) {
            return (1.2 * $bmi) + (0.23 * $age) - (10.8 * 1) - 5.4;
        } else {
            return (1.2 * $bmi) + (0.23 * $age) - (10.8 * 0) - 5.4;
        }
    }
}
