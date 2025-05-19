<?php

namespace App\Filament\Petugas\Resources\ImunisasiResource\Pages;

use App\Filament\Petugas\Resources\ImunisasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImunisasi extends EditRecord
{
    protected static string $resource = ImunisasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
