<?php

namespace App\Providers;

use App\Models\User;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


use Illuminate\Support\Facades\App;
use Filament\Forms;
use Filament\Tables;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(
            function () {
                Filament::registerNavigationGroups([
                    'Management',
                    'Settings',
                ]);
            }
        );

        $locale_codes = array_map(function ($locale) {
            return $locale['code'];
        }, config('translation-manager.available_locales'));

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) use ($locale_codes) {
            $switch
                ->locales($locale_codes)->visible(outsidePanels: true);
        });

        Gate::define('use-translation-manager', function (?User $user) {
            return $user !== null;
        });

        $this->autoTranslateLabels();
    }

    private function autoTranslateLabels()
    {
        $this->translateLabels([
            Forms\Components\TextInput::class,
            Forms\Components\Select::class,
            Forms\Components\Section::class,
            Forms\Components\Toggle::class,
            Forms\Components\Group::class,
            Forms\Components\Repeater::class,
            Forms\Components\DateTimePicker::class,
            Forms\Components\FileUpload::class,

            Tables\Columns\TextColumn::class,
            Tables\Columns\IconColumn::class,

            Tables\Filters\SelectFilter::class,
            Tables\Filters\TernaryFilter::class,
        ]);
    }

    private function translateLabels(array $components = [])
    {
        foreach ($components as $component) {
            $component::configureUsing(function ($c): void {
                $c->translateLabel();
            });
        }
    }
}
