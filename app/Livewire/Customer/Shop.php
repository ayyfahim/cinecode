<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Shop | Cinecode Customer Portal')]
class Shop extends Component
{


    public function render()
    {
        return view('livewire.customer.shop');
    }
}
