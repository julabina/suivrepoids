<?php

namespace Tests\Feature;

use App\Models\Goal;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('has a goal page', function () {
    actingAs(User::factory()->create());

    $this->get(route('goal.show'))->assertOk();
});

it('create new weight goal', function () {
    $user = User::factory()->create();

    $currentGoal = Goal::factory()->create([
        'user_id' => $user->id,
        'current' => true,
        'weight_goal' => 60,
    ]);

    actingAs($user)
        ->post(
            uri: route('goal.store', [
                'goalType' => 'weight',
                'value' => 50,
            ]),
        );

    $currentGoalUpdated = Goal::find($currentGoal->id);
    $lastGoal = Goal::where('user_id', $user->id)->where('weight_goal', 50)->first();

    expect($currentGoalUpdated->current)->toBe(false);
    expect($lastGoal->id)->not->toBe($currentGoal->id);
    expect($lastGoal->user_id)->toBe($user->id);
    expect($lastGoal->weight_goal)->toBe(50);
    expect($lastGoal->bmi_goal)->toBe(null);
    expect($lastGoal->bfp_goal)->toBe(null);
    expect($lastGoal->success)->toBe(false);
    expect($lastGoal->current)->toBe(true);
});

it('create new bmi goal', function () {
    $user = User::factory()->create();

    $currentGoal = Goal::factory()->create([
        'user_id' => $user->id,
        'current' => true,
        'weight_goal' => 60,
    ]);

    actingAs($user)
        ->post(
            uri: route('goal.store', [
                'goalType' => 'bmi',
                'value' => 20,
            ]),
        );

    $currentGoalUpdated = Goal::find($currentGoal->id);
    $lastGoal = Goal::where('user_id', $user->id)->where('bmi_goal', 20)->first();

    expect($currentGoalUpdated->current)->toBe(false);
    expect($lastGoal->id)->not->toBe($currentGoal->id);
    expect($lastGoal->user_id)->toBe($user->id);
    expect($lastGoal->weight_goal)->toBe(null);
    expect($lastGoal->bmi_goal)->toBe(20);
    expect($lastGoal->bfp_goal)->toBe(null);
    expect($lastGoal->success)->toBe(false);
    expect($lastGoal->current)->toBe(true);
});

it('create new bfp goal', function () {
    $user = User::factory()->create();

    $currentGoal = Goal::factory()->create([
        'user_id' => $user->id,
        'current' => true,
        'weight_goal' => 60,
    ]);

    actingAs($user)
        ->post(
            uri: route('goal.store', [
                'goalType' => 'bfp',
                'value' => 20,
            ]),
        );

    $currentGoalUpdated = Goal::find($currentGoal->id);
    $lastGoal = Goal::where('user_id', $user->id)->where('bfp_goal', 20)->first();

    expect($currentGoalUpdated->current)->toBe(false);
    expect($lastGoal->id)->not->toBe($currentGoal->id);
    expect($lastGoal->user_id)->toBe($user->id);
    expect($lastGoal->weight_goal)->toBe(null);
    expect($lastGoal->bmi_goal)->toBe(null);
    expect($lastGoal->bfp_goal)->toBe(20);
    expect($lastGoal->success)->toBe(false);
    expect($lastGoal->current)->toBe(true);
});
