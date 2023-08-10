<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\WeightInfo;
use App\Services\CalculateService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function show(Request $request): Response
    {
        $infos = WeightInfo::where('user_id', $request->user()->id)->orderBy('record_date', 'desc')->get()->toArray();
        $goal = Goal::where('user_id', $request->user()->id)->where('current', true)->first();
        $weightYears = [];

        foreach ($infos as $key => $info) {
            $infoDate = explode('-', $info['record_date']);
            $weightYears[] = $infoDate[0];
        }

        $years = array_unique($weightYears);

        return Inertia::render('Dashboard', [
            'infos' => array_values($infos),
            'lastInfo' => $infos[0],
            'goal' => $goal,
            'years' => $years,
        ]);
    }

    public function store(Request $request, CalculateService $calculateService): RedirectResponse
    {
        $request->validate([
            'weight' => 'required|integer|min:30|max:260',
        ]);

        $currentDate = Carbon::now();

        $age = $calculateService->calculateAge($request->user()->birthday);
        $bmi = $calculateService->calculateBMI($request->weight, $request->user()->size);
        $bfp = $calculateService->calculateBFP($request->user()->is_man, $bmi, intval($age));

        $newWeight = WeightInfo::create([
            'user_id' => $request->user()->id,
            'weight' => $request->weight,
            'bmi' => $bmi,
            'bfp' => $bfp,
            'record_date' => $currentDate->toDateTimeString(),
        ]);

        $goal = Goal::where('user_id', $request->user()->id)->where('current', true)->first();

        if ($goal->weight_goal !== null && $goal->success === false) {
            if ($newWeight->weight < $goal->weight_goal) {
                $goal->success = true;

                $goal->save();
            }
        } elseif ($goal->bmi_goal !== null && $goal->success === false) {
            if ($newWeight->bmi < $goal->bmi_goal) {
                $goal->success = true;

                $goal->save();
            }
        } elseif ($goal->bfp_goal !== null && $goal->success === false) {
            if ($newWeight->bfp < $goal->bfp_goal) {
                $goal->success = true;

                $goal->save();
            }
        }

        return back();
    }

    public function delete(int $id, Request $request): RedirectResponse
    {
        $log = WeightInfo::find($id);

        if ($log !== null) {
            $log->delete();
        }

        return back();
    }
}
