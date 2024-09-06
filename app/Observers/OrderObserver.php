<?php

namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\DistributorOrderConfirmation;
use Exception;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $order = $order->load('version');
        $this->saveCckFile($order);
        // try {
        //     $data = [];
        //     $data['movie_title'] = $order->movie->name;
        //     $data['cinema_name'] = $order->cinemas->pluck('name')->toArray();
        //     $data['version'] = $order->version->version_name;
        //     $data['validity_from'] = $order->validity_period_from->format('d.m.Y');
        //     $data['validity_to'] = $order->validity_period_to->format('d.m.Y');
        //     Mail::to($order->distributor->email)->locale(App::getLocale())->send(new DistributorOrderConfirmation($data));
        // } catch (\Throwable $th) {
        //     dd($th);
        //     // throw $th;
        // }
    }

    public function saveCckFile($order)
    {
        // Retrieve the data from the request
        $path = Storage::disk('public')->path($order->version->mcck_file);
        $keyFileContent = File::get($path);
        $validityStart = $order->validity_period_from;
        $validityEnd = $order->validity_period_to;
        $oneTimeKey = "False";

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
                $finalHashObject = hash("sha256", $validityStart->format('Y-m-d') . $validityEnd->format('Y-m-d') . $oneTimeKey . $hashNumber . $savedHash);

                $keyString = "$key:$savedHash:{$validityStart->format('Y-m-d')}:{$validityEnd->format('Y-m-d')}:$oneTimeKey:$hashNumber:$finalHashObject";

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
