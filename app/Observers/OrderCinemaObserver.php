<?php

namespace App\Observers;

use Exception;
use App\Models\OrderCinema;
use Illuminate\Support\Str;
use App\Models\DistributorEmail;
use App\Mail\CinemaMovieDownload;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\DistributorMovieDownloadConfirmation;

class OrderCinemaObserver
{
    /**
     * Handle the OrderCinema "created" event.
     */
    public function created(OrderCinema $orderCinema): void
    {
        if (empty($orderCinema?->download_token) || $orderCinema?->download_token == null) {
            $string = sha1(rand());
            $token = substr($string, 0, 10);

            $orderCinema->update([
                'download_token' => $token
            ]);
        }

        $orderCinema = $orderCinema->fresh();

        if (!$orderCinema?->cinema || !$orderCinema?->cinema->emails->count()) {
            return;
        }

        $orderCinema = $orderCinema->load('order.version');
        $this->saveCckFile($orderCinema->order);
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

        foreach ($orderCinema?->cinema?->emails as $email) {
            Mail::to($email)->locale($mailLocale)->send(new CinemaMovieDownload($data));
            sleep(1);
            // if (env('MAIL_HOST', false) == 'smtp.mailtrap.io') {
            //     sleep(1); //use usleep(500000) for half a second or less
            // }
        }
        // Mail::to($orderCinema?->cinema->emails->first()->email)->locale($mailLocale)->send(new CinemaMovieDownload($data));
    }

    public function saveCckFile($order)
    {
        // Retrieve the data from the request
        $path = Storage::disk('public')->path($order->version->mcck_file);
        $keyFileContent = File::get($path);
        $validityStart = $order->validity_period_from;
        $validityEnd = $order->validity_period_to;
        $oneTimeKey = "False";
        $cinemahash = $order->cinemas->first()->unique_hash;

        // Perform key file validation
        $keyFileParts = explode(":", $keyFileContent);

        if (count($keyFileParts) === 2) {
            [$key, $savedHash] = $keyFileParts;
            $fileInfo = pathinfo($order->version->mcck_file_name);
            $newFileName = $fileInfo['filename'] . ".ccv";
            $hashObject = hash("sha256", $key . $newFileName);

            // Compare the calculated hash with the saved hash
            if ($hashObject === $savedHash) {
                // Generate new key file
                $outputFolder = storage_path('app/public');

                // Get the current number of files in the output folder
                $numFiles = count(glob($outputFolder . "/*.cck"));

                // Extract parts from the filename
                [
                    $name_title,
                    $ctype,
                    $encryptionFileName,
                    $aspectFileName,
                    $name_language,
                    $framerateFileName,
                    $soundFileName,
                    $runtimeCreditstartFileName,
                    $distributorFileName,
                    $name_date
                ] = explode("_", $fileInfo['filename']);

                $fileName = "Key_" . sprintf("%05d", $numFiles + 1) . "_{$name_title}_{$ctype}_{$name_language}_{$name_date}_valid-from_" .
                    $validityStart->format('Ymd') . "_to_" . $validityEnd->format('Ymd') . ".cck";

                $filePath = $outputFolder . "/" . $fileName;
                $hashNumber = sprintf("%05d", $numFiles + 1);
                $finalHashObject = hash("sha256", $validityStart->format('Y-m-d') . $validityEnd->format('Y-m-d') . $oneTimeKey . $hashNumber . $cinemahash . $savedHash);

                $keyString = "$key:$savedHash:{$validityStart->format('Y-m-d')}:{$validityEnd->format('Y-m-d')}:$oneTimeKey:$hashNumber:$cinemahash:$finalHashObject";

                // Insert random characters every second position
                $newKeyString = '';
                for ($i = 0; $i < strlen($keyString); $i++) {
                    $newKeyString .= $keyString[$i];
                    if ($i % 2 == 1 && $i != strlen($keyString) - 1) {
                        $newKeyString .= Str::random(3);
                    }
                }

                // Add 1024 random characters at the beginning
                $randomPrefix = Str::random(65) . Str::random(65) . Str::random(65) . Str::random(65) .
                    Str::random(65) . Str::random(65) . Str::random(65) . Str::random(65) .
                    Str::random(65) . Str::random(65) . Str::random(65) . Str::random(65) .
                    Str::random(65) . Str::random(65) . Str::random(65);
                $newKeyString = $randomPrefix . Str::random(49) . $newKeyString;

                // Create the new file
                Storage::disk('public')->put($fileName, $newKeyString);

                $order->update([
                    'cck_file' => $fileName
                ]);
            } else {
                throw new Exception("Key file is not valid.");
                // return redirect()->back()->with('error', 'Key file is not valid.');
            }
        } else {
            throw new Exception("Invalid key file format.");
            // return redirect()->back()->with('error', 'Invalid key file format.');
        }
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
                Mail::to($value?->email)->locale($mailLocale)->send(new DistributorMovieDownloadConfirmation($data));
                sleep(1);
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
