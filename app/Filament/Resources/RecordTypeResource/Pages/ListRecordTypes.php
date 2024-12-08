<?php

declare(strict_types = 1);

namespace App\Filament\Resources\RecordTypeResource\Pages;

use App\Filament\Resources\RecordTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRecordTypes extends ListRecords
{

    protected static string $resource = RecordTypeResource::class;

    protected static ?string $navigationLabel = 'Record Types';

    protected function getHeaderActions(): array
    {

        return [
            CreateAction::make(),
        ];
    }

}
