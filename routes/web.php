<?php

use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\CinemaAuth;
use App\Http\Middleware\CinemaGuest;
use App\Http\Middleware\CustomerAuthCheck;
use App\Http\Middleware\CustomerGuest;
use App\Http\Middleware\SetLanguageBasedOnCountry;
use App\Livewire\Cinema\Email\Index as CinemaEmailIndex;
use App\Livewire\Cinema\Login as CinemaLogin;
use App\Livewire\Cinema\OrderHistory as CinemaOrderHistory;
use App\Livewire\Cinema\PlayerDownload as CinemaPlayer;
use App\Livewire\Cinema\PlayerDownloadPage as CinemaPlayerDownloadPage;
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
use Illuminate\Support\Facades\URL;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test', TestNav::class);

Route::get('setup', function () {
    Artisan::call('migrate:fresh');
});

Route::domain(config('filament.customer_portal_url'))->group(
    function () {
        Route::prefix('customer')->middleware([CustomerAuthCheck::class, SwitchLanguageLocale::class, SetLanguageBasedOnCountry::class])->as('customer.')->group(function () {

            Route::get('order', CustomerShop::class)->name('shop');
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
    }
);



Route::domain(config('filament.cinema_portal_url'))->group(function () {
    Route::as('cinema.')
        ->middleware([CinemaAuth::class, SwitchLanguageLocale::class, SetLanguageBasedOnCountry::class])
        ->group(function () {
            Route::get('/', [CinemaController::class, 'home'])->name('home');
            Route::get('orders', CinemaOrderHistory::class)->name('order.index');
            Route::get('emails', CinemaEmailIndex::class)->name('email.index');
            Route::get('movie/download', [CinemaController::class, 'movieDownload'])->name('movie.download');
            // Route::get('player', CinemaPlayer::class)->name('player');
            Route::get('player/download', CinemaPlayerDownloadPage::class)->name('player.download');
        });
});

Route::domain(config('filament.customer_portal_url'))->middleware([SwitchLanguageLocale::class, SetLanguageBasedOnCountry::class])
    ->group(
        function () {
            Route::get('/', [CustomerController::class, 'home'])->name('home');
        }
    );

Route::get('storage-link', function () {
    Artisan::call('storage:link');
});

Route::get('cache-clear', function () {
    Artisan::call('cache:clear');
});

Route::get('optimize-clear', function () {
    Artisan::call('optimize:clear');
});

Route::get('reset-password', CustomerResetPassword::class)->name('password.reset');

URL::forceScheme('https');
