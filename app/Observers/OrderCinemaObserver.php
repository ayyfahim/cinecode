<?php

namespace App\Observers;

use App\Mail\CinemaMovieDownload;
use App\Mail\DistributorMovieDownloadConfirmation;
use App\Models\OrderCinema;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class OrderCinemaObserver
{
    /**
     * Handle the OrderCinema "created" event.
     */
    public function created(OrderCinema $orderCinema): void
    {
        $orderCinema = $orderCinema->load('cinema', 'order', 'order.movie', 'order.version', 'order.distributor', 'order.distributor.distributor');
        $data = [];
        $order = $orderCinema->order;
        $data['movie_title'] = $order?->movie?->name;
        $data['version'] = $order?->version?->version_name;
        $data['distributor'] = $order?->distributor?->distributor?->distributor_name;
        $data['validity_from'] = $order?->validity_period_from?->format('d.m.Y');
        $data['validity_to'] = $order?->validity_period_to?->format('d.m.Y');
        $data['download_link'] = route('cinema.movie.download') . "?token={$orderCinema?->download_token}&order={$orderCinema?->order->id}";
        $data['cinema_login_link'] = config('filament.cinema_portal_url') . '?c=' . $orderCinema?->cinema?->unique_hash;

        $mailLocale = App::getLocale();
        switch ($order->distributor->country->name) {
            case 'Germany':
                $mailLocale = 'de';
                break;
            case 'Austria':
                $mailLocale = 'de';
                break;
            case 'Switzerland':
                $mailLocale = 'de';
                break;
            case 'Luxembourg':
                $mailLocale = 'de';
                break;

            default:
                break;
        }

        Mail::to($order?->distributor?->email)->locale($mailLocale)->send(new CinemaMovieDownload($data));
    }

    /**
     * Handle the OrderCinema "updated" event.
     */
    public function updated(OrderCinema $orderCinema): void
    {
        if ($orderCinema->isDirty('downloaded_movies') && $orderCinema->downloaded_movies) {
            $orderCinema = $orderCinema->load('cinema', 'order', 'order.movie', 'order.version', 'order.distributor.distributor');
            $data = [];
            $order = $orderCinema?->order;
            $data['movie_title'] = $order?->movie?->name;
            $data['version'] = $order?->version?->version_name;
            $data['cinema'] = $orderCinema?->cinema->name;

            $data['validity_from'] = $order?->validity_period_from?->format('d.m.Y');
            $data['validity_to'] = $order?->validity_period_to?->format('d.m.Y');

            $mailLocale = App::getLocale();
            switch ($order->distributor->country->name) {
                case 'Germany':
                    $mailLocale = 'de';
                    break;
                case 'Austria':
                    $mailLocale = 'de';
                    break;
                case 'Switzerland':
                    $mailLocale = 'de';
                    break;
                case 'Luxembourg':
                    $mailLocale = 'de';
                    break;

                default:
                    break;
            }

            Mail::to($order?->distributor?->email)->locale($mailLocale)->send(new DistributorMovieDownloadConfirmation($data));
        }
    }

    /**
     * Handle the OrderCinema "deleted" event.
     */
    public function deleted(OrderCinema $orderCinema): void
    {
        //
    }

    /**
     * Handle the OrderCinema "restored" event.
     */
    public function restored(OrderCinema $orderCinema): void
    {
        //
    }

    /**
     * Handle the OrderCinema "force deleted" event.
     */
    public function forceDeleted(OrderCinema $orderCinema): void
    {
        //
    }
}
