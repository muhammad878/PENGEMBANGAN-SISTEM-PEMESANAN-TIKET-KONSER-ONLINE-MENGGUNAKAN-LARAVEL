<?php

namespace App\Policies;

use App\Models\ETicket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ETicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // Users can view their own tickets
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ETicket  $eTicket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ETicket $eTicket)
    {
        // Users can only view their own tickets
        return $user->id === $eTicket->user_id;
    }

    /**
     * Determine whether the user can download the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ETicket  $eTicket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function download(User $user, ETicket $eTicket)
    {
        // Users can only download their own tickets
        return $user->id === $eTicket->user_id;
    }

    /**
     * Determine whether the user can verify the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ETicket  $eTicket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function verify(User $user, ETicket $eTicket)
    {
        // Event organizers can verify tickets for their events
        if ($eTicket->order && $eTicket->order->event && $user->id === $eTicket->order->event->user_id) {
            return true;
        }

        // Admins can verify any ticket
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can mark the model as used.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ETicket  $eTicket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function markAsUsed(User $user, ETicket $eTicket)
    {
        // Event organizers can mark tickets as used for their events
        if ($eTicket->order && $eTicket->order->event && $user->id === $eTicket->order->event->user_id) {
            return true;
        }

        // Admins can mark any ticket as used
        return $user->isAdmin();
    }
} 