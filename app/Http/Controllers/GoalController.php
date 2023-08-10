<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\WeightInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GoalController extends Controller
{
    public function show(Request $request): Response
    {
        $goals = Goal::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        $lastInfo = WeightInfo::where('user_id', $request->user()->id)->orderBy('record_date', 'desc')->first();

        return Inertia::render('Goals', [
            'goals' => $goals,
            'lastInfo' => $lastInfo,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'goalType' => 'required|string',
            'value' => 'numeric|required',
        ]);

        $currentGoal = Goal::where('user_id', $request->user()->id)->where('current', true)->first();

        $goalData = [
            'user_id' => $request->user()->id,
            'current' => true,
        ];

        if ($request->goalType === 'weight') {
            $goalData['weight_goal'] = $request->value;
        } elseif ($request->goalType === 'bmi') {
            $goalData['bmi_goal'] = $request->value;
        } else {
            $goalData['bfp_goal'] = $request->value;
        }

        Goal::create($goalData);

        if ($currentGoal !== null) {
            $currentGoal->current = false;
            $currentGoal->save();
        }

        return Redirect::route('dashboard');
    }
}
