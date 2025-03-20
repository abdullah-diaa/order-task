<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartItemResource\Pages;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Product; // Add the Product model import
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class CartItemResource extends Resource
{
    protected static ?string $model = CartItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('quantity')
                    ->required()
                    ->label('Quantity')
                    ->numeric()
                    ->minValue(1),

                // Price at time of addition (Editable)
                TextInput::make('price_at_time_of_addition')
                    ->required()
                    ->label('Price at Time of Addition')
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01),

                Select::make('cart_id')
                    ->label('Cart')
                    ->options(Cart::all()->pluck('id', 'id'))  
                    ->required()
                    ->placeholder('Select a cart'),

                Select::make('product_id')
                    ->label('Product')
                    ->options(Product::all()->pluck('name', 'id')) 
                    ->required()
                    ->placeholder('Select a product')
                    ->reactive() // Make it reactive to display related data dynamically
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($product = Product::find($state)) {
                            $set('product_name', $product->name); 
                        }
                    }),

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cart_id')
                    ->sortable()
                    ->searchable()
                    ->label('Cart ID'),

                TextColumn::make('cart.user.name')
                    ->sortable()
                    ->searchable()
                    ->label('User Name'),

                TextColumn::make('product.name')
                    ->sortable()
                    ->searchable()
                    ->label('Product Name'),

                TextColumn::make('quantity')
                    ->sortable()
                    ->label('Quantity'),

                TextColumn::make('price_at_time_of_addition')
                    ->money()
                    ->sortable()
                    ->label('Price at Time of Addition'),

                // New Column: Total Price (Quantity * Price)
                TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money()
                    ->sortable()
                    ->getStateUsing(fn ($record) => ($record->quantity ?? 0) * ($record->price_at_time_of_addition ?? 0)),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At'),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Updated At'),
            ])
            ->filters([ 
            ])
            ->actions([ 
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Delete'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCartItems::route('/'),
            'create' => Pages\CreateCartItem::route('/create'),
        ];
    }
}
