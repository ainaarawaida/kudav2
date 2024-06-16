<?php

namespace App\Filament\Resources\HorseResource\Pages;

use App\Filament\Resources\HorseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHorse extends EditRecord
{
    protected static string $resource = HorseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
