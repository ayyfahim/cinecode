<?php

namespace App\Livewire\Customer;

use App\Models\Cinema;
use App\Models\CinemaGroup;
use App\Models\CinemaGroupCinema;
use Illuminate\Support\Collection;
use Livewire\Component;

class CinemaGroupModal extends Component
{
    public string $group_name;
    public string $search_cinema = '';

    public Collection $cinemas;
    public Collection $selectedCinemas;
    public Collection $cinemaGroups;

    public bool $isLoading = false;

    public bool $editMode = false;
    public CinemaGroup $selectedCinemaGroup;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->cinemas = collect([]);
        $this->selectedCinemaGroup = new CinemaGroup();
        $this->selectedCinemas = collect([]);
        $this->cinemaGroups = CinemaGroup::with('cinemas')->get();
    }

    public function exception($e)
    {
        $this->isLoading = false;
    }

    public function editCinemaGroup(string $id)
    {
        $this->dispatch('refreshComponent');
        $this->isLoading = true;
        $this->selectedCinemaGroup = CinemaGroup::with('cinemas')->findOrFail($id);
        $this->selectedCinemas = $this->selectedCinemaGroup->cinemas;
        $this->group_name = $this->selectedCinemaGroup->name;
        $this->editMode = true;
        $this->isLoading = false;
    }

    public function updateCinemaGroup()
    {
        $this->isLoading = true;
        if (empty($this->group_name) || !$this->selectedCinemas->count()) {
            // $this->dispatch('toggleModal');
            $this->isLoading = false;
            return;
        }

        CinemaGroup::with('cinemas')->findOrFail($this->selectedCinemaGroup->id)->update([
            'name' => $this->group_name
        ]);

        CinemaGroupCinema::where('cinema_group_id', $this->selectedCinemaGroup->id)->delete();

        foreach ($this->selectedCinemas as $cinema) {
            $cinemaGroup2 = new CinemaGroupCinema();
            $cinemaGroup2->cinema_group_id = $this->selectedCinemaGroup->id;
            $cinemaGroup2->cinema_id = $cinema['id'];
            $cinemaGroup2->save();
        }

        $this->cancelEditCinemaGroup();
    }

    public function cancelEditCinemaGroup()
    {
        $this->selectedCinemaGroup = new CinemaGroup();
        $this->editMode = false;
        $this->search_cinema = '';
        $this->group_name = '';
        $this->search_cinema = '';
        $this->cinemas = collect([]);
        $this->selectedCinemas = collect([]);
        $this->dispatch('refreshComponent');
        $this->isLoading = false;
    }

    public function emptyProps()
    {
        $this->selectedCinemaGroup = new CinemaGroup();
        $this->editMode = false;
        $this->search_cinema = '';
        $this->group_name = '';
        $this->search_cinema = '';
        $this->cinemas = collect([]);
        $this->selectedCinemas = collect([]);
        $this->dispatch('refreshComponent');
        $this->isLoading = false;
    }

    public function selectCinema($id)
    {
        $this->isLoading = true;
        if (!$this->selectedCinemas->where('id', $id)->count()) {
            $this->selectedCinemas->push($this->cinemas->where('id', $id)->first());
        }

        $this->search_cinema = '';
        $this->cinemas = collect([]);
        $this->isLoading = false;
    }

    public function cancelCinema($id)
    {
        $this->isLoading = true;
        if ($this->selectedCinemas->where('id', $id)->count()) {
            $this->selectedCinemas = $this->selectedCinemas->where('id', '!=', $id);
        }

        $this->search_cinema = '';
        $this->cinemas = collect([]);
        $this->isLoading = false;
    }

    public function addCinemaGroup()
    {
        $this->isLoading = true;
        if (empty($this->group_name) | !$this->selectedCinemas->count()) {
            // $this->dispatch('toggleModal');
            $this->isLoading = false;
            return;
        }

        $cinemaGroup = CinemaGroup::create([
            'name' => $this->group_name
        ]);

        foreach ($this->selectedCinemas as $cinema) {
            $cinemaGroup2 = new CinemaGroupCinema();
            $cinemaGroup2->cinema_group_id = $cinemaGroup->id;
            $cinemaGroup2->cinema_id = $cinema['id'];
            $cinemaGroup2->save();
        }

        $this->isLoading = false;
        $this->emptyProps();
        $this->cinemaGroups = CinemaGroup::with('cinemas')->get();
        $this->dispatch('refreshComponent');
    }

    public function toggleModal()
    {
        $this->isLoading = true;
        $this->dispatch('toggleModal');
        $this->isLoading = false;
    }

    public function render()
    {
        if (!empty($this->search_cinema)) {
            $this->isLoading = true;
            $s_query = $this->search_cinema;
            $this->cinemas = Cinema::with([
                'city' => function ($r) {
                    $r->select('name');
                },
                'country' => function ($r) {
                    $r->select('name');
                }
            ])
                ->select('name', 'id')
                ->when($s_query, function ($query) use ($s_query) {
                    $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"')
                        ->orWhereHas('city', function ($query) use ($s_query) {
                            $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"');
                        })
                        ->orWhereHas('country', function ($query) use ($s_query) {
                            $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"');
                        });
                })->get();
            $this->isLoading = false;
        }
        return view('livewire.customer.cinema-group-modal', [
            'cinemas' => $this->cinemas,
            'selectedCinemas' => $this->selectedCinemas,
        ]);
    }
}
