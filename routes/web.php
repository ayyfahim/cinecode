<?php

use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\CustomerAuthCheck;
use App\Http\Middleware\CustomerGuest;
use App\Livewire\Customer\Cinema\Create as CustomerCinemaCrete;
use App\Livewire\Customer\Cinema\Index as CustomerCinemaIndex;
use App\Livewire\Customer\ForgotPassword as CustomerForgotPassword;
use App\Livewire\Customer\GeneratePassword as CustomerGeneratePassword;
use App\Livewire\Customer\Login as CustomerLogin;
use App\Livewire\Customer\OrderHistory as CustomerOrderHistory;
use App\Livewire\Customer\ResetPassword as CustomerResetPassword;
use App\Livewire\Customer\Settings as CustomerSettings;
use App\Livewire\Customer\Shop as CustomerShop;
use App\Livewire\TestNav;
use BezhanSalleh\FilamentLanguageSwitch\Http\Middleware\SwitchLanguageLocale;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', TestNav::class);

Route::get('setup', function () {
    Artisan::call('migrate:fresh');
});

Route::prefix('customer')->middleware([CustomerAuthCheck::class, SwitchLanguageLocale::class])->as('customer.')->group(function () {
    Route::get('shop', CustomerShop::class)->name('shop');
    Route::get('order/history', CustomerOrderHistory::class)->name('order.history');
    Route::get('settings', CustomerSettings::class)->name('settings');
    Route::get('settings/cinemas', CustomerCinemaIndex::class)->name('settings.cinema.index');
    Route::get('settings/cinemas/create', CustomerCinemaCrete::class)->name('settings.cinema.create');
});

Route::prefix('customer')
    ->as('customer.')
    ->middleware([CustomerGuest::class, SwitchLanguageLocale::class])
    ->group(function () {
        Route::get('login', CustomerLogin::class)->name('login');
        Route::get('forgot-password', CustomerForgotPassword::class)->name('password.request');
        Route::get('reset-password', CustomerResetPassword::class)->name('password.reset');
        Route::get('generate-password', CustomerGeneratePassword::class)->name('password.generate');
    });

Route::prefix('cinema')->middleware([SwitchLanguageLocale::class])->as('cinema.')->group(function () {
    Route::get('movie/download', [CinemaController::class, 'movieDownload'])->name('movie.download');
});
