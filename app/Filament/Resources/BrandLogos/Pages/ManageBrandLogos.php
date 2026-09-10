<?php

namespace App\Filament\Resources\BrandLogos\Pages;

use App\Filament\Resources\BrandLogos\BrandLogoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageBrandLogos extends ManageRecords
{
    protected static string $resource = BrandLogoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
