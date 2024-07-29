<?php

namespace App\Filament\Cinema\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{


    public static function getNavigationLabel(): string
    {
        return __('navigation.dashboard');
    }
}
