<?php

namespace App\Livewire\Customer;

use App\Models\Movie;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Title('Shop | Cinecode Customer Portal')]
class Shop extends Component
{
    use WithPagination;

    public string $search_query = '';
    public string $sort = 'release_date';
    public array $sort_array = [
        [
            'name' => 'Name',
            'value' => 'name'
        ],
        // [
        //     'name' => 'Visibility',
        //     'value' => 'visibility'
        // ],
        [
            'name' => 'Release Date',
            'value' => 'release_date'
        ],
    ];
    public bool $isLoading = false;
    public bool $modalOpen = false;

    #[On('shop-sort-update')]
    public function updateSort(string $value)
    {
        $this->sort = $value;
    }

    #[On('shop-select-movie')]
    public function selectMovie($value = null)
    {
        if ($value) {
            $this->modalOpen = true;
        } else {
            $this->modalOpen = !$this->modalOpen;
        }
    }

    public function render()
    {
        // if (!empty($this->search_query)) {
        $this->isLoading = true;
        $s_query = $this->search_query != '' ? $this->search_query : false;
        // dd(auth('customer')->user()->distributor->)
        $m = Movie::with('versions', 'distributors')
            ->select('name', 'poster_image', 'id')
            ->whereHas('distributors', function ($query) {
                $query->where('distributor_id', auth('customer')->user()->distributor_id);
            })
            ->when($s_query, function ($query) use ($s_query) {
                $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"');
            });

        if ($this->sort) {
            switch ($this->sort) {
                case 'release_date':
                    $m = $m->orderBy('release_date');
                    break;

                case 'name':
                    $m = $m->orderBy('name');
                    break;

                case 'visibility':
                    $m = $m->orderBy('cinema_visibility');
                    break;

                default:
                    $m = $m->orderBy('release_date');
                    break;
            }
        }
        $m = $m->latest()->paginate(30);
        $this->isLoading = false;
        // }


        return view('livewire.customer.shop', [
            'movies' => $m,
            'sort_array' => $this->sort_array
        ]);
    }
}
