<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartResource\Pages;
use App\Models\Cart;
use App\Models\User;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->required()
                    ->label('Cart Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active'),

                // Show the user's name instead of their ID (Display only, not editable)
                TextInput::make('user_id')
                    ->default(function ($get) {
                        $userId = $get('user_id'); 
                        if ($userId) {
                            $user = User::find($userId); 
                            return $user ? $user->name : 'No user'; 
                        }
                        return null; 
                    })
                    ->label('User')
                    ->disabled()  // Disabled so it can't be edited
                    ->helperText('The user assigned to this cart will be shown here.')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->sortable()->searchable()->label('User Name'),
                TextColumn::make('status')->label('Cart Status'),
                TextColumn::make('created_at')->dateTime()->label('Created At'),
                TextColumn::make('updated_at')->dateTime()->label('Updated At'),
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
            'index' => Pages\ListCarts::route('/'),

          
        ];
    }
}
