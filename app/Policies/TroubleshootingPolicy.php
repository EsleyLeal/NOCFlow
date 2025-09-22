<?php

namespace App\Policies;

use App\Models\Troubleshooting;
use App\Models\User;

class TroubleshootingPolicy
{
    /**
     * Determina se o usuário pode atualizar o troubleshooting.
     */
    public function update(User $user, Troubleshooting $troubleshooting): bool
    {
        return $user->isAdmin() || $user->id === $troubleshooting->user_id;
    }

    /**
     * Determina se o usuário pode deletar o troubleshooting.
     */
    public function delete(User $user, Troubleshooting $troubleshooting): bool
    {
        return $user->isAdmin() || $user->id === $troubleshooting->user_id;
    }

    /**
     * Determina se o usuário pode visualizar.
     */
    public function view(User $user, Troubleshooting $troubleshooting): bool
    {
        return $user->isAdmin() || $user->id === $troubleshooting->user_id;
    }
}
