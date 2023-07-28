<?php

namespace Tests\Feature;

use function Pest\Laravel\actingAs;

it('has a bmi page', function () {
    $this->get(route('calcul.bmi'))->assertOk();
});

it('has a bfp page', function () {
    $this->get(route('calcul.bfp'))->assertOk();
});