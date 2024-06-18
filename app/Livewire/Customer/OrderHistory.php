<?php

namespace App\Livewire\Customer;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order History | Cinecode Customer Portal')]
class OrderHistory extends Component
{
    public function render()
    {
        return view('livewire.customer.order-history');
    }
}
