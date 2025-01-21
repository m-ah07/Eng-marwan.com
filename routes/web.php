<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


Route::middleware([\App\Http\Middleware\LocalizationMiddleware::class])->group(function () {
    Route::get('/', [ServiceController::class, 'showHomePage']);
    Route::get('/convert-image', [ServiceController::class, 'showConvertImage']);
    Route::get('/number-to-text', [ServiceController::class, 'showNumberToText']);
    Route::get('/merge-images', [ServiceController::class, 'showMergeImages']);
    Route::get('/text-analysis', [ServiceController::class, 'showTextAnalysis']);
    Route::get('/convert-pdf-to-images', [ServiceController::class, 'showConvertPdfToImages']);
    Route::get('/privacy-policy', function () {
        return view('privacy_policy');
    })->name('privacy-policy');
    Route::get('/terms', function () {
        return view('terms');
    })->name('terms');

    Route::post('/analyze-text', [ServiceController::class, 'analyzeText']);
    Route::post('/convert-number', [ServiceController::class, 'convertNumberToText']);
    Route::post('/convert-image', [ServiceController::class, 'convertImage']);
    Route::post('/convert-pdf-to-images', [ServiceController::class, 'convertPdfToImages']);
    Route::post('/merge-images', [ServiceController::class, 'mergeImagesToPdf']);
    Route::get('/language/{lang}', function ($lang) {
        if (in_array($lang, ['en', 'ar', 'es', 'fr', 'de', 'zh', 'ja', 'ru', 'ur'])) {
            Session::put('locale', $lang);
            App::setLocale($lang);


        }
        return redirect()->back();
    })->name('language');

    Route::get('/current-language', function () {
        return App::getLocale();
    });

    Route::get('/test-session', function () {
        Session::put('test_key', 'test_value');
        return Session::get('test_key');
    });

    Route::get('/test-middleware', function () {
        return 'Middleware Works!';
    })->middleware(\App\Http\Middleware\LocalizationMiddleware::class);

    Route::get('/test', function () {
        return view('test');
    })->middleware(\App\Http\Middleware\LocalizationMiddleware::class);
});
