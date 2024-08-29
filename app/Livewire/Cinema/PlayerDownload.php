<?php

namespace App\Livewire\Cinema;

use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.cinema')]
#[Title('Player | Cinecode Cinema Portal')]
class PlayerDownload extends BaseComponent
{

    #[Validate('accepted')]
    public $term = false;

    #[Url]
    public $c;

    public function downloadPlayer()
    {
        $this->validate();

        // player_dt

        $user = \CinemaUniqueAuth::user();

        $token = $user?->player_dt;

        if (empty($user?->player_dt)) {
            $string = sha1(rand());
            $token = substr($string, 0, 10);

            $user->update([
                'player_dt' => $token
            ]);
        }

        return redirect()->to(route('cinema.player.download') . "?token={$token}&c={$this->c}");
    }

    public function render()
    {
        return view('livewire.cinema.player-download');
    }
}
