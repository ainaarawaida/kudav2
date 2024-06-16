<?php

namespace App\Filament\Resources\SlotResource\Pages;

use Filament\Actions;
use App\Models\SlotHorse;
use App\Filament\Resources\SlotResource;
use Filament\Resources\Pages\EditRecord;

class EditSlot extends EditRecord
{
    protected static string $resource = SlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function ($record) {
                    $slot_horse = SlotHorse::where('slot_id', $record->id)->delete();
                }),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
