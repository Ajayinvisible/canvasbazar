<?php

namespace App\Filament\Resources\VariantSizeResource\Pages;

use App\Filament\Resources\VariantSizeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVariantSizes extends ListRecords
{
    protected static string $resource = VariantSizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
