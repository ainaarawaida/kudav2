<?php

namespace App\Filament\Coach\Resources\SlotResource\Pages;

use App\Filament\Coach\Resources\SlotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlot extends EditRecord
{
    protected static string $resource = SlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\Action::make('Back')
            ->url(url()->previous())
            ->color('gray'),
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            // $this->getSaveFormAction(),
            // $this->getCancelFormAction(),
        ];
    }
}
