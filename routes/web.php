<?php

use App\Http\Controllers\CalculController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'show'])->name('home');
Route::get('/bmi', [CalculController::class, 'bmi'])->name('calcul.bmi');
Route::get('/bfp', [CalculController::class, 'bfp'])->name('calcul.bfp');
Route::get('/about', [LegalsController::class, 'about'])->name('legals.about');
Route::get('/cgu', [LegalsController::class, 'cgu'])->name('legals.cgu');
Route::get('/contact', [LegalsController::class, 'contact'])->name('legals.contact');
Route::post('/contact', [LegalsController::class, 'sendMessage'])->name('legals.sendMessage');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::get('/goals', [GoalController::class, 'show'])->name('goal.show');
    Route::post('/goal', [GoalController::class, 'store'])->name('goal.store');
    Route::post('/weight', [DashboardController::class, 'store'])->name('weight.store');
    Route::delete('/weight/{id}', [DashboardController::class, 'delete'])->name('weight.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
