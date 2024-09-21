<?php

namespace App\Livewire\Cinema;

use App\Livewire\BaseComponent;
use App\Models\Order;
use App\Models\OrderCinema;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.cinema')]
#[Title('Order History | Cinecode Cinema Portal')]
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

    public function download($url, $id)
    {
        Order::find($id)->update([
            'downloaded' => 1
        ]);

        $exist = OrderCinema::where([
            'order_id' => $id,
            'cinema_id' => \CinemaUniqueAuth::user()->id,
        ])->first();

        $exist->downloaded_movies = true;
        $exist->save();

        return redirect($url);
    }

    public function downloadMcck($id)
    {
        $order = Order::find($id);
        // $file = Storage::disk('public')->get($order->version->mcck_file);
        $file_url = Storage::disk('public')->path($order->cck_file);
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
            ['key' => 'distributor.distributor.distributor_name', 'label' => __('cinema_frontend.distributor')],
            ['key' => 'movie.name', 'label' => __('cinema_frontend.movie')],
            ['key' => 'version.version_name', 'label' => __('cinema_frontend.version')],
            ['key' => 'created_at', 'label' => __('cinema_frontend.order_date')],
            ['key' => 'fakeColumn', 'label' => __('cinema_frontend.validity_period')],
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
