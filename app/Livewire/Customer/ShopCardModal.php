<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class ShopCardModal extends Component
{
    public $product_id;

    public function render()
    {
        return view('livewire.customer.shop-card-modal');
    }
}
