<?php

namespace App\Filament\Coach\Resources\SlotResource\Pages;

use App\Filament\Coach\Resources\SlotResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSlots extends ListRecords
{
    protected static string $resource = SlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
