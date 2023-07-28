<?php

namespace Tests\Feature;

use function Pest\Laravel\actingAs;

it('has a about page', function () {
    $this->get(route('Legals/About'))->assertOk();
});

it('has a cgu page', function () {
    $this->get(route('Legals/CGU'))->assertOk();
});

it('has a contact page', function () {
    $this->get(route('Legals/Contact'))->assertOk();
});