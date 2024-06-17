<?php

namespace App\Filament\Rider\Resources\SlotResource\Pages;

use App\Filament\Rider\Resources\SlotResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSlot extends ViewRecord
{
    protected static string $resource = SlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
