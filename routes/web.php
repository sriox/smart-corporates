<?php

use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Operations\PollInstanceController;
use App\Http\Controllers\Operations\SubmitController;
use App\Http\Controllers\Poll\PollController;
use App\Http\Controllers\Poll\QuestionController;
use App\Http\Controllers\Tests\TestController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', WelcomeController::class)->name('welcome');

Route::get('test', [TestController::class, 'index']);

Route::group(['prefix' => 'submit'], function () {
    Route::get('{code}', [SubmitController::class, 'submit'])->name('poll.start');
    Route::post('{code}', [SubmitController::class, 'submitDemographicInfo'])->name('demographic.submit');
    Route::get('{code}/questions', [SubmitController::class, 'pollQuestions'])->name('questions.show');
    Route::post('{code}/answers', [SubmitController::class, 'storeAnswers'])->name('answers.submit');
    Route::get('{code}/open-questions', [SubmitController::class, 'showOpenQuestions'])->name('openQuestions.show');
    Route::post('{code}/open-questions', [SubmitController::class, 'storeOpenQuestions'])->name('openQuestions.store');
    Route::get('{code}/finish', [SubmitController::class, 'finishSubmit'])->name('submit.finish');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {



    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('companies', CompanyController::class);
    Route::resource('polls', PollController::class);

    Route::group(['prefix' => 'companies'], function () {
        Route::get('{company}/polls', [CompanyController::class, 'pollInstancesIndex'])->name('company.polls');
        Route::post('{company}/polls', [CompanyController::class, 'pollInstancesStore'])->name('company.polls.store');
        Route::get('{company}/people', [CompanyController::class, 'peopleIndex'])->name('company.people');
    });

    Route::group(['prefix' => 'poll-instances'], function () {
        Route::get('{pollInstance}/participants', [PollInstanceController::class, 'participantsIndex'])->name('pollInstance.participants');
        Route::get('{pollInstance}/report', [PollInstanceController::class, 'showReport'])->name('pollInstance.report');
        Route::post('{pollInstance}/send-reminder', [PollInstanceController::class, 'sendReminder'])->name('pollInstance.sendReminder');
        Route::get('{id}/reach-age-ranges', [PollInstanceController::class, 'reachByAgeRanges'])->name('pollInstance.reachAgeRanges');
        Route::get('{id}/reach-genders', [PollInstanceController::class, 'reachByGenders'])->name('pollInstance.reachGenders');
        Route::get('{id}/reach-company-levels', [PollInstanceController::class, 'reachByCompanyLevels'])->name('pollInstance.reachCompanyLevels');
        Route::get('{id}/reach-divisions', [PollInstanceController::class, 'reachByDivisions'])->name('pollInstance.reachDivisions');
        Route::get('{id}/reach-areas', [PollInstanceController::class, 'reachByAreas'])->name('pollInstance.reachAreas');
        Route::get('{id}/reach-service-time', [PollInstanceController::class, 'reachByServiceTime'])->name('pollInstance.reachServiceTime');
        Route::get('{id}/demographics-downloads', [PollInstanceController::class, 'demographicsDownloads'])->name('pollInstance.demographicsDownloads');
        Route::get('{id}/download-demographic-group', [PollInstanceController::class, 'downloadDemographicGroup'])->name('pollInstance.downloadDemographicGroup');
    });

    Route::group(['prefix' => 'polls'], function () {
        Route::get('{id}/questions', [QuestionController::class, 'index'])->name('poll.questions');
    });
});
