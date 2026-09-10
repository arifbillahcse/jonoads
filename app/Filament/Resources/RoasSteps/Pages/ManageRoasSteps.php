<?php

namespace App\Filament\Resources\RoasSteps\Pages;

use App\Filament\Resources\RoasSteps\RoasStepResource;
use Filament\Resources\Pages\ManageRecords;

class ManageRoasSteps extends ManageRecords
{
    protected static string $resource = RoasStepResource::class;

    /**
     * The engine is a fixed three-stage cycle, so there is no create action —
     * adding a fourth step would break the diagram.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
