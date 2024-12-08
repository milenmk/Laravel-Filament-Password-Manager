<?php

declare(strict_types = 1);

namespace App\Filament\Resources\RecordResource\Pages;

use App\Filament\Resources\RecordResource;
use Filament\Resources\Pages\CreateRecord as PagesCreateRecord;

class CreateRecord extends PagesCreateRecord
{

    protected static string $resource = RecordResource::class;

    protected function getHeaderActions(): array
    {

        return [

        ];
    }

}
