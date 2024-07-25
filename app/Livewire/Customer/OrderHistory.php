<?php

namespace App\Livewire\Customer;

use App\Models\Movie;
use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Order History | Cinecode Customer Portal')]
class OrderHistory extends Component
{
    use WithPagination;

    public $isLoading = false;
    public $search_query = '';
    public $filterByDownloaded = 'show-all';
    public $filterByMovie = 'show-all';
    public $movies;
    public $filterOrderDateFrom;
    public $filterOrderDateTo;

    public function resetFilter()
    {
        $this->reset('filterByDownloaded', 'filterByMovie', 'filterOrderDateFrom', 'filterOrderDateTo');
    }

    public function render()
    {
        $this->isLoading = true;
        $s_query = !empty($this->search_query) ? $this->search_query : false;
        $all_orders = Order::with('cinemas', 'movie', 'version')
            ->where('distributor_id', auth('customer')->user()->distributor_id)
            ->when($s_query, function ($query) use ($s_query) {
                $query->where(function ($query) use ($s_query) {
                    $query->whereHas('movie', function ($query) use ($s_query) {
                        $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"');
                    })
                        ->orWhereHas('cinemas', function ($query) use ($s_query) {
                            $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"');
                        })
                        ->orWhereHas('cinemas', function ($query) use ($s_query) {
                            $query->whereRaw('lower(city_name) like "%' . strtolower($s_query) . '%"');
                        })
                        ->orWhereHas('version', function ($query) use ($s_query) {
                            $query->whereRaw('lower(version_name) like "%' . strtolower($s_query) . '%"');
                        });
                });
            })
            ->when($this->filterOrderDateFrom && $this->filterOrderDateTo, function ($query) {
                $query->whereBetween('created_at', [$this->filterOrderDateFrom, $this->filterOrderDateTo]);
            });

        if ($this->filterByDownloaded == 'yes') {
            $all_orders = $all_orders->where('downloaded', 1);
        } else if ($this->filterByDownloaded == 'no') {
            $all_orders = $all_orders->where('downloaded', 0);
        }

        if ($this->filterByMovie !== 'show-all') {
            $all_orders = $all_orders->where('movie_id', (int) $this->filterByMovie);
        }

        $all_orders = $all_orders->paginate(15);

        $this->movies = $all_orders->pluck('movie')->unique('id');

        $this->isLoading = false;

        return view('livewire.customer.order-history', [
            'orders' => $all_orders,
        ]);
    }
}
