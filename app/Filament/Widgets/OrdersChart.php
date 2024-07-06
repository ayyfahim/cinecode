<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;


class OrdersChart extends ChartWidget
{
    protected static ?int $sort = 1;

    protected function getType(): string
    {
        return 'line';
    }

    public function getHeading(): string | Htmlable | null
    {
        return __('dashboard.orders_per_month');
    }

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;
        $cinemaCounts = [];

        // Initialize the array with zeros for each month
        for ($month = 1; $month <= 12; $cinemaCounts[$month++] = 0);

        // Fetch cinemas and group by month
        $cinemas = Order::whereYear('created_at', $currentYear)->get();
        foreach ($cinemas as $cinema) {
            $month = Carbon::parse($cinema->created_at)->month;
            $cinemaCounts[$month]++;
        }

        return [
            'datasets' => [
                [
                    'label' => __('dashboard.orders'),
                    'data' => array_values($cinemaCounts),
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
