<?php

namespace App\Livewire\Customer;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Settings | Cinecode Customer Portal')]
class Settings extends BaseComponent
{
    #[Validate('required|confirmed|min:6')]
    public $password = '';

    #[Validate('required')]
    public $password_confirmation = '';

    #[Validate('required')]
    public $current_password = '';

    public function changePassword()
    {
        $this->validate();

        if (!Hash::check($this->current_password, auth('customer')->user()->password)) {
            $this->error('Your current password do not match.');
        }

        auth('customer')->user()->update([
            'password' => Hash::make($this->password)
        ]);

        $this->success('Your password has been changed.');

        $this->reset('password', 'password_confirmation', 'current_password');
    }

    public function render()
    {
        return view('livewire.customer.settings');
    }
}
