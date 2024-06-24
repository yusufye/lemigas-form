<?php

namespace App\Filament\Resources\CodeResource\Pages;

use App\Filament\Resources\CodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCodes extends ListRecords
{
    protected static string $resource = CodeResource::class;

    public static function title()
    {
        return 'Judul Baru - ' . Auth::user()->name;
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
