<?php

declare(strict_types = 1);

namespace App\Filament\Resources\RecordResource\Pages;

use App\Filament\Resources\RecordResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as PagesEditRecord;

class EditRecord extends PagesEditRecord
{

    protected static string $resource = RecordResource::class;

    protected function getHeaderActions(): array
    {

        return [
            DeleteAction::make(),
        ];
    }

}
