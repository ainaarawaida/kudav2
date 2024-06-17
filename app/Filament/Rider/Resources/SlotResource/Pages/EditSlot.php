<?php

namespace App\Filament\Rider\Resources\SlotResource\Pages;

use App\Filament\Rider\Resources\SlotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSlot extends EditRecord
{
    protected static string $resource = SlotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
            Actions\Action::make('Back')
            ->url(url()->previous())
            ->color('gray'),
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
