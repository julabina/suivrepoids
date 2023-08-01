<?php

namespace Tests\Feature;

use App\Models\Goal;
use App\Models\User;
use App\Models\WeightInfo;
use function Pest\Laravel\actingAs;

it('has a dashboard page', function () {
    actingAs(User::factory()->create());

    $this->get(route('dashboard'))->assertOk();
});

it('create new weight with goal is achieved', function () {
    $user = User::factory()->create([
        'birthday' => '1986-08-07',
    ]);
    $goal = Goal::factory()->create([
        'user_id' => $user->id,
        'weight_goal' => 90,
        'current' => true,
    ]);

    actingAs($user)
        ->post(
            uri: route('weight.store'),
            data: [
                'user_id' => $user->id,
                'weight' => 81,
            ]
        );

    $goalUpdated = Goal::where('id', $goal->id)->first();
    $infos = WeightInfo::where('weight', 81)->where('user_id', $user->id)->first();
    echo $goalUpdated->success;

    expect($goalUpdated->success)->toBe(true);
    expect($infos->user_id)->toBe($user->id);
    expect($infos->weight)->toBe(81);
    expect($infos->bmi)->toBe(25.0);
    expect($infos->bfp)->toBe(22.31);
});

it('create new weight with goal is not achieved', function () {
    $user = User::factory()->create([
        'birthday' => '1986-08-07',
    ]);
    $goal = Goal::factory()->create([
        'user_id' => $user->id,
        'weight_goal' => 80,
        'current' => true,
    ]);

    actingAs($user)
        ->post(
            uri: route('weight.store'),
            data: [
                'user_id' => $user->id,
                'weight' => 82,
            ]
        );

    $goalUpdated = Goal::where('id', $goal->id)->first();
    $infos = WeightInfo::where('weight', 82)->where('user_id', $user->id)->first();

    expect($goalUpdated->success)->toBe(false);
    expect($infos->user_id)->toBe($user->id);
    expect($infos->weight)->toBe(82);
    expect($infos->bmi)->toBe(25.31);
    expect($infos->bfp)->toBe(22.68);
});
