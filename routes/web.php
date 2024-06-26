<?php

use App\Livewire\Customer\Cinema\Create as CustomerCinemaCrete;
use App\Livewire\Customer\Cinema\Index as CustomerCinemaIndex;
use App\Livewire\Customer\OrderHistory as CustomerOrderHistory;
use App\Livewire\Customer\Settings as CustomerSettings;
use App\Livewire\Customer\Shop as CustomerShop;
use App\Livewire\TestNav;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', TestNav::class);

Route::get('setup', function () {
    Artisan::call('migrate:fresh');
});

Route::prefix('customer')->as('customer.')->group(function () {
    Route::get('shop', CustomerShop::class)->name('shop');
    Route::get('order/history', CustomerOrderHistory::class)->name('order.history');
    Route::get('settings', CustomerSettings::class)->name('settings');
    Route::get('settings/cinemas', CustomerCinemaIndex::class)->name('settings.cinema.index');
    Route::get('settings/cinemas/create', CustomerCinemaCrete::class)->name('settings.cinema.create');
});
