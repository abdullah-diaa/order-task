<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->rules('unique:products,sku,' . ($form->getRecord() ? $form->getRecord()->id : ''))
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable()->label('Product Name'),
                TextColumn::make('sku')->label('SKU'),
                TextColumn::make('price')->money()->label('Price'),
                TextColumn::make('stock')->label('Stock'),
                TextColumn::make('status')->label('Status'),
                TextColumn::make('discount_price')->money()->label('Discount Price'),
                TextColumn::make('weight')
                    ->label('Weight')
                    ->suffix('kg') // Adds "kg" suffix to the weight
                    ->sortable(),
            ])
            ->filters([ 
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Delete'),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
