<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug')
                    ->required()
                    ->readOnly(),
                Textarea::make('summary')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('thumbnail_url')
                    ->columnSpanFull(),
                Textarea::make('image_url')
                    ->columnSpanFull(),
                Textarea::make('video_url')
                    ->columnSpanFull(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                MultiSelect::make('tags')
                    ->relationship('tags', 'name')
                    ->preload(),
                Select::make('author_id')
                    ->relationship('author', 'name')
                    ->required(),
                Toggle::make('is_breaking')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_published')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
