<?php

namespace App\Livewire;

use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Masmerise\Toaster\Toaster;

class BaseComponent extends Component
{
    use Toastable;

    // public $validationErrorShown = false;

    // public function boot()
    // {
    //     $this->withValidator(function ($validator) {
    //         $validator->after(function ($validator) {
    //             if (is_array($validator?->errors()?->all()) && count($validator->errors()->all())) {
    //                 $errors = $validator->errors()->all();

    //                 // Check if validation errors are new or already shown
    //                 if (!$this->validationErrorShown || $this->isNewErrors($errors)) {
    //                     $this->validationErrorShown = true;
    //                     foreach ($errors as $value) {
    //                         $this->error($value);
    //                     }
    //                 }
    //             }
    //         });
    //     });
    // }

    // protected function isNewErrors($errors)
    // {
    //     // Compare new errors against previously shown errors, if any
    //     $lastErrors = session()->get('last_errors', []);
    //     return $errors !== $lastErrors;
    // }

    // public function updatedValidationErrors()
    // {
    //     session()->put('last_errors', []);
    // }

    public function exception($e)
    {
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            // Check if validation errors have already been shown
            // if (!$this->validationErrorShown) {
            // $this->validationErrorShown = true;
            foreach ($e->errors() as $key => $error) {
                foreach ($error as $key => $value) {
                    $this->error($value);
                }
            }
            // }
        }
    }
}
