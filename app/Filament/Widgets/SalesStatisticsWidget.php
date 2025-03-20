<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;

class SalesStatisticsWidget extends ChartWidget
{
    protected static ?string $heading = 'Sales Statistics';

    protected function getData(): array
    {
        // Static test data
        $salesData = [
            ['date' => '2025-03-10', 'total_sales' => 1500],
            ['date' => '2025-03-11', 'total_sales' => 1800],
            ['date' => '2025-03-12', 'total_sales' => 2000],
            ['date' => '2025-03-13', 'total_sales' => 2200],
            ['date' => '2025-03-14', 'total_sales' => 2500],
            ['date' => '2025-03-15', 'total_sales' => 2700],
            ['date' => '2025-03-16', 'total_sales' => 3000],
            ['date' => '2025-03-17', 'total_sales' => 3200],
            ['date' => '2025-03-18', 'total_sales' => 3500],
            ['date' => '2025-03-19', 'total_sales' => 3800],
        ];
    
        return [
            'datasets' => [
                [
                    'label' => 'Total Sales',
                    'data' => collect($salesData)->map(fn ($sale) => [
                        'x' => $sale['date'],
                        'y' => $sale['total_sales'],
                    ])->toArray(),
                ],
            ],
        ];
    }
    

    protected function getType(): string
    {
        return 'scatter'; // Scatter chart
    }
}
