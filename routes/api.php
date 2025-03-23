<?php

use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Monitoring\MailMonitoringController;
use App\Http\Controllers\Operations\PollInstanceController;
use App\Http\Controllers\Poll\PollController;
use App\Models\Operations\PollInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'monitoring', 'middleware' => 'mailgun'], function () {
    Route::post('emails/mailgun', [MailMonitoringController::class, 'mailgun'])->name('monitoring.mail.mailgun');
});

Route::group(['middleware' => 'web'], function () {
    Route::get('/companies', [CompanyController::class, 'index']);

    Route::group(['prefix' => 'poll-instances'], function () {
        Route::get('/{id}/results/general-result', [PollInstanceController::class, 'getGeneralResult'])->name('api.pollInstance.generalResult');
        Route::get('/{id}/results/by-dimension', [PollInstanceController::class, 'getResultsByDimension'])->name('api.pollInstance.resultsByDimension');
        Route::get('/{id}/results/by-dimension-attribute', [PollInstanceController::class, 'getResultsByDimensionAttribute'])->name('api.pollInstance.resultsByDimensionAttribute');
        Route::get('/{id}/results/by-dimension-attribute-variable', [PollInstanceController::class, 'getResultsByDimensionAttributeVariable'])->name('api.pollInstance.resultsByDimensionAttributeVariable');
        Route::get('/{id}/results/top-low-attribute-results', [PollInstanceController::class, 'getTopLowAttributes'])->name('api.pollInstance.topLowAttributeResults');
        Route::get('/{id}/results/top-high-attribute-results', [PollInstanceController::class, 'getTopHighAttributes'])->name('api.pollInstance.topHighAttributeResults');
        Route::get('/{id}/results/top-low-indicator-results', [PollInstanceController::class, 'getTopLowIndicators'])->name('api.pollInstance.topLowIndicatorResults');
        Route::get('/{id}/results/top-high-indicator-results', [PollInstanceController::class, 'getTopHighIndicators'])->name('api.pollInstance.topHighIndicatorResults');
        Route::get('/{id}/results/enp-result', [PollInstanceController::class, 'getEmployeeNetPromoteResult'])->name('api.pollInstance.enpResult');
        Route::get('/{id}/results/engage-result', [PollInstanceController::class, 'getEngageResult'])->name('api.pollInstance.engageResult');
        Route::get('/{id}/results/ponderated-result', [PollInstanceController::class, 'getPonderatedResult'])->name('api.pollInstance.ponderatedResult');
        Route::get('/{id}/results/poll-results', [PollInstanceController::class, 'getPollResults'])->name('api.pollInstance.pollResults');
        Route::get('/{id}/results/words', [PollInstanceController::class, 'getOpenQuestionsWithWords'])->name('api.pollInstance.words');
        Route::get('/{id}/results/deviation-by-dimension', [PollInstanceController::class, 'deviationByDimension'])->name('api.pollInstance.deviationByDimension');
        Route::get('/{id}/results/deviation-by-attribute', [PollInstanceController::class, 'deviationByAttribute'])->name('api.pollInstance.deviationByAttribute');
        Route::get('/{id}/results/deviation-by-variable', [PollInstanceController::class, 'deviationByVariable'])->name('api.pollInstance.deviationByVariable');
    });

    Route::group(['prefix' => 'polls'], function () {
        Route::get('/{id}/dimensions', [PollController::class, 'dimensionsIndex'])->name('api.poll.dimensions');
    });
});
Route::group(['prefix' => 'poll-instances'], function () {
    Route::post('{pollInstance}/send-invitations', [PollInstanceController::class, 'sendInvitations'])->name('pollInstance.sendInvitations');
});
