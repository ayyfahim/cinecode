<?php

namespace App\Livewire\Components;

use Livewire\Component;

class SortMenu extends Component
{
    public $sort_array;
    public $sort;

    public function updateSort($value)
    {
        $this->dispatch('shop-sort-update', value: $value);
    }

    public function render()
    {
        return view('livewire.components.sort-menu');
    }
}
