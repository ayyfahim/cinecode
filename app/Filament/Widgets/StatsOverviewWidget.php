<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Cinema;
use App\Models\Distributor;
use App\Models\Order;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $startDate = !is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = !is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();

        $isBusinessCustomersOnly = $this->filters['businessCustomersOnly'] ?? null;
        $businessCustomerMultiplier = match (true) {
            boolval($isBusinessCustomersOnly) => 2 / 3,
            blank($isBusinessCustomersOnly) => 1,
            default => 1 / 3,
        };

        // Fetch total credits used
        $creditsUsedQuery = Distributor::query()->where('allow_credit', true);
        if ($startDate) {
            $creditsUsedQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $creditsUsed = $creditsUsedQuery->sum('credits') * $businessCustomerMultiplier;

        // Fetch total players downloaded
        $playersDownloadedQuery = Cinema::query();
        if ($startDate) {
            $playersDownloadedQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $playersDownloaded = $playersDownloadedQuery->whereNotNull('downloaded_player')->count() * $businessCustomerMultiplier;

        // Fetch total new orders
        $newOrdersQuery = Order::query();
        if ($startDate) {
            $newOrdersQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
        $newOrders = $newOrdersQuery->count() * $businessCustomerMultiplier;

        // Dynamic chart data for credits used
        $creditsUsedChartData = $creditsUsedQuery->selectRaw('DATE(created_at) as date, SUM(credits) as total')
            ->groupBy('date')
            ->pluck('total')
            ->toArray();

        // Dynamic chart data for players downloaded
        $playersDownloadedChartData = $playersDownloadedQuery->selectRaw("DATE(downloaded_player) as date, COUNT(*) as total")
            ->whereNotNull('downloaded_player')
            ->groupByRaw("DATE(downloaded_player)")
            ->orderByRaw("DATE(downloaded_player)")
            ->pluck('total')
            ->toArray();

        // Dynamic chart data for new orders
        $newOrdersChartData = $newOrdersQuery->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->pluck('total')
            ->toArray();

        $formatNumber = function (int $number): string {
            if ($number < 1000) {
                return (string) Number::format($number, 0);
            }

            if ($number < 1000000) {
                return Number::format($number / 1000, 2) . 'k';
            }

            return Number::format($number / 1000000, 2) . 'm';
        };

        $creditsUsedText = __('dashboard.credits_used');
        $playersDownloadedText = __('dashboard.players_downloaded');
        $newOrdersText = __('dashboard.new_orders');
        $increaseText = __('dashboard.increase');
        $decreaseText = __('dashboard.decrease');

        return [
            Stat::make($creditsUsedText, $formatNumber((int) $creditsUsed))
                ->description($creditsUsed > 0 ? $increaseText : $decreaseText)
                ->descriptionIcon($creditsUsed > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($creditsUsedChartData)
                ->color($creditsUsed > 0 ? 'success' : 'danger'),
            Stat::make($playersDownloadedText, $formatNumber($playersDownloaded))
                ->description($playersDownloaded > 0 ? $increaseText : $decreaseText)
                ->descriptionIcon($playersDownloaded > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($playersDownloadedChartData)
                ->color($playersDownloaded > 0 ? 'success' : 'danger'),
            Stat::make($newOrdersText, $formatNumber($newOrders))
                ->description($newOrders > 0 ? $increaseText : $decreaseText)
                ->descriptionIcon($newOrders > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($newOrdersChartData)
                ->color($newOrders > 0 ? 'success' : 'danger'),
        ];
    }
}
