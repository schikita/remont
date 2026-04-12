<?php

namespace App\Policies;

use App\Models\Lead;
use App\Models\User;

class LeadPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    public function view(User $user, Lead $lead): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Lead $lead): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Lead $lead): bool
    {
        return $user->is_admin;
    }
}
