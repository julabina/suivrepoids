<?php

namespace Tests\Feature;

use App\Models\Goal;
use App\Models\User;
use App\Models\WeightInfo;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\actingAs;

it('display the goal page if user is logged', function () {
    $user = User::factory()->create();
    $info = WeightInfo::factory()->create([
        'user_id' => $user->id,
        'record_date' => '2023-08-07T12:16:01.000000Z',
    ]);
    Goal::factory(3)->create([
        'user_id' => $user->id,
    ]);

    $goals = Goal::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    $lastInfo = WeightInfo::where('user_id', $user->id)->orderBy('record_date', 'desc')->first();
    $lastInfo->bfp = intval($lastInfo->bfp);
    $lastInfo->bmi = intval($lastInfo->bmi);

    actingAs($user);

    $response = $this->get(route('goal.show'));

    $response
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Goals')
            ->where('goals', $goals)
            ->where('lastInfo', [
                'bmi' => intval($lastInfo->bmi),
                'bfp' => intval($lastInfo->bfp),
                'id' => $lastInfo->id,
                'created_at' => $lastInfo->created_at->toISOString(),
                'updated_at' => $lastInfo->updated_at->toISOString(),
                'record_date' => $lastInfo->record_date->toISOString(),
                'user_id' => $lastInfo->user_id,
                'weight' => $lastInfo->weight,
            ])
        );
});

it('display the goal page if user is not logged', function () {
    $this->get(route('goal.show'))->assertStatus(302);
});

function createAndTestGoal(User $user, string $goalType, int $value): void
{
    $currentGoal = Goal::factory()->create([
        'user_id' => $user->id,
        'current' => true,
        'weight_goal' => 60,
    ]);

    actingAs($user)
        ->post(
            uri: route('goal.store', [
                'goalType' => $goalType,
                'value' => $value,
            ]),
        );

    $columnName = $goalType.'_goal';
    $currentGoalUpdated = Goal::find($currentGoal->id);
    $lastGoal = Goal::where('user_id', $user->id)->where($columnName, $value)->first();

    expect($currentGoalUpdated->current)->toBe(false);
    expect($lastGoal->id)->not->toBe($currentGoal->id);
    expect($lastGoal->user_id)->toBe($user->id);
    expect($lastGoal->$columnName)->toBe($value);
    expect($lastGoal->success)->toBe(false);
    expect($lastGoal->current)->toBe(true);
}

it('create new weight goal', function () {
    $user = User::factory()->create();
    createAndTestGoal($user, 'weight', 50);
});

it('create new bmi goal', function () {
    $user = User::factory()->create();
    createAndTestGoal($user, 'bmi', 20);
});

it('create new bfp goal', function () {
    $user = User::factory()->create();
    createAndTestGoal($user, 'bfp', 20);
});