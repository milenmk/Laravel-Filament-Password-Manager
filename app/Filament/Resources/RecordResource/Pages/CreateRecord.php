<?php

declare(strict_types = 1);

namespace App\Filament\Resources\RecordResource\Pages;

use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\RecordResource;
use Filament\Resources\Pages\CreateRecord as PagesCreateRecord;
use Illuminate\Support\Facades\Crypt;

class CreateRecord extends PagesCreateRecord
{

    protected static string $resource = RecordResource::class;

    protected function getHeaderActions(): array
    {

        return [

        ];
    }

}
