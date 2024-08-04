<?php

namespace App\Livewire\Cinema\Email;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $user = \CinemaUniqueAuth::user();

        return view('livewire.cinema.email.index');
    }
}
