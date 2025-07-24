<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductGallary;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function afterCreate(): void
    {
        $galleryImages = $this->form->getState()['gallery_images'] ?? [];

        $this->record->gallery()->create([
            'images' => $galleryImages,
        ]);
    }
}
