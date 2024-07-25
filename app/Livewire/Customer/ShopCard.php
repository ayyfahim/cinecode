<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class ShopCard extends Component
{
    public $movie;

    public function render()
    {
        return view('livewire.customer.shop-card');
    }
}
