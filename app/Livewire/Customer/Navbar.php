<?php

namespace App\Livewire\Customer;

use App\Models\CinemaGroup;
use App\Models\CinemaGroupCinema;
use BezhanSalleh\FilamentLanguageSwitch\Events\LocaleChanged;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public bool $modelOpen = false;

    #[On('toggleModal')]
    public function toggleModal()
    {
        $this->modelOpen = !$this->modelOpen;
    }

    public function setNavbarLocale($code = 'en')
    {

        LanguageSwitch::trigger(locale: $code);
    }

    public function doLogout()
    {
        Auth::guard('customer')->logout(); // logging out user
        return redirect()->route('customer.login'); // redirection to login screen
    }

    public function render()
    {
        return view('livewire.customer.navbar');
    }
}
