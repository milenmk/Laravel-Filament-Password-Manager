<?php

declare(strict_types = 1);

namespace App\Models;

use App\Models\Scopes\UserScope;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy(UserScope::class)]
class Domain extends Model
{

    use HasFactory;
    use UserTrait;

    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user(): BelongsTo
    {

        return $this->belongsTo(User::class);
    }

    public function records(): HasMany
    {

        return $this->hasMany(Record::class)->with('domain');
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
