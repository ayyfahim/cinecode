<?php

namespace App\Policies;

use App\Interfaces\UserInterface;
use App\Models\Cinema;
use App\Models\CinemaEmail;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CinemaEmailPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(UserInterface $user): bool
    // {
    //     return true;
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserInterface $user, CinemaEmail $cinemaEmail): bool
    {
        if (get_class($user) !== get_class(new User)) {
            if (get_class($user) == get_class(new Cinema)) {
                return $cinemaEmail->cinema_id == $user->id;
            }
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserInterface $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserInterface $user, CinemaEmail $cinemaEmail): bool
    {
        if (get_class($user) !== get_class(new User)) {
            if (get_class($user) == get_class(new Cinema)) {
                return $cinemaEmail->cinema_id == $user->id;
            }
        }



        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserInterface $user, CinemaEmail $cinemaEmail): bool
    {
        if (get_class($user) !== get_class(new User)) {
            if (get_class($user) == get_class(new Cinema)) {
                return $cinemaEmail->cinema_id == $user->id;
            }
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, CinemaEmail $cinemaEmail): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, CinemaEmail $cinemaEmail): bool
    // {
    //     //
    // }
}
