<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('layouts.app');
    });
    Route::get('/model/{model}', function () {
        return view('layouts.app');
    });
    Route::get('/plans', function () {
        return view('layouts.app');
    });
    Route::get('/plans/{plan}', function () {
        return view('layouts.app');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('plans', [PlanController::class, 'index']);
    // Route::get('plans/{plan}', [PlanController::class, 'show'])->name("plans.show");
    // Route::post('subscription', [PlanController::class, 'subscription'])->name("subscription.create");
});

require __DIR__.'/auth.php';
