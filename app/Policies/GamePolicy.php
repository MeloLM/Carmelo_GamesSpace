<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        // Tutti possono vedere la lista dei giochi
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Game $game): bool
    {
        // Tutti possono vedere i dettagli di un gioco
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo utenti autenticati possono creare giochi
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Game $game): bool
    {
        // Solo il proprietario può modificare il gioco
        return $user->id === $game->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Game $game): bool
    {
        // Solo il proprietario può eliminare il gioco
        return $user->id === $game->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Game $game): bool
    {
        return $user->id === $game->user_id;
    }
}
