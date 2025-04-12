<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\RecordType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordTypePolicy
{
    use HandlesAuthorization;

    public function view(User $user, RecordType $recordType): bool
    {
        return $recordType->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return auth()->id() === $user->id;
    }

    public function update(User $user, RecordType $recordType): bool
    {
        return $recordType->user_id === $user->id;
    }

    public function delete(User $user, RecordType $recordType): bool
    {
        return $recordType->user_id === $user->id;
    }

    public function forceDelete(User $user, RecordType $recordType): bool
    {
        return $recordType->user_id === $user->id;
    }
}
