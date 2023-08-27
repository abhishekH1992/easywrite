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

Route::group(['middleware' => ['auth', 'verified', 'isSubscribed']], function () {
    Route::get('/', function () {
        return view('layouts.app');
    })->name('dashboard');
    Route::get('/model/{model}', function () {
        return view('layouts.app');
    });
    Route::get('/model/{model}/{id}', function () {
        return view('layouts.app');
    });
    Route::get('/archive', function () {
        return view('layouts.app');
    });
    Route::get('/documents', function () {
        return view('layouts.app');
    });
    Route::get('/documents/{documentid}', function () {
        return view('layouts.app');
    });
    Route::get('/custom-chat', function () {
        return view('layouts.app');
    });
    Route::get('/custom-chat/{model}', function () {
        return view('layouts.app');
    });
    Route::get('/custom-chat/{model}/{id}', function () {
        return view('layouts.app');
    });
    Route::get('/speech-to-text', function () {
        return view('layouts.app');
    });
    Route::get('/speech-to-text/{id}', function () {
        return view('layouts.app');
    });
});
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/plans', function () {
        return view('layouts.app');
    });
    Route::get('/subscription', function () {
        return view('layouts.app');
    });
    Route::get('/manage-billing', function () {
        return view('layouts.app');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});