<?php

namespace App\Livewire\Customer;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Settings | Cinecode Customer Portal')]
class Settings extends Component
{
    public function render()
    {
        return view('livewire.customer.settings');
    }
}
