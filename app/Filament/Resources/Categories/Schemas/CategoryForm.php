<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('name')
                        ->required(),
                    FileUpload::make('icon_url')
                        ->label('Icon')
                        ->disk('r2')
                        ->directory('icons')
                        ->deleteUploadedFileUsing(function ($filename) {
                            print $filename;
                        })->required()
                ]),

//                TextInput::make('slug')
//                    ->required()
//                    ->readOnly(),
            ]);
    }
}
