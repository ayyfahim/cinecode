<?php

namespace App\Livewire\Cinema;

use App\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.cinema')]
#[Title('Player Download | Cinecode Cinema Portal')]
class PlayerDownloadPage extends BaseComponent
{
    #[Url]
    public $token;

    public $downloadModal = false;
    public $selectedPlatform;

    #[Validate('accepted')]
    public $eula = false;

    public function mount()
    {
        $user = \CinemaUniqueAuth::user();

        if (empty($user?->player_dt) || $user?->player_dt !== $this->token) {
            return abort(401, 'Wrong token given.');
        }
    }

    public function downloadPlayer($platform)
    {
        $this->downloadModal = true;
        $this->selectedPlatform = $platform;
        // switch ($platform) {
        //     case 'windows':
        //         $path = config('app.win_player_name');
        //         break;
        //     case 'mac_sil':
        //         $path = config('app.mac_sil_player_name');
        //     case 'mac_intel':
        //         $path = config('app.mac_sil_player_name');
        //         break;

        //     default:
        //         $path = config('app.player_name');
        //         break;
        // }

        // $user = \CinemaUniqueAuth::user();

        // $user->update([
        //     'downloaded_player' => now()
        // ]);
        // return redirect()->to(asset($path));
    }

    public function confirmDownloadPlayer()
    {
        $this->validate();

        switch ($this->selectedPlatform) {
            case 'windows':
                $path = config('app.win_player_name');
                break;
            case 'mac_sil':
                $path = config('app.mac_sil_player_name');
            case 'mac_intel':
                $path = config('app.mac_sil_player_name');
                break;

            default:
                $path = config('app.player_name');
                break;
        }

        $user = \CinemaUniqueAuth::user();

        $user->update([
            'downloaded_player' => now()
        ]);
        $this->downloadModal = false;
        return redirect()->to(asset($path));
    }

    public function render()
    {
        return view('livewire.cinema.player-download-page');
    }
}
