<?php

namespace Tests\Feature;

use App\Models\User;
use function Pest\Laravel\actingAs;

it('has a home page logged', function () {
    actingAs(User::factory()->create());

    $this->get(route('home'))->assertOk();
});

it('has a home page not logged', function () {
    $this->get(route('home'))->assertOk();
});
