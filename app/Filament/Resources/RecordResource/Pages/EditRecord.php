<?php

declare(strict_types=1);

namespace App\Filament\Resources\RecordResource\Pages;

use App\Filament\Resources\RecordResource;
use App\Services\AuditLogService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord as PagesEditRecord;

class EditRecord extends PagesEditRecord
{
    protected static string $resource = RecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->before(function (): void {
                AuditLogService::log('delete', $this->record);
            }),
        ];
    }

    protected function afterSave(): void
    {
        // Log the edit of a record
        AuditLogService::log('edit', $this->record);
    }
}
