<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('summary'),
                MarkdownEditor::make('content')
                    ->required()
                    ->toolbarButtons([
                        ['bold', 'italic', 'strike', 'link'],
                        ['heading'],
                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                        ['table'],
                        ['undo', 'redo'],
                    ])
                    ->fileAttachmentsDisk('r2')
                    ->fileAttachmentsDirectory('News/Markdown')
                    ->columnSpanFull(),
                FileUpload::make('thumbnail_url')
                    ->label('Thumbnail Image')
                    ->disk('r2')
                    ->directory('News/Thumbnails')
                ,
                FileUpload::make('image_url')
                    ->disk('r2')
                    ->directory('News/Images')
                    ->label('Image'),
                FileUpload::make('video_url')
                    ->disk('r2')
                    ->directory('News/Videos')
                    ->label('Video'),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->native(false)
                    ->required(),
                Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->preload(),
                Hidden::make('author_id')
                    ->required()
                    ->default(fn () => Auth::id()),
                DatePicker::make('published_at')
                    ->native(false)
                    ->required(),
                Toggle::make('is_breaking')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_published')
                    ->default(true)
                    ->required(),
            ]);
    }
}
