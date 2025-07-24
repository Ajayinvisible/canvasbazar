<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\CreateRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $galleryImages = $this->form->getState()['gallery_images'] ?? [];

        // If product has an existing gallery, update it. Otherwise, create one.
        if ($this->record->gallery) {
            $this->record->gallery->update([
                'images' => $galleryImages,
            ]);
        } else {
            $this->record->gallery()->create([
                'images' => $galleryImages,
            ]);
        }
    }
}
