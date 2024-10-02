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

    public $downloadModal = false;
    public $selectedPlatform;

    #[Validate('accepted')]
    public $eula = false;

    public function downloadPlayer($platform)
    {
        $this->downloadModal = true;
        $this->selectedPlatform = $platform;
    }

    public function confirmDownloadPlayer()
    {
        $this->validate();

        if ($this->selectedPlatform == "windows") {
            $path = config('app.win_player_name');
        } else if ($this->selectedPlatform == "mac_sil") {
            $path = config('app.mac_sil_player_name');
        } else if ($this->selectedPlatform == "mac_intel") {
            $path = config('app.mac_intel_player_name');
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
