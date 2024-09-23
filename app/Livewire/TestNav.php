<?php

namespace App\Livewire;

use App\Models\Cinema;
use App\Models\Country;
use Livewire\Component;

class TestNav extends Component
{
    public function mount()
    {
        $countries = Country::pluck('name')->mapWithKeys(function ($country) {
            return [$country => $country];  // Mapping country names with empty values
        })->toArray();

        dd(json_encode($countries, JSON_PRETTY_PRINT));

        $cinema = Cinema::find(27);

        dd($this->verifyChecksum($cinema));
    }

    function verifyChecksum($cinema)
    {
        // Fetch the Laravel app key (pepper)
        $pepper = config('app.key');

        // Extract components from checksum data
        $salt = $cinema->unique_hash_salt;
        $creationDate = $cinema->created_at->format('Y-m-d');
        $cinemaId = $cinema->id;
        $originalChecksum = $cinema->unique_hash;

        // Generate a hashObject using the sensitive data, salt, and pepper
        $hashObject = hash("sha256", $creationDate . $cinemaId . $salt . $pepper);

        // Create the keyString
        $keyString = "$salt:$creationDate:$cinemaId:$hashObject";

        // Calculate a shorter unique hash and format it
        $shortHash = substr(preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(hash('sha256', $keyString, true))), 0, 16);
        $formattedHash = substr($shortHash, 0, 4) . '-' . substr($shortHash, 4, 4) . '-' . substr($shortHash, 8, 4) . '-' . substr($shortHash, 12, 4);

        // Compare the generated checksum with the original checksum
        dd($formattedHash, $originalChecksum);
        return $formattedHash === $originalChecksum;
    }

    function verifyChecksum2($cinema)
    {
        // Fetch the Laravel app key (pepper)
        $pepper = config('app.key');

        // Extract components from checksum data
        $salt = $cinema->unique_hash_salt;
        $creationDate = $cinema->created_at->format('Y-m-d');
        $cinemaId = $cinema->id;
        $originalChecksum = $cinema->unique_hash;

        // Generate a hashObject using the sensitive data, salt, and pepper
        $hashObject = hash("sha256", $creationDate . $cinemaId . $salt . $pepper);

        // Create the keyString
        $keyString = "$salt:$creationDate:$cinemaId:$hashObject";

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

        // Compare the generated checksum with the original checksum
        dd($formattedHash, $originalChecksum);
        return $formattedHash === $originalChecksum;
    }

    public function render()
    {
        return view('livewire.test-nav');
    }
}
