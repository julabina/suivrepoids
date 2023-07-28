<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class LegalsController extends Controller
{
    public function about(): Response
    {
        return Inertia::render('Legals/About');
    }

    public function cgu(): Response
    {
        return Inertia::render('Legals/CGU');
    }

    public function contact(): Response
    {
        return Inertia::render('Legals/Contact');
    }
}
