<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Record;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class AuditLogService
{
    /**
     * Log an action related to a record
     *
     * @param string $action The action being performed (view, create, update, delete)
     * @param  Model|Record|null  $record The record being acted upon
     * @param array|null $details Additional details about the action
     * @return AuditLog|null
     */
    public static function log(string $action, Model|Record|null $record = null, ?array $details = null): ?AuditLog
    {
        // Check if the audit_logs table exists
        if (! Schema::hasTable('audit_logs')) {
            // Log a warning that the table doesn't exist
            Log::warning('Audit logging attempted but audit_logs table does not exist. Please run migrations.');
            return null;
        }

        try {
            return AuditLog::create([
                'user_id' => Auth::id(),
                'record_id' => $record?->id,
                'action' => $action,
                'details' => $details ? json_encode($details) : null,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (Exception $e) {
            // Log the error but don't crash the application
            Log::error('Failed to create audit log: ' . $e->getMessage());
            return null;
        }
    }
}
