<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Calendar extends Component
{
    public $id;

    public function render()
    {
        return view('livewire.components.calendar');
    }
}
