<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    FileUpload::make('image_url')
                        ->label('Thumbnail')
                        ->disk('r2')
                        ->directory('banners')
                        ->deleteUploadedFileUsing(function ($filename) {
                            print $filename;
                        }),
                    Select::make('position')
                        ->options(['header' => 'Header', 'sidebar' => 'Sidebar', 'footer' => 'Footer', 'mobile' => 'Mobile'])
                        ->required(),

                ]),
                Section::make()->schema([
                    Textarea::make('link_url'),
                    TextInput::make('title'),
                    DateTimePicker::make('start_at'),
                    DateTimePicker::make('end_at'),
                ])
            ])->columns(2);
    }
}
