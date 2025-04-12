<?php

declare(strict_types=1);

namespace App\Filament\Resources\RecordResource\Pages;

use App\Filament\Resources\RecordResource;
use App\Services\AuditLogService;
use Filament\Resources\Pages\CreateRecord as PagesCreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRecord extends PagesCreateRecord
{
    protected static string $resource = RecordResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    // Override the handleRecordCreation method to add logging
    protected function handleRecordCreation(array $data): Model
    {
        $record = parent::handleRecordCreation($data);

        // Log the creation of a new record
        AuditLogService::log('create', $record);

        return $record;
    }
}
