<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Domain $domain): bool {
        return $domain->user_id === $user->id;
    }

    public function create(User $user): bool {
        return auth()->id() === $user->id;
    }

    public function update(User $user, Domain $domain): bool {
        return $domain->user_id === $user->id;
    }

    public function delete(User $user, Domain $domain): bool {
        return $domain->user_id === $user->id;
    }

    public function restore(User $user, Domain $domain): bool {
        return $domain->user_id === $user->id;
    }

    public function forceDelete(User $user, Domain $domain): bool {
        return $domain->user_id === $user->id;
    }
}
