<?php

namespace Tests\Feature;

use App\Models\Goal;
use App\Models\User;
use App\Models\WeightInfo;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\actingAs;

it('display the dashboard page if user is logged', function () {
    $user = User::factory()->create();
    $info = WeightInfo::factory()->create([
        'user_id' => $user->id,
    ]);
    $goals = Goal::factory()->create([
        'user_id' => $user->id,
        'current' => true,
    ]);

    actingAs($user);

    $response = $this->get(route('dashboard'));

    $infos = WeightInfo::where('user_id', $user->id)->orderBy('record_date', 'desc')->get()->toArray();
    $goal = Goal::where('user_id', $user->id)->where('current', true)->first();
    $weightYears = [];

    $infos[0]['bfp'] = intval($infos[0]['bfp']);
    $infos[0]['bmi'] = intval($infos[0]['bmi']);

    foreach ($infos as $key => $info) {
        $infoDate = explode('-', $info['record_date']);
        $weightYears[] = $infoDate[0];
    }

    $years = array_unique($weightYears);

    $response
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Dashboard')
            ->where('infos', array_values($infos))
            ->where('lastInfo', $infos[0])
            ->where('goal', $goal)
            ->where('years', $years)
        );
});

it('display the dashboard page if user is not logged', function () {
    $this->get(route('dashboard'))->assertStatus(302);
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

it('delete one weight log', function () {
    $log = WeightInfo::factory()->create();

    actingAs(User::factory()->create())
        ->delete(
            uri: route('weight.delete', [
                'id' => $log->id,
            ]),
        );

    $logFind = WeightInfo::find($log->id);

    expect($logFind)->toBe(null);
});
