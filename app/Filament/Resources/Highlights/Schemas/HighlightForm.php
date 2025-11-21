<?php

namespace App\Filament\Resources\Highlights\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HighlightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    }),
                Hidden::make('slug')
                ->unique(),
                TextInput::make('summary'),
                FileUpload::make('video_url')
                    ->label('Upload Video')
                    ->required()
                    ->disk('r2')
                    ->directory('highlights'),
                Textarea::make('thumbnail_url')
                    ->label('Link Video'),
                MarkdownEditor::make('content')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        ['bold', 'italic', 'strike', 'link'],
                        ['heading'],
                        ['undo', 'redo'],
                    ])
                    ->label('Content'),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->native(false)
                    ->required(),
                Hidden::make('author_id')
                    ->required()
                    ->default(fn () => Auth::id()),
                DatePicker::make('published_at')
                    ->native(false),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_published')
                    ->default(true)
                    ->required(),
            ]);
    }
}
