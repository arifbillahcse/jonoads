<?php

namespace App\Filament\Resources\ComparisonMetrics\Pages;

use App\Filament\Resources\ComparisonMetrics\ComparisonMetricResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageComparisonMetrics extends ManageRecords
{
    protected static string $resource = ComparisonMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
