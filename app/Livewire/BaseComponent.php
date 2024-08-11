<?php

namespace App\Livewire;

use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Masmerise\Toaster\Toaster;

class BaseComponent extends Component
{
    use Toastable;

    public function exception($e)
    {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            foreach ($e->errors() as $key => $error) {
                foreach ($error as $key => $value) {
                    $this->error($value);
                }
            }
        }
    }
}
