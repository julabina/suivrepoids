<?php

namespace Tests\Feature;

use App\Models\User;
use function Pest\Laravel\actingAs;

it('has a dashboard page', function () {
    actingAs(User::factory()->create());

    $this->get(route('dashboard'))->assertOk();
});
