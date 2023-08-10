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
            return floatval(number_format(((1.2 * $bmi) + (0.23 * $age) - (10.8 * 1) - 5.4), 2));
        } else {
            return floatval(number_format(((1.2 * $bmi) + (0.23 * $age) - (10.8 * 0) - 5.4), 2));
        }
    }

    public function calculAge(string $birthday): float
    {
        $currentTimestamp = time();

        $birthToNow = $currentTimestamp - strtotime($birthday);

        return floor($birthToNow / 31536000);
    }
}
