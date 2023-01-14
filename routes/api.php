<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\PlanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/chat/chat', [ChatController::class, 'create']);
Route::post('/chat/page-info', [ChatController::class, 'pageInfo']);
Route::get('/models', [ChatController::class, 'getModels']);

Route::get('/subscription/get-plans', [PlanController::class, 'getPlans']);
    Route::get('/subscription/get-plan-by-slug', [PlanController::class, 'getPlanBySlug']);

// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/subscription/get-plans', [PlanController::class, 'getPlans']);
//     Route::get('/subscription/get-plan-by-slug', [PlanController::class, 'getPlanBySlug']);
// });