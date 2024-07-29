<?php

namespace App\Livewire\Cinema;

use App\Livewire\BaseComponent;
use App\Models\Cinema;
use App\Models\CinemaEmail;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Login | Cinecode Cinema Portal')]
class Login extends BaseComponent
{
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required', as: 'cinema hash')]
    #[Url]
    public $c = '';

    public $isDisabled = false;

    public function login()
    {
        $validated = $this->validate();

        if (empty($this->c)) {
            $this->error('No cinema hash found.');
            $this->isDisabled = true;

            return;
        }

        $cinema = Cinema::where('unique_hash', $this->c)->first();

        if (empty($cinema)) {
            $this->error('Cinema hash don\'t exist.');
            $this->isDisabled = true;

            return;
        }

        if (!CinemaEmail::where('email', $this->email)->where('cinema_id', $cinema->id)->first()) {
            $this->error('Email not found.');

            return;
        }

        if ($this->verifyChecksum($cinema)) {
            Auth::guard('cinema')->login($cinema);

            return redirect('/admin');

            return;
        }

        $this->error('An error happened. Please try again later');
    }

    public function test()
    {
        $this->error('Test.');
    }

    public function verifyChecksum($cinema)
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
        return $formattedHash === $originalChecksum;
    }

    public function render()
    {
        return view('livewire.cinema.login');
    }
}
