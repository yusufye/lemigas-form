<?php

namespace App\Filament\Resources\CodeResource\Pages;

use App\Filament\Resources\CodeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCode extends CreateRecord
{
    protected static string $resource = CodeResource::class;
    protected static bool $canCreateAnother = false;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
