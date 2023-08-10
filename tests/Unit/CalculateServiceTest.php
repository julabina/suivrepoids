<?php

namespace Tests\Unit;

use App\Services\CalculateService;

it('calculateBMI returns the correct BMI', function () {
    $calculateService = new CalculateService();

    // Calculate the expected BMI manually based on the inputs
    $weight = 70;  // in kg
    $size = 170;   // in cm
    $expectedBMI = number_format($weight / (($size / 100) * ($size / 100)), 2);

    // Calculate the actual BMI using the method
    $actualBMI = $calculateService->calculateBMI($weight, $size);

    // Check if the actual and expected BMI values match
    expect($actualBMI)->toBe((float) $expectedBMI);

});

it('calculateBFP returns the correct BFP for a male', function () {
    $calculateService = new CalculateService();

    // Inputs
    $isMale = true;
    $bmi = 25.0;
    $age = 30;

    // Expected BFP calculation for a male
    $expectedBFP = number_format(
        (1.2 * $bmi) + (0.23 * $age) - (10.8 * 1) - 5.4,
        2
    );

    // Calculate the actual BFP using the method
    $actualBFP = $calculateService->calculateBFP($isMale, $bmi, $age);

    // Check if the actual and expected BFP values match
    expect($actualBFP)->toBe((float) $expectedBFP);
});

it('calculateBFP returns the correct BFP for a female', function () {
    $calculateService = new CalculateService();

    // Inputs
    $isMale = false;
    $bmi = 25.0;
    $age = 30;

    $expectedBFP = number_format(
        (1.2 * $bmi) + (0.23 * $age) - (10.8 * 0) - 5.4,
        2
    );

    // Calculate the actual BFP using the method
    $actualBFP = $calculateService->calculateBFP($isMale, $bmi, $age);

    // Check if the actual and expected BFP values match
    expect($actualBFP)->toBe((float) $expectedBFP);
});

it('calculateAge returns the correct age', function () {
    $calculateService = new CalculateService();

    $birthday = '1986-08-07';
    $currentTimestamp = time();
    $birthToNow = $currentTimestamp - strtotime($birthday);

    $expectAge = floor($birthToNow / 31536000);

    $actualAge = $calculateService->calculateAge($birthday);

    expect($actualAge)->toBe($expectAge);
});
