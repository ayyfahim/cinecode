<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CinemaGroupRequired implements ValidationRule
{
    public $selectedCinemas;

    public function __construct($selectedCinemas)
    {
        $this->selectedCinemas = $selectedCinemas;
    }

    public function __invoke($attribute, $value, $fail)
    {
        if (empty($this->selectedCinemas) && empty($value)) {
            $fail('The selected cinema groups field is required when no cinemas are selected.');
        }
    }
}
