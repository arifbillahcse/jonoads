<?php

namespace App\Filament\Resources\ComparisonChecks\Pages;

use App\Filament\Resources\ComparisonChecks\ComparisonCheckResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageComparisonChecks extends ManageRecords
{
    protected static string $resource = ComparisonCheckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
