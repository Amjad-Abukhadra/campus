<?php

namespace App\Filament\Widgets;

use App\Models\Apartment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Landlords', User::whereHas('roles', fn($q) => $q->where('name', 'landlord'))->count())
                ->description('Registered landlords')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),
            
            Stat::make('Active Apartments', Apartment::where('status', 'approved')->count())
                ->description('Approved listings')
                ->descriptionIcon('heroicon-m-home')
                ->color('success'),

            Stat::make('Pending Apartments', Apartment::where('status', 'pending')->count())
                ->description('Waiting for review')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
