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
        return redirect('/model/arlo-law-2');
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
    Route::get('/chat-suite', function () {
        return view('layouts.app');
    });
    Route::get('/chat-suite/{slug}', function () {
        return view('layouts.app');
    });
    Route::get('/chat-suite/{slug}/{section}', function () {
        return view('layouts.app');
    });
    Route::get('/fine-tune', function () {
        return view('layouts.app');
    });
    Route::get('/fine-tune/{id}', function () {
        return view('layouts.app');
    });
    Route::get('/free-document-chat', function () {
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

Route::get('/easychat/{slug}', function () {
    return view('layouts.app');
});