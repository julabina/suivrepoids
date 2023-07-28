<?php

namespace Tests\Feature;

it('has a bmi page', function () {
    $this->get(route('calcul.bmi'))->assertOk();
});

it('has a bfp page', function () {
    $this->get(route('calcul.bfp'))->assertOk();
});
