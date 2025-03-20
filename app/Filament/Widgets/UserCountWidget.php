<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class UserCountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Get the count of users
        $userCount = User::count();

        return [
            Stat::make('Registered Users', $userCount),
        ];
    }
}
