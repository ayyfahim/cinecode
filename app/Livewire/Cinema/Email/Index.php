<?php

namespace App\Livewire\Cinema\Email;

use App\Livewire\BaseComponent;
use App\Models\CinemaEmail;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.cinema')]
#[Title('Emails | Cinecode Cinema Portal')]
class Index extends BaseComponent
{
    use WithPagination;
    public $emailCreateModal = false;
    public $editModal = false;
    public $deleteModal = false;
    public $selectedEmail;

    public $search_query = '';

    #[Validate('required_if_accepted:editModal|email')]
    public $editedEmail = '';

    #[Validate('required_if_accepted:emailCreateModal|email')]
    public $email = '';

    public function createEmail()
    {
        $this->resetErrorBag();
        Validator::make(
            // Data to validate...
            ['email' => $this->email],

            // Validation rules to apply...
            ['email' => 'required|string|email']
        )->validate();

        $user = \CinemaUniqueAuth::user();
        CinemaEmail::create([
            'cinema_id' => $user->id,
            'email' => $this->email
        ]);

        $this->success('Email created successfully.');

        $this->reset();
    }

    public function edit($id)
    {
        $this->resetErrorBag();
        $this->reset();
        $this->editModal = !$this->editModal;
        $this->selectedEmail = CinemaEmail::find($id);
        $this->editedEmail = $this->selectedEmail?->email;
    }

    public function delete($id)
    {
        $this->resetErrorBag();
        $this->reset();
        $this->deleteModal = !$this->deleteModal;
        $this->selectedEmail = CinemaEmail::find($id);
    }

    public function deleteEmail()
    {
        $this->selectedEmail->delete();
        $this->deleteModal = !$this->deleteModal;
        $this->reset();

        $this->success('Email deleted successfully.');
    }

    public function saveEmail()
    {
        $this->validate();

        $this->selectedEmail->update([
            'email' => $this->editedEmail
        ]);

        $this->editModal = !$this->editModal;

        $this->reset();

        $this->success('Email updated successfully.');
    }

    public function render()
    {
        $user = \CinemaUniqueAuth::user();

        $s_query = !empty($this->search_query) ? $this->search_query : false;

        $emails = CinemaEmail::where('cinema_id', $user->id);

        $emails->when($s_query, function ($query) use ($s_query) {
            $query->where(function ($query) use ($s_query) {
                $query->whereRaw('lower(email) like "%' . strtolower($s_query) . '%"');
            });
        });

        $headers = [
            ['key' => 'fakeColumn', 'label' => '#'],
            ['key' => 'email', 'label' => __('cinema_frontend.email')],
        ];

        return view('livewire.cinema.email.index', [
            'emails' => $emails->latest()->paginate(15),
            'headers' => $headers,
        ]);
    }
}
