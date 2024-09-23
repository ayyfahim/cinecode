<?php

namespace App\Livewire\Customer;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Cinema;
use App\Models\Country;
use Livewire\Component;
use App\Models\CinemaEmail;
use App\Models\CinemaGroup;
use App\Models\OrderCinema;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use App\Livewire\BaseComponent;
use Livewire\Attributes\Validate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\DistributorOrderConfirmation;
use App\Models\DistributorEmail;

class ShopCardModal extends BaseComponent
{
    protected $movie_dummy = [
        'name' => '',
        'poster_image' => '',
        'id' => '',
        'description' => '',
        'versions' => [],
    ];

    public $product_id;
    public bool $cinema_mode = false;
    public bool $isLoading = false;
    public $movie = [
        'name' => '',
        'poster_image' => '',
        'id' => '',
        'description' => '',
        'versions' => [],
    ];

    #[Validate('required', as: 'versions')]
    public $selected_version;

    public string $search_query = '';
    public Collection $cinemas;
    public Collection $cinemaGroups;

    #[Validate('required', as: 'validity date from')]
    public string $dateFrom = '';

    #[Validate('required', as: 'validity date to')]
    public string $dateTo = '';

    #[Validate('array', as: 'cinemas', message: 'Please provide at least one cinema or groups...')]
    #[Validate([
        'selectedCinemas.*' => 'exists:cinemas,id'
    ])]
    public $selectedCinemas = [];

    #[Validate('array', as: 'cinema groups', message: 'Please provide at least one cinema or groups...')]
    #[Validate([
        'selectedCinemaGroups.*' => 'exists:cinema_groups,id'
    ])]
    public $selectedCinemaGroups = [];

    public $selectedNames;

    // Cinema Mode

    public $cinemaName = '';
    public $cityName = '';
    public $country = '';
    public $emails = [];
    public $email = '';
    public $countries;

    public function add_emails()
    {
        $validated = Validator::make(
            // Data to validate...
            ['email' => $this->email, 'emails' => $this->emails],

            // Validation rules to apply...
            ['email' => 'required|string|email', 'emails' => 'array', 'emails.*' => 'distinct|email'],

            [
                'required' => 'The :attribute field is required.',
                'email' => 'The :attribute must be an valid email.',
            ]
        )->validate();

        array_push($this->emails, $this->email);

        $this->email = '';
    }

    public function remove_email($key)
    {
        unset($this->emails[$key]);
    }

    public function add_cinema()
    {
        if ($this->isLoading) {
            $this->error('Please wait...');
            return;
        }

        $validated = Validator::make(
            // Data to validate...
            ['name' => $this->cinemaName, 'city_name' => $this->cityName, 'country_id' => $this->country, 'emails' => $this->emails],

            // Validation rules to apply...
            ['emails' => 'array|min:1', 'emails.*' => 'distinct|email', 'name' => 'required|string', 'city_name' => 'required|string', 'country_id' => 'required'],
            [
                'required' => 'The :attribute field is required.',
                'min' => 'Min :min :attribute is required.',
                'email' => 'The :attribute must be an valid email.',
            ],
            ['country_id' => 'country']
        )->validate();

        $validated['distributor_id'] = auth('customer')->user()->distributor_id;
        $validated['visible_to_all'] = false;
        unset($validated['emails']);

        $this->isLoading = true;

        $cinema = Cinema::create($validated);

        foreach ($this->emails as $key => $value) {
            CinemaEmail::create([
                'cinema_id' => $cinema->id,
                'email' => $value
            ]);
        }

        $this->isLoading = false;

        $this->success('Cinema has been created');

        $this->cinema_mode = false;
    }

    // Order Mode

    public function makeOrder()
    {
        if ($this->isLoading) {
            return;
        }

        $this->validate();

        if (!count($this->selectedCinemas) && !count($this->selectedCinemaGroups)) {
            $this->error('Please provide at least one cinema or groups...');
            return;
        }

        $user_credits = auth('customer')->user()->distributor->credits;
        $user_allow_credit = auth('customer')->user()->distributor->allow_credit;

        // __('distributor_frontend.order_has_been_created')

        if (auth('customer')->user()->distributor->allow_credit && $user_credits <= 0) {
            $this->error(__('distributor_frontend.the_order_cannot_be_processed'));
            return;
        }

        $this->isLoading = true;

        try {
            $order_data = [
                'distributor_id' => auth('customer')->id(),
                'movie_id' => $this->movie['id'],
                'downloaded' => 0,
                'version_id' => $this->selected_version,
                'validity_period_from' => Carbon::parse($this->dateFrom, config('app.timezone'))->addDay(1),
                'validity_period_to' => Carbon::parse($this->dateTo, config('app.timezone'))->addDay(1),
            ];

            if (count($this->selectedNames)) {
                foreach ($this->selectedNames as $value) {
                    $string = sha1(rand());
                    $token = substr($string, 0, 10);

                    $order = Order::create($order_data);

                    OrderCinema::create([
                        'cinema_id' => $value['id'],
                        'order_id' => $order->id,
                        'download_token' => $token
                    ]);

                    $this->sendOrderConfirmationMail($order->fresh());
                }
            }
        } catch (\Throwable $th) {
            // dd($th);
            $this->isLoading = false;

            $this->error($th->getMessage());

            $this->dispatch('shop-select-movie');

            return;
        }

        if ($user_allow_credit && $user_credits !== null && $user_credits >= 0) {
            auth('customer')->user()->distributor()->update([
                'credits' => $user_credits - 1
            ]);
        }

        $this->isLoading = false;

        $this->dispatch('shop-select-movie');

        $this->success(__('distributor_frontend.order_has_been_created'));

        $this->reset();

        $this->dateFrom = '';
        $this->dateTo = '';

        $this->selectedNames = collect([]);
        $this->countries = Country::whereIn('name', ['Germany', 'Austria', 'Switzerland', 'Luxembourg'])
            ->orderByRaw("FIELD(name, 'Germany', 'Austria', 'Switzerland', 'Luxembourg')")
            ->get()
            ->union(Country::whereNotIn('name', ['Germany', 'Austria', 'Switzerland', 'Luxembourg'])->get());
    }

    private function sendOrderConfirmationMail(Order $order)
    {
        $order = $order->load('movie', 'cinemas', 'version');
        $data = [];
        $data['movie_title'] = $order->movie->name;

        $data['version'] = $order->version->version_name;
        $data['validity_from'] = $order->validity_period_from->format('d.m.Y');
        $data['validity_to'] = $order->validity_period_to->format('d.m.Y');
        $mailLocale = App::getLocale();
        switch ($order->distributor->distributor->country->name) {
            case 'Germany':
                $mailLocale = 'de';
                break;
            case 'Austria':
                $mailLocale = 'de';
                break;
            case 'Switzerland':
                $mailLocale = 'de';
                break;
            case 'Luxembourg':
                $mailLocale = 'de';
                break;

            default:
                break;
        }

        $data['subject'] = __('site_emails.cinecode_player_screening__order_confirmation', [], $mailLocale);
        $data['subject'] = "{$data['subject']} - {$data['movie_title']}";
        $data['cinema_name'] = [];
        foreach ($order->cinemas as $cinema) {
            array_push($data['cinema_name'], $cinema->name . " " . $cinema->city_name);
            $data['subject'] = "{$data['subject']} - {$cinema->name}";
        }

        foreach ($distributor_emails = DistributorEmail::where('distributor_id', $order?->distributor?->distributor_id)->get() as $value) {
            Mail::to($value?->email)->locale($mailLocale)->send(new DistributorOrderConfirmation($data));
            sleep(1);
        }
    }

    public function mount()
    {
        $this->selectedNames = collect([]);
        $this->countries = Country::whereIn('name', ['Germany', 'Austria', 'Switzerland', 'Luxembourg'])
            ->orderByRaw("FIELD(name, 'Germany', 'Austria', 'Switzerland', 'Luxembourg')")
            ->get()
            ->union(Country::whereNotIn('name', ['Germany', 'Austria', 'Switzerland', 'Luxembourg'])->get());
    }

    public function hydrate()
    {
        if (count($this->movie['versions'])) {
            $this->selected_version = $this->movie['versions'][0]['id'];
        }
    }

    public function toggle_cinema_mode()
    {
        $this->cinema_mode = !$this->cinema_mode;
    }

    #[On('shop-select-movie')]
    public function selectMovie($value = null)
    {
        if (!$this->isLoading && $value) {
            $this->movie = $value;
        }
    }

    #[On('shop-date-changed')]
    public function getDateValues($from = null, $to = null)
    {
        $this->dateFrom = $from;
        $this->dateTo = $to;
    }

    public function updateSelectedNamesForGroups($id)
    {
        // Check if the item already exists in the selectedNames collection
        $exists = $this->selectedNames?->contains(function ($value) use ($id) {
            if (array_key_exists('group_id', $value)) {
                return $value['group_id'] === $id;
            }
        });

        if ($exists) {
            $this->selectedNames = $this->selectedNames?->reject(function ($value) use ($id) {
                if (array_key_exists('group_id', $value)) {
                    return $value['group_id'] === $id;
                }
            })->values();
        } else {
            foreach ($this->cinemaGroups->where('id', $id)->first()->cinemas as $key => $value) {
                $arr = [
                    'group_id' => $id,
                    'id' => $value->id,
                    'name' => $value->name,
                    'city_name' => $value->city_name
                ];

                $this->selectedNames?->push($arr);
            }
        }
    }

    public function updateSelectedNames($id, $name, $city_name = null, $type = 'cinema')
    {
        $arr = [
            'type' => $type,
            'id' => $id,
            'name' => $name
        ];

        if ($city_name) {
            $arr['city_name'] = $city_name;
        }

        if ($type == 'group') {
            $cinema_names = $this->cinemaGroups->where('id', $id)->first()->cinemas->pluck('name')->toArray();

            $arr['cinema_names'] = implode(", ", $cinema_names);
        }

        // Check if the item already exists in the selectedNames collection
        $exists = $this->selectedNames?->contains(function ($value) use ($id, $type) {
            if (array_key_exists('type', $value)) {
                return $value['id'] === $id && $value['type'] === $type;
            }
        });

        if ($exists) {
            // Remove the item from the collection if it exists
            $this->selectedNames = $this->selectedNames?->reject(function ($value) use ($id, $type) {
                if (array_key_exists('type', $value)) {
                    return $value['id'] === $id && $value['type'] === $type;
                }
            })->values();
        } else {
            // Add the item to the collection if it does not exist
            $this->selectedNames?->push($arr);
        }
    }

    public function removeSelectedName($id, $type = 'cinema')
    {
        $this->selectedNames = $this->selectedNames?->reject(function ($value) use ($id, $type) {
            if (array_key_exists('type', $value)) {
                return $value['id'] === $id && $value['type'] === $type;
            }
        })->values();

        if ($type == 'cinema') {

            $this->selectedCinemas = Arr::where($this->selectedCinemas, function ($value) use ($id) {
                return $value !== (string) $id;
            });
        } else if ($type == 'group') {
            $this->selectedCinemaGroups = Arr::where($this->selectedCinemaGroups, function ($value) use ($id) {
                return $value !== (string) $id;
            });
        }
    }

    public function removeSelectedNameForGroup($id, $group_id)
    {
        $this->selectedNames = $this->selectedNames?->reject(function ($value) use ($id, $group_id) {
            if (array_key_exists('group_id', $value)) {
                return $value['id'] === $id && $value['group_id'] === $group_id;
            }
        })->values();

        if ($this->selectedNames?->where('group_id', $group_id)?->count() == 0) {
            $this->selectedCinemaGroups = Arr::where($this->selectedCinemaGroups, function ($value) use ($group_id) {
                return $value !== (string) $group_id;
            });
        }
    }

    public function render()
    {
        $this->isLoading = true;
        $s_query = $this->search_query;
        if (!empty($s_query)) {
            $this->cinemas = Cinema::with('country')
                ->select('name', 'id', 'city_name', 'country_id')
                ->when($s_query, function ($query) use ($s_query) {
                    $query->where(function ($query) use ($s_query) {
                        $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"')
                            ->orWhereRaw('lower(city_name) like "%' . strtolower($s_query) . '%"')
                            ->orWhereHas('country', function ($query) use ($s_query) {
                                $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"');
                            });
                    });
                })
                ->where(function ($query) {
                    $query->where('visible_to_all', 1)
                        ->orWhere(function ($query) {
                            $query->where('visible_to_all', 0)
                                ->where('distributor_id', auth('customer')->user()->distributor_id);
                        });
                })
                ->get();


            $this->cinemaGroups = CinemaGroup::where('distributor_id', auth('customer')->user()->distributor_id)
                ->with('cinemas')
                ->select('name', 'id')
                ->when($s_query, function ($query) use ($s_query) {
                    $query->whereRaw('lower(name) like "%' . strtolower($s_query) . '%"');
                })->get();
        } else {
            $this->cinemas = collect(); // Return empty collection if no search query
            $this->cinemaGroups = collect(); // Return empty collection if no search query
        }

        $this->isLoading = false;

        return view('livewire.customer.shop-card-modal', [
            'cinemas' => $this->cinemas,
            'cinemaGroups' => $this->cinemaGroups
        ]);
    }
}
