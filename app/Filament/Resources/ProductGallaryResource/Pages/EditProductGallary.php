<?php

namespace App\Filament\Resources\ProductGallaryResource\Pages;

use App\Filament\Resources\ProductGallaryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductGallary extends EditRecord
{
    protected static string $resource = ProductGallaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
