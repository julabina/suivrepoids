<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GoalController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Goals');
    }

    public function store(Request $request): RedirectResponse
    {
        return back();
    }
}
