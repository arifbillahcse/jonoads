<?php

namespace App\Filament\Resources\EngagementModels\Pages;

use App\Filament\Resources\EngagementModels\EngagementModelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageEngagementModels extends ManageRecords
{
    protected static string $resource = EngagementModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
