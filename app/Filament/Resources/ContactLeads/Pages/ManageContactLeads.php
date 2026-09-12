<?php

namespace App\Filament\Resources\ContactLeads\Pages;

use App\Filament\Resources\ContactLeads\ContactLeadResource;
use Filament\Resources\Pages\ManageRecords;

class ManageContactLeads extends ManageRecords
{
    protected static string $resource = ContactLeadResource::class;

    /** Enquiries arrive from the site, so there is nothing to create by hand. */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
