<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\EventRegistration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NairobiChapelStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1; // Adjust sort order as needed

    protected function getStats(): array
    {
        return [
            // Stat::make('Total Events', Event::count())
            //     ->description('All scheduled chapel events')
            //     ->descriptionIcon('heroicon-m-calendar-days')
            //     ->color('primary'),
            // Stat::make('Total Registrations', EventRegistration::count())
            //     ->description('Total registrations across all events')
            //     ->descriptionIcon('heroicon-m-user-group')
            //     ->color('success'),
        ];
    }
}