<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\Product;

class OrderStatisticsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalOrders = Order::count();

        // Calculate total sales (total amount)
        $totalSales = Order::sum('total_price');

        // Fetch total number of products sold
        $totalProductsSold = Order::sum('quantity');

        $uniqueUsers = Order::distinct('user_id')->count('user_id');

        $recentOrders = Order::latest()->take(5)->get();

        return [
            // Display statistics in a more visually appealing way
            Stat::make('Total Orders', $totalOrders)
                ->color('primary')
                ->icon('heroicon-s-shopping-cart')
                ->description('Total number of orders placed'),
            
            Stat::make('Total Sales', '$' . number_format($totalSales, 2))
                ->color('success')
                ->icon('heroicon-s-currency-dollar')
                ->description('Total sales value'),

            Stat::make('Products Sold', $totalProductsSold)
                ->color('warning')
                ->icon('heroicon-s-cog')
                ->description('Total quantity of products sold'),

            Stat::make('Unique Users', $uniqueUsers)
                ->color('secondary')
                ->icon('heroicon-s-user')
                ->description('Users who placed at least one order'),
        ];
    }

    // Optionally add a chart for visual representation (line chart for sales over time)
    protected function getChartData(): array
    {
        $orders = Order::selectRaw('DATE(created_at) as date, SUM(quantity * price_at_time_of_addition) as total_sales')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Prepare the labels and data for the chart
        $labels = $orders->pluck('date')->toArray();
        $data = $orders->pluck('total_sales')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Sales Over Time',
                    'data' => $data,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'fill' => true,
                ],
            ],
        ];
    }

    protected function getRecentOrders(): array
    {
        $recentOrders = Order::latest()->take(5)->get();

        return $recentOrders->map(function ($order) {
            return [
                'order_id' => $order->id,
                'user_name' => $order->user ? $order->user->name : 'Guest',
                'total' => '$' . number_format($order->total_price, 2),
                'status' => ucfirst($order->status),
                'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            ];
        })->toArray();
    }
}
