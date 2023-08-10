<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendContactMessageRequest;
use App\Mail\ContactMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
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

    public function sendMessage(SendContactMessageRequest $request): RedirectResponse
    {
        $request->validated();

        Mail::to('julien.lenfume@gmail.com')->send(new ContactMail(['name' => $request->name, 'email' => $request->email, 'topic' => $request->topic, 'message' => $request->message]));

        return back();
    }
}
