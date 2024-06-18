<?php

namespace Tests\Feature;

use App\Models\User;

use function Pest\Laravel\actingAs;

it('display the home page when user is logged in', function () {
    actingAs(User::factory()->create());

    $this->get(route('home'))->assertOk();
});

it('display the home page when user is not logged in', function () {
    $this->get(route('home'))->assertOk();
});
