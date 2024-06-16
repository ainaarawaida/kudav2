<?php

namespace App\Filament\Resources\SlotResource\Pages;

use App\Filament\Resources\SlotResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSlot extends CreateRecord
{
    protected static string $resource = SlotResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : []),
            $this->getCancelFormAction(),
        ];
    }
}
