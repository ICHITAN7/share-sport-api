<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('password_hash')
                    ->required()
                    ->columnSpanFull()
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->readOnlyOn('edit')
                    ->visibleOn('create'),
                TextInput::make('avatar_url')
                    ->columnSpanFull(),
                Select::make('role')
                    ->options(['admin' => 'Admin', 'writer' => 'Writer', 'viewer' => 'Viewer'])
                    ->default('viewer')
                    ->required(),
            ]);
    }
}
