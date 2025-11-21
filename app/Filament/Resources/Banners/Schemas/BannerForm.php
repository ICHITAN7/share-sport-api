<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

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
                        })->required(),
                    Select::make('position')
                        ->label('Position')
                        ->options(['header' => 'Header', 'sidebar' => 'Sidebar', 'footer' => 'Footer', 'mobile' => 'Mobile'])
                        ->native(false)
                        ->required(),

                ]),
                Section::make()->schema([
                    Textarea::make('link_url')
                        ->label('Link'),
                    TextInput::make('title'),
                    DatePicker::make('start_at')
                        ->label('Date Start')
                        ->native(false)
                        ->required(),
                    DatePicker::make('end_at')
                        ->label('Date End')
                        ->afterOrEqual('start_at')
                        ->native(false),

                ])
            ])->columns(2);
    }
}
