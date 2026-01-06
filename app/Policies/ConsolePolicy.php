<?php

namespace App\Policies;

use App\Models\Console;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     * 
     * Note: "Console" nel contesto di questo progetto rappresenta un BOSS
     * del videogioco Dark Souls, NON una console di gioco.
     */
    public function viewAny(?User $user): bool
    {
        // Tutti possono vedere la lista dei boss
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Console $console): bool
    {
        // Tutti possono vedere i dettagli di un boss
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo utenti autenticati possono creare boss
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Console $console): bool
    {
        // Solo il proprietario può modificare il boss
        return $user->id === $console->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Console $console): bool
    {
        // Solo il proprietario può eliminare il boss
        return $user->id === $console->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Console $console): bool
    {
        return $user->id === $console->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Console $console): bool
    {
        return $user->id === $console->user_id;
    }
}
