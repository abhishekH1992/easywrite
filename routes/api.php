<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\TranslatorController;
use App\Http\Controllers\SpeechToTextController;
use App\Http\Controllers\ChatSuiteController;
use App\Http\Controllers\FineTuneController;
use App\Http\Controllers\FreeDocumentChatController;
use App\Http\Controllers\SupportController;

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

Route::group(['middleware' => 'user', 'isSubscribed'], function () {
    Route::post('/chat/chat', [ChatController::class, 'create']);
    Route::post('/chat/page-info', [ChatController::class, 'pageInfo']);
    Route::get('/models', [ChatController::class, 'getModels']);

    Route::post('/chat/save', [ChatController::class, 'save']);
    Route::get('/chat/get-user-chat', [ChatController::class, 'getUserChat']);
    Route::get('/chat/get-user-chats', [ChatController::class, 'getUserChats']);
    Route::post('/chat/destroy', [ChatController::class, 'destroy']);

    Route::get('/documents/get-documents', [DocumentsController::class, 'getUserDocuments']);
    Route::post('/documents/create', [DocumentsController::class, 'store']);
    Route::post('/documents/page-info', [DocumentsController::class, 'pageInfo']);
    Route::post('/documents/upload-document', [DocumentsController::class, 'upload']);
    Route::get('/documents/get-document-list', [DocumentsController::class, 'getDocumentList']);
    Route::post('/documents/remove', [DocumentsController::class, 'remove']);
    Route::post('/documents/chat', [DocumentsController::class, 'chat']);
    Route::post('/documents/destroy', [DocumentsController::class, 'destroy']);
    Route::post('/documents/save', [DocumentsController::class, 'save']);

    Route::post('/chat/translate', [TranslatorController::class, 'translate']);
    Route::post('/chat/translate/language', [TranslatorController::class, 'translateLanguage']);

    Route::get('/speech-to-text/get-chat', [SpeechToTextController::class, 'getList']);
    Route::post('/speech-to-text/new-chat', [SpeechToTextController::class, 'newChat']);
    Route::post('/speech-to-text/page-info', [SpeechToTextController::class, 'pageInfo']);
    Route::post('/speech-to-text/destroy', [SpeechToTextController::class, 'destroy']);
    Route::get('/speech-to-text/get-audio-list', [SpeechToTextController::class, 'getAudioList']);
    Route::post('/speech-to-text/upload-audio', [SpeechToTextController::class, 'uploadAudio']);
    Route::post('/speech-to-text/remove-audio', [SpeechToTextController::class, 'removeAudio']);
    Route::post('/speech-to-text/resend-audio', [SpeechToTextController::class, 'resendAudio']);
    Route::post('/speech-to-text/save', [SpeechToTextController::class, 'save']);

    Route::get('/chat-suite/get-list', [ChatSuiteController::class, 'getList']);
    Route::get('/chat-suite/get-page-info', [ChatSuiteController::class, 'getPageInfo']);
    Route::get('/chat-suite/get-section-list', [ChatSuiteController::class, 'getSectionList']);
    Route::get('/chat-suite/get-page-info-section', [ChatSuiteController::class, 'getPageInfoSection']);
    Route::post('/chat-suite/chat', [ChatSuiteController::class, 'chat']);
});

Route::group(['middleware' => 'user'], function () {
    Route::post('/subscription/subscription', [PlanController::class, 'updateSubscription']);
    Route::post('/subscription/cancel', [PlanController::class, 'cancelSubscription']);
    Route::post('/subscription/resume', [PlanController::class, 'cancelSubscription']);

    Route::get('/subscription/get-plans', [PlanController::class, 'getPlans']);
    Route::get('/subscription/get-plan-by-id', [PlanController::class, 'getPlanByid']);
    Route::get('/subscription/setup-intent', [PlanController::class, 'getSetupIntent']);
    Route::get('/subscription/is-subscribed-user', [PlanController::class, 'isSubscribed']);
    Route::get('/subscription/is-valid-plan-selected', [PlanController::class, 'isValidPlanSelected']);
    Route::get('/subscription/get-active-plan-user', [PlanController::class, 'getActiveUserPlan']);
    Route::get('/subscription/is-user-on-grace', [PlanController::class, 'isUserOnGrace']);
    Route::get('/subscription/get-customer-stripe-id', [PlanController::class, 'getCustomerStripeId']);
    Route::get('/subscription/get-billing-portal-url', [PlanController::class, 'getCustomerBillingPortal']);

    Route::get('/site/get-models', [SiteController::class, 'getModels']);
    Route::get('/site/get-nav-menu-models', [SiteController::class, 'getNavMenuModels']);
    Route::get('/site/is-admin', [SiteController::class, 'isAdmin']);
    Route::get('/site/get-search-models', [SiteController::class, 'getSearchModels']);
    Route::get('/site/get-custom-chat-search-models', [SiteController::class, 'getCustomChatSearchModels']);
    Route::get('/site/get-tone-list', [SiteController::class, 'getToneList']);
    Route::get('/site/get-language-list', [SiteController::class, 'getLanguagelist']);
    Route::get('/site/is-seven-day-trial', [SiteController::class, 'isSevenDayTrial']);

    Route::get('/fine-tune/get-list', [FineTuneController::class, 'getList']);
    Route::get('/fine-tune/get-chat-suite-list', [FineTuneController::class, 'getChatSuiteList']);
    Route::post('/fine-tune/new-fine-tune', [FineTuneController::class, 'newFineTune']);
    Route::get('/fine-tune/get-page-info', [FineTuneController::class, 'getPageInfo']);
    Route::post('/fine-tune/set-processing', [FineTuneController::class, 'setProcessing']);
    Route::post('/fine-tune/file-upload', [FineTuneController::class, 'upload']);
    Route::post('/fine-tune/create-job', [FineTuneController::class, 'createJob']);

    Route::get('/free-document-chat/get-list', [FreeDocumentChatController::class, 'getList']);
    Route::post('/free-document-chat/create', [FreeDocumentChatController::class, 'create']);

    Route::get('/free-document-chat/get-page-info', [SupportController::class, 'getPageInfo']);
});

Route::get('/user/is-user-logged-in', [SiteController::class, 'isUserLoggedIn']);
Route::get('/free-document-chat/get-page-info', [SupportController::class, 'getPageInfo']);
Route::post('/free-document-chat/chat', [SupportController::class, 'chat']);