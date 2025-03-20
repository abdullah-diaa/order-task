<x-filament::widget>
    <x-filament::card>
        <h3>{{ $heading }}</h3>
        <x-filament::chart
            :data="[
                'labels' => ['January', 'February', 'March', 'April', 'May'],
                'datasets' => [
                    [
                        'label' => 'Sales Data',
                        'data' => [1000, 2000, 1500, 2500, 3000],
                        'backgroundColor' => '#4e73df',
                    ]
                ]
            ]"
            type="bar"
        />
    </x-filament::card>
</x-filament::widget>
