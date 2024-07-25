<?php

namespace App\Observers;

use App\Mail\DistributorOrderConfirmation;
use App\Models\Order;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // $order = $order->load('movie', 'cinemas', 'version');
        // try {
        //     $data = [];
        //     $data['movie_title'] = $order->movie->name;
        //     $data['cinema_name'] = $order->cinemas->pluck('name')->toArray();
        //     $data['version'] = $order->version->version_name;
        //     $data['validity_from'] = $order->validity_period_from->format('d/m/Y');
        //     $data['validity_to'] = $order->validity_period_to->format('d/m/Y');
        //     Mail::to($order->distributor->email)->locale(App::getLocale())->send(new DistributorOrderConfirmation($data));
        // } catch (\Throwable $th) {
        //     dd($th);
        //     // throw $th;
        // }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
