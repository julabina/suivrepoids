<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WeightInfo;
use App\Providers\RouteServiceProvider;
use App\Services\CalculateService;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, CalculateService $calculateService): RedirectResponse|Response
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'size' => 'required|integer|min:90|max:260',
            'weight' => 'required|integer|min:30|max:260',
            'birthday' => 'required|string',
            'sexe' => 'required|string',
        ]);

        $userEmail = User::where('email', $request->email)->first();

        if ($userEmail !== null) {
            return Inertia::render('Auth/Register', [
                'emailError' => true,
            ]);
        }

        $isMan = false;
        if ($request->sexe === 'man') {
            $isMan = true;
        }

        $birthdayDate = date('Y-m-d H:i:s', strtotime($request->birthday));
        $currentTimestamp = time();
        $currentDate = Carbon::now();
        $birthToNow = $currentTimestamp - strtotime($request->birthday);
        $age = floor($birthToNow / 31536000);

        $bmi = $calculateService->calculateBMI($request->weight, $request->size);
        $bfp = $calculateService->calculateBFP($isMan, $bmi, intval($age));

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'size' => $request->size,
            'is_man' => $isMan,
            'birthday' => $birthdayDate,
        ]);

        WeightInfo::create([
            'user_id' => $user->id,
            'weight' => $request->weight,
            'bmi' => $bmi,
            'bfp' => $bfp,
            'record_date' => $currentDate->toDateTimeString(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
