<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\NumberInput;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';  

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('cart_item_id')
                    ->relationship('cartItem', 'id')  
                    ->required()
                    ->label('Cart Item'),

                // Cart Relation
                Select::make('cart_id')
                    ->relationship('cart', 'id')
                    ->required()
                    ->label('Cart'),

                Select::make('user_id')
                    ->relationship('user', 'name')  // Use Select for relationships
                    ->nullable()
                    ->label('User'),

                // Product Relation (Fixed)
                Select::make('product_id')  
                    ->relationship('product', 'name')  
                    ->required()
                    ->label('Product'),

                TextInput::make('quantity')
                    ->required()
                    ->label('Quantity')
                    ->numeric() 
                    ->minValue(1)
                    ->step(1)
                    ->default(1)
                    ->rules('integer|min:1|max:999'),
                
                TextInput::make('price_at_time_of_addition')
                    ->required()
                    ->label('Price at Time of Addition')
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->default(0)
                    ->rules('numeric|min:0'), 
                
                TextInput::make('total_price')
                    ->required()
                    ->label('Total Price')
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->default(0)
                    ->rules('numeric|min:0'), 
                


                Select::make('status')
                    ->required()
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ])
                    ->default('pending'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cartItem.id')->sortable()->label('Cart Item ID')->searchable(),
                TextColumn::make('cart.id')->label('Cart ID')->searchable(),
                TextColumn::make('user.name')->label('User Name')->searchable(),  // here is for searching using the use name
                TextColumn::make('product.name')->label('Product')->searchable(),
                TextColumn::make('quantity')->label('Quantity')->searchable(),
                TextColumn::make('price_at_time_of_addition')->money()->label('Price at Time of Addition')->searchable(),
                TextColumn::make('total_price')->money()->label('Total Price')->searchable(),
                TextColumn::make('status')->label('Status')->searchable(),
            ])
            ->filters([ 
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
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
