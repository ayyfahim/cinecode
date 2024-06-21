<?php

namespace App\Livewire\Customer;

use App\Models\CinemaGroup;
use App\Models\CinemaGroupCinema;
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

    public function render()
    {
        return view('livewire.customer.navbar');
    }
}
