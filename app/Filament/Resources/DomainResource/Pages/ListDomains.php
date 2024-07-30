<?php

declare(strict_types=1);

namespace App\Filament\Resources\DomainResource\Pages;

use App\Filament\Resources\DomainResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDomains extends ListRecords
{
    protected static string $resource = DomainResource::class;

    protected static ?string $navigationLabel = 'Domains';

    protected function getHeaderActions(): array
    {

        return [
            CreateAction::make(),
        ];
    }

}
