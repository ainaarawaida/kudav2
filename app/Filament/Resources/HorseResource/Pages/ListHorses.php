<?php

namespace App\Filament\Resources\HorseResource\Pages;

use App\Filament\Resources\HorseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHorses extends ListRecords
{
    protected static string $resource = HorseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
