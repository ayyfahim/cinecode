<?php

namespace App\Observers;

use App\Models\MovieVersion;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MovieVersionObserver
{
    public function changeFileExtension($movieVersion)
    {
        // Check if the file exists
        if (Storage::disk('public')->exists($movieVersion->mcck_file)) {
            // Check if the file has a .txt extension
            if (preg_match('/\.txt$/', $movieVersion->mcck_file)) {
                // Get the current path and file content
                $path = Storage::disk('public')->path($movieVersion->mcck_file);
                $file = File::get($path);

                // Change the file extension to .mcck
                $newFilePath = preg_replace('/\.txt$/', '.mcck', $movieVersion->mcck_file);

                // Store the file with the new extension
                Storage::disk('public')->put($newFilePath, $file);

                // Delete the old file
                Storage::disk('public')->delete($movieVersion->mcck_file);

                // Update the movieVersion object
                $movieVersion->mcck_file = $newFilePath;
                $movieVersion->save();
            }
        }
    }

    /**
     * Handle the MovieVersion "created" event.
     */
    public function created(MovieVersion $movieVersion): void
    {
        $this->changeFileExtension($movieVersion);
    }

    /**
     * Handle the MovieVersion "updated" event.
     */
    public function updated(MovieVersion $movieVersion): void
    {
        $this->changeFileExtension($movieVersion);
    }

    /**
     * Handle the MovieVersion "deleted" event.
     */
    public function deleted(MovieVersion $movieVersion): void
    {
        //
    }

    /**
     * Handle the MovieVersion "restored" event.
     */
    public function restored(MovieVersion $movieVersion): void
    {
        //
    }

    /**
     * Handle the MovieVersion "force deleted" event.
     */
    public function forceDeleted(MovieVersion $movieVersion): void
    {
        //
    }
}
