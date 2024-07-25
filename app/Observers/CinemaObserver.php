<?php

namespace App\Observers;

use App\Models\Cinema;

class CinemaObserver
{
    /**
     * Handle the Cinema "created" event.
     */
    public function created(Cinema $cinema): void
    {
        if (empty($cinema->unique_hash)) {
            // Generate a random key and savedHash
            $key = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 20);
            $savedHash = hash("sha256", $key);

            // Set arbitrary validity start and end dates
            $creationDate = $cinema->created_at->format('Y-m-d');

            // Generate a hash number
            $numFiles = Cinema::count();
            $hashNumber = sprintf("%05d", $numFiles + 1);

            // Calculate the hashObject
            $hashObject = hash("sha256", $creationDate . $hashNumber . $savedHash);

            // Create the keyString
            $keyString = "$key:$savedHash:$creationDate:$hashNumber:$hashObject";

            // Insert random characters every second position
            $newKeyString = '';
            for ($i = 0; $i < strlen($keyString); $i++) {
                $newKeyString .= $keyString[$i];
                if ($i % 2 == 1 && $i != strlen($keyString) - 1) {
                    $newKeyString .= substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-:="), 0, 1);
                }
            }

            // Calculate a shorter unique hash and format it
            $shortHash = substr(preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(hash('sha256', $newKeyString, true))), 0, 16);
            $formattedHash = substr($shortHash, 0, 4) . '-' . substr($shortHash, 4, 4) . '-' . substr($shortHash, 8, 4) . '-' . substr($shortHash, 12, 4);

            // Save the unique hash to the cinema
            $cinema->update([
                'unique_hash' => strtolower($formattedHash)
            ]);
        }
    }




    /**
     * Handle the Cinema "updated" event.
     */
    public function updated(Cinema $cinema): void
    {
        //
    }

    /**
     * Handle the Cinema "deleted" event.
     */
    public function deleted(Cinema $cinema): void
    {
        //
    }

    /**
     * Handle the Cinema "restored" event.
     */
    public function restored(Cinema $cinema): void
    {
        //
    }

    /**
     * Handle the Cinema "force deleted" event.
     */
    public function forceDeleted(Cinema $cinema): void
    {
        //
    }
}
