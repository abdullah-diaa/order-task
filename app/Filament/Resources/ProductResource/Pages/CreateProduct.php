<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->label('Product Name')
                ->maxLength(255),

            Textarea::make('description')
                ->required()
                ->label('Description')
                ->maxLength(1000),

            TextInput::make('sku')
                ->required()
                ->label('SKU')
                ->unique()
                ->maxLength(255),

            TextInput::make('weight')
                ->nullable()
                ->label('Weight')
                ->numeric()
                ->step(0.01),

            Select::make('status')
                ->required()
                ->label('Status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                    'discontinued' => 'Discontinued',
                ])
                ->default('active'),

            TextInput::make('discount_price')
                ->nullable()
                ->label('Discount Price')
                ->numeric()
                ->minValue(0)
                ->step(0.01),

            TextInput::make('price')
                ->required()
                ->label('Price')
                ->numeric()
                ->minValue(0)
                ->step(0.01),

            TextInput::make('stock')
                ->required()
                ->label('Stock')
                ->numeric()
                ->minValue(0)
                ->step(1),
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('save')->label('Save'), // Correct Action usage
        ];
    }
}
