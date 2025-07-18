<?php

namespace App\Filament\Resources\CompanyBrandingResource\Pages;

use App\Filament\Resources\CompanyBrandingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyBrandings extends ListRecords
{
    protected static string $resource = CompanyBrandingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
