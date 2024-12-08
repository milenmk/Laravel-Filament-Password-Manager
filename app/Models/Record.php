<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model
{

    use HasFactory;

    protected $fillable = [
        'record_type_id',
        'url',
        'username',
        'password',
        'domain_id',
    ];

    public function recordType(): BelongsTo
    {

        return $this->belongsTo(RecordType::class);
    }

    public function domain(): BelongsTo
    {

        return $this->belongsTo(Domain::class);
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
        ];
    }

}
