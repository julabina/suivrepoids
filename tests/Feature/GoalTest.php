<?php

namespace Tests\Feature;

use App\Models\User;
use function Pest\Laravel\actingAs;

it('has a goal page', function () {
    actingAs(User::factory()->create());

    $this->get(route('goal.show'))->assertOk();
});
