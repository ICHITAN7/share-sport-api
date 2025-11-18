<?php

namespace App\Filament\Resources\Highlights\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HighlightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('summary')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->columnSpanFull(),
                Textarea::make('thumbnail_url')
                    ->columnSpanFull(),
                Textarea::make('video_url')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('author_id')
                    ->required()
                    ->numeric(),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
