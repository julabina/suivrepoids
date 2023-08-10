<?php

namespace App\Services;

class CalculateService
{
    public function calculateBMI(int $weight, int $size): float
    {
        $formatSize = $size / 100;

        return floatval(number_format($weight / ($formatSize * $formatSize), 2));
    }

    public function calculateBFP(bool $isMale, float $bmi, int $age): float
    {
        $formatBMI = number_format($bmi, 0);

        return floatval(number_format(((1.2 * $bmi) + (0.23 * $age) - (10.8 * ($isMale ? 1 : 0)) - 5.4), 2));

    }

    public function calculateAge(string $birthday): float
    {
        $currentTimestamp = time();

        $birthToNow = $currentTimestamp - strtotime($birthday);

        return floor($birthToNow / 31536000);
    }
}
