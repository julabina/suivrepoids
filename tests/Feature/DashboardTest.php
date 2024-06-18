<?php

namespace Tests\Feature;

use App\Models\Goal;
use App\Models\User;
use App\Models\WeightInfo;
use App\Services\CalculateService;
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

function createAndTestNewWeight(User $user, int $value, bool $success, CalculateService $calculateService)
{
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
                'weight' => $value,
            ]
        );

    $goalUpdated = Goal::where('id', $goal->id)->first();
    $infos = WeightInfo::where('weight', $value)->where('user_id', $user->id)->first();

    $bmi = $calculateService->calculateBMI($value, $user->size);
    $age = $calculateService->calculateAge($user->birthday);
    $bfp = $calculateService->calculateBFP(true, $bmi, $age);

    expect($goalUpdated->success)->toBe($success);
    expect($infos->user_id)->toBe($user->id);
    expect($infos->weight)->toBe($value);
    expect($infos->bmi)->toBe($bmi);
    expect($infos->bfp)->toBe($bfp);
}

it('create new weight with goal is achieved', function () {
    $user = User::factory()->create([
        'birthday' => '1986-08-07',
    ]);

    $calculateService = app(CalculateService::class);

    createAndTestNewWeight($user, 83, true, $calculateService);
});

it('create new weight with goal is not achieved', function () {
    $user = User::factory()->create([
        'birthday' => '1986-08-07',
    ]);

    $calculateService = app(CalculateService::class);

    createAndTestNewWeight($user, 93, false, $calculateService);
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
