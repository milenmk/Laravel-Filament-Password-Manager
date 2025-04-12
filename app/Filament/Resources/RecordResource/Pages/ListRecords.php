<?php

declare(strict_types=1);

namespace App\Filament\Resources\RecordResource\Pages;

use App\Filament\Resources\RecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords as PagesListRecords;

class ListRecords extends PagesListRecords
{
    protected static string $resource = RecordResource::class;

    protected static ?string $navigationLabel = 'Records';

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
