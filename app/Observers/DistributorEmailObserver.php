<?php

namespace App\Observers;

use App\Mail\DistributorGeneratePassword;
use App\Models\DistributorEmail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class DistributorEmailObserver
{
    /**
     * Handle the DistributorEmail "created" event.
     */
    public function created(DistributorEmail $distributorEmail): void
    {
        if (empty($distributorEmail->password_generate_token)) {
            $string = sha1(rand());
            $token = substr($string, 0, 10);
        }

        $url = config('app.url') . "/customer/generate-password?token=$token&email=$distributorEmail->email";

        $mailLocale = App::getLocale();
        switch ($distributorEmail?->distributor?->country->name) {
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

        $data = [];
        $data['url'] = $url;

        Mail::to($distributorEmail->email)->locale($mailLocale)->queue(new DistributorGeneratePassword($data));

        $distributorEmail->update([
            'password_generate_token' => $token
        ]);
    }

    /**
     * Handle the DistributorEmail "updated" event.
     */
    public function updated(DistributorEmail $distributorEmail): void
    {
        //
    }

    /**
     * Handle the DistributorEmail "deleted" event.
     */
    public function deleted(DistributorEmail $distributorEmail): void
    {
        //
    }

    /**
     * Handle the DistributorEmail "restored" event.
     */
    public function restored(DistributorEmail $distributorEmail): void
    {
        //
    }

    /**
     * Handle the DistributorEmail "force deleted" event.
     */
    public function forceDeleted(DistributorEmail $distributorEmail): void
    {
        //
    }
}
