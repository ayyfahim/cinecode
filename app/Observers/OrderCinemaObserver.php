<?php

namespace App\Observers;

use App\Mail\CinemaMovieDownload;
use App\Mail\DistributorMovieDownloadConfirmation;
use App\Models\DistributorEmail;
use App\Models\OrderCinema;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OrderCinemaObserver
{
    /**
     * Handle the OrderCinema "created" event.
     */
    public function created(OrderCinema $orderCinema): void
    {
        $orderCinema = $orderCinema->load('cinema', 'cinema.country', 'order', 'order.movie', 'order.version', 'order.distributor', 'order.distributor.distributor');
        $data = [];
        $order = $orderCinema->order;
        $data['movie_title'] = $order?->movie?->name;
        $data['version'] = $order?->version?->version_name;
        $data['distributor'] = $order?->distributor?->distributor?->distributor_name;
        $data['validity_from'] = $order?->validity_period_from?->format('d.m.Y');
        $data['validity_to'] = $order?->validity_period_to?->format('d.m.Y');

        $download_link = "https://" . config('filament.cinema_portal_url') . '/movie/download' . "?token={$orderCinema?->download_token}&order={$orderCinema?->order->id}&c={$orderCinema?->cinema?->unique_hash}";
        $data['download_link'] = $download_link;

        $mcck_file = $order?->cck_file;
        $data['mcck_file'] = $mcck_file;

        $cinema_login_link = "https://" . config('filament.cinema_portal_url') . "?c={$orderCinema?->cinema?->unique_hash}";
        $data['cinema_login_link'] = $cinema_login_link;

        $mailLocale = App::getLocale();
        switch ($orderCinema?->cinema?->country->name) {
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

        foreach ($orderCinema?->cinema->emails as $email) {
            Mail::to($email)->locale($mailLocale)->queue(new CinemaMovieDownload($data));
            // if (env('MAIL_HOST', false) == 'smtp.mailtrap.io') {
            //     sleep(1); //use usleep(500000) for half a second or less
            // }
        }
        // Mail::to($orderCinema?->cinema->emails->first()->email)->locale($mailLocale)->send(new CinemaMovieDownload($data));
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
            $data['cinema_city'] = $orderCinema?->cinema->city_name;

            $data['validity_from'] = $order?->validity_period_from?->format('d.m.Y');
            $data['validity_to'] = $order?->validity_period_to?->format('d.m.Y');

            $mailLocale = App::getLocale();
            switch ($order->distributor->distributor->country->name) {
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

            foreach ($distributor_emails = DistributorEmail::where('distributor_id', $order?->distributor?->distributor_id)->get() as $value) {
                Mail::to($value?->email)->locale($mailLocale)->queue(new DistributorMovieDownloadConfirmation($data));
            }
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
