<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class OrderHistoryFilterMenu extends Component
{
    public $movies;

    public function render()
    {
        return view('livewire.components.order-history-filter-menu');
    }
}
