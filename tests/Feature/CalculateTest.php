<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WeightInfo;
use Inertia\Testing\AssertableInertia;

it('display the bmi page if user not logged', function () {
    $response = $this->get(route('calcul.bmi'));

    $response
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Bmi')
            ->where('bmi', null)
            ->where('weightMin', null)
            ->where('weightMax', null)
        );
});

it('display the bmi page if user is logged', function () {
    $user = User::factory()->create();
    $info = WeightInfo::factory()->create([
        'user_id' => $user->id,
        'bmi' => 24.5,
    ]);
    $this->actingAs($user);

    $response = $this->get(route('calcul.bmi'));

    $response
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Bmi')
            ->where('bmi', $info->bmi)
            ->where('weightMin', intval(ceil($info->user->size * $info->user->size / 10000 * 18.5)))
            ->where('weightMax', intval(floor($info->user->size * $info->user->size / 10000 * 25)))
        );
});

it('display the bfp page if the user is not logged', function () {
    $response = $this->get(route('calcul.bfp'));

    $response
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Bfp')
            ->where('bmi', null)
            ->where('bfp', null)
        );
});

it('display the bfp page if the user is logged', function () {
    $user = User::factory()->create();
    $info = WeightInfo::factory()->create([
        'user_id' => $user->id,
        'bmi' => 24.5,
        'bfp' => 24.5,
    ]);
    $this->actingAs($user);

    $response = $this->get(route('calcul.bfp'));

    $response
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Bfp')
            ->where('bmi', $info->bmi)
            ->where('bfp', $info->bfp)
        );
});
