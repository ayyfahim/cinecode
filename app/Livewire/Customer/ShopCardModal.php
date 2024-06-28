<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class ShopCardModal extends Component
{
    public $product_id;
    public bool $cinema_mode = false;

    public function toggle_cinema_mode()
    {
        $this->cinema_mode = !$this->cinema_mode;
    }

    public function render()
    {
        return view('livewire.customer.shop-card-modal');
    }
}
