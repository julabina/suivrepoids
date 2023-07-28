<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class CalculController extends Controller
{
    public function bmi(): Response
    {
        return Inertia::render('Bmi');
    }

    public function bfp(): Response
    {
        return Inertia::render('Bfp');
    }
}
