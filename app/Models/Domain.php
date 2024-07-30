<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\UserScope;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy(UserScope::class)]
class Domain extends Model
{
    use HasFactory;
    use HasUuids;
    use UserTrait;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);
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
