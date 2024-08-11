<?php

namespace App\Livewire\Cinema;

use App\Livewire\BaseComponent;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.cinema')]
#[Title('Orders | Cinecode Cinema Portal')]
class OrderHistory extends BaseComponent
{
    use WithPagination;

    public $search_query = '';
    public $filterByDownloaded = 'show-all';
    public $filterByMovie = 'show-all';
    public $filterOrderDateFrom;
    public $filterOrderDateTo;

    public function resetFilter()
    {
        $this->reset('filterByDownloaded', 'filterByMovie', 'filterOrderDateFrom', 'filterOrderDateTo');
    }

    public function download($url)
    {
        return redirect($url);
    }

    public function downloadMcck($id)
    {
        $order = Order::find($id);
        // $file = Storage::disk('public')->get($order->version->mcck_file);
        $file_url = Storage::disk('public')->path($order->version->mcck_file);
        return response()->download($file_url);
    }

    public function render()
    {
        $user = \CinemaUniqueAuth::user();

        $s_query = !empty($this->search_query) ? $this->search_query : false;

        $all_orders = Order::with('movie')->whereHas('order_cinemas', function ($query) use ($user) {
            $query->where('cinema_id', $user->id);
        });

        $all_orders->when($s_query, function ($query) use ($s_query) {
            $query->where(function ($query) use ($s_query) {
                $query->whereHas('movie', function ($query) use ($s_query) {
                    $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"');
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

        $headers = [
            ['key' => 'distributor.distributor_name', 'label' => 'Distributor'],
            ['key' => 'movie.name', 'label' => 'Movie'],
            ['key' => 'version.version_name', 'label' => 'Version'],
            ['key' => 'created_at', 'label' => 'Order Date'],
            ['key' => 'fakeColumn', 'label' => 'Validity Period'],
            ['key' => 'downloadColumn', 'label' => ''],
        ];

        $all_orders = $all_orders->paginate(15);

        return view('livewire.cinema.order-history', [
            'orders' => $all_orders,
            'movies' => $all_orders->pluck('movie')->unique('id'),
            'headers' => $headers
        ]);
    }
}
