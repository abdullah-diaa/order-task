<?php
// app/Filament/Resources/UserResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Facades\Hash; // Import the Hash facade

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Users';

    // Form schema for creating/editing users
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Name input
                Forms\Components\TextInput::make('name')
                    ->required(),

                // Email input
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),

                // Password input - will be shown for create, disabled for edit
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->label('Password')
                    ->minLength(8) // Minimum length for password
                    ->required(fn (Forms\Components\TextInput $component) => $component->getState() === null), // Password required only for creation
                   
                // Password confirmation input - only required when creating
                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->label('Confirm Password')
                    ->required(fn (Forms\Components\TextInput $component) => $component->getState() === null) // Only required for creation
                    ->same('password'), // Ensure the password and confirmation match

                // Dropdown for 'role' (user or admin)
                Forms\Components\Select::make('role')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                    ])
                    ->label('Role')
                    ->required(),
            ]);
    }

    // Table schema to display users in the admin panel
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\BooleanColumn::make('active')->label('Active'),
                Tables\Columns\TextColumn::make('role')->label('Role'), // Display role in the table
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // Override save method to hash the password before saving 
    public static function afterSave(User $user): void
    {
        // Hash the password before saving to the database 
        if ($user->password) {
            $user->password = Hash::make($user->password);
            $user->save();
        }
    }

    public static function editUser(User $user, Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                // Name input
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->default($user->name),

                // Email input
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->default($user->email),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->label('Password')
                    ->disabled()
                    ->default('******'), 

                Forms\Components\TextInput::make('password_confirmation')
                    ->password()
                    ->label('Confirm Password')
                    ->required(fn (Forms\Components\TextInput $component) => $component->getState() === null) // Only required for creation
                    ->same('password'),

                // Dropdown for 'role' (user or admin)
                Forms\Components\Select::make('role')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                    ])
                    ->label('Role')
                    ->required(),
            ]);
    }
}
