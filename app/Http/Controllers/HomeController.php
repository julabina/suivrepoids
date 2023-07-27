<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function show(Request $request): Response
    {
        $logged = false;
        if (Auth::check()) {
            $logged = true;
        }

        return Inertia::render('Home');
    }
}
