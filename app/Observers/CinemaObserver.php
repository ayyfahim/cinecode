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
            // Save the unique hash to the cinema
            $cinema->update($this->generateChecksum($cinema));
        }
    }

    function generateChecksum($cinema)
    {
        // Fetch the Laravel app key (pepper)
        $pepper = config('app.key');

        // Generate a random key (salt)
        $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 20);

        // Generate a savedHash using the salt
        $salt = hash("sha256", $salt);

        // Use the creation date and cinema ID as sensitive data
        $creationDate = $cinema->created_at->format('Y-m-d');
        $cinemaId = $cinema->id;

        // Generate a hashObject using the sensitive data, salt, and pepper
        $hashObject = hash("sha256", $creationDate . $cinemaId . $salt . $pepper);

        // Create the keyString
        $keyString = "$salt:$creationDate:$cinemaId:$hashObject";

        // Calculate a shorter unique hash and format it
        $shortHash = substr(preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(hash('sha256', $keyString, true))), 0, 16);
        $formattedHash = substr($shortHash, 0, 4) . '-' . substr($shortHash, 4, 4) . '-' . substr($shortHash, 8, 4) . '-' . substr($shortHash, 12, 4);

        // Generate a checksum from the formattedHash
        $checksum = hash("crc32b", $formattedHash);

        // Append the checksum to the formattedHash
        $finalHash = $formattedHash . '-' . substr($checksum, 0, 4);

        // Return all components for verification
        return [
            'unique_hash_salt' => $salt,
            'unique_hash' => $finalHash,
        ];
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
