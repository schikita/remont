<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\SeoPageController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\PolicyPageController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/uslugi/{slug}', [SeoPageController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('seo.page');

Route::post('/leads', [LeadController::class, 'store'])
    ->middleware('throttle:leads')
    ->name('leads.store');

Route::post('/quiz/calculate', [QuizController::class, 'calculate'])
    ->middleware('throttle:quiz')
    ->name('quiz.calculate');

Route::get('/policy/{slug}', [PolicyPageController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('policy.show');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');
