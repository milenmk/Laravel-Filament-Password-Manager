<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Record;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordPolicy
{

    use HandlesAuthorization;

    public function view(User $user, Record $record): bool
    {

        return true;
    }

    public function create(User $user): bool
    {

        return auth()->id() === $user->id;
    }

    public function update(User $user, Record $record): bool
    {

        return $record->domain->user_id === $user->id;
    }

    public function delete(User $user, Record $record): bool
    {

        return $record->domain->user_id === $user->id;
    }

    public function forceDelete(User $user, Record $record): bool
    {

        return $record->domain->user_id === $user->id;
    }

}
