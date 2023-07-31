<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\WeightInfo;
use Illuminate\Http\Request;

class CalculController extends Controller
{
    public function bmi(Request $request): Response
    {
        $bmi = null;
        $weightMin = null;
        $weightMax = null;

        if ($request->user() !== null) {
            $info = WeightInfo::where('user_id', $request->user()->id)->orderBy('record_date', 'desc')->with('user')->first(); 
            $bmi = $info->bmi;
            $size = $info->user['size'] / 100;
            $weightMin = ceil(($size * $size) * 18.5);
            $weightMax = floor(($size * $size) * 25);
        }

        return Inertia::render('Bmi', [
            'bmi' => $bmi,
            'weightMin' => $weightMin,
            'weightMax' => $weightMax,
        ]);
    }

    public function bfp(): Response
    {
        return Inertia::render('Bfp');
    }
}
