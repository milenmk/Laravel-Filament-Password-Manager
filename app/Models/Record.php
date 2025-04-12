<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_type_id',
        'url',
        'username',
        'password',
        'domain_id',
        'password_last_changed',
        'password_expiry_days',
    ];

    public function recordType(): BelongsTo
    {
        return $this->belongsTo(RecordType::class);
    }

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    /**
     * Check if password is expired
     *
     * @return bool
     */
    public function isPasswordExpired(): bool
    {
        if (! $this->password_last_changed) {
            return false;
        }

        $expiryDate = $this->password_last_changed->addDays($this->password_expiry_days);
        return $expiryDate->isPast();
    }

    /**
     * Get days until password expires
     *
     * @return int|null
     */
    public function daysUntilExpiry(): ?int
    {
        if (! $this->password_last_changed || ! $this->password_expiry_days) {
            return null;
        }

        $expiryDate = $this->password_last_changed->addDays($this->password_expiry_days);
        // Calculate the difference in days
        $diff = Carbon::now()->diffInDays($expiryDate, false);

        // Ensure we return an integer
        return (int) max(0, $diff);
    }

    /**
     * Check if password is nearing expiry (within 14 days)
     *
     * @return bool
     */
    public function isPasswordNearingExpiry(): bool
    {
        $days = $this->daysUntilExpiry();
        return $days !== null && $days <= 14 && $days > 0;
    }

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($record): void {
            $record->password_last_changed = Carbon::now();
        });

        static::updating(function ($record): void {
            if ($record->isDirty('password')) {
                $record->password_last_changed = Carbon::now();
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'date',
            'updated_at' => 'date',
            'password_last_changed' => 'datetime',
        ];
    }
}
