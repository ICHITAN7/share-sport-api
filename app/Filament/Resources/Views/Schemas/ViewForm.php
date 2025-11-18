<?php

namespace App\Filament\Resources\Views\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ViewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('viewable_type')
                    ->required(),
                TextInput::make('viewable_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_ip'),
                DateTimePicker::make('viewed_at')
                    ->required(),
            ]);
    }
}
