<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
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
        // Everyone can view ticket types
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Ticket $ticket)
    {
        // Anyone can view active tickets
        if ($ticket->status === 'active') {
            return true;
        }

        // Event organizers can view tickets for their events
        if ($ticket->event && $user->id === $ticket->event->user_id) {
            return true;
        }

        // Admins can view any ticket
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  int  $eventId
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, $eventId)
    {
        // Event organizers can create tickets for their events
        $event = \App\Models\Event::find($eventId);
        if ($event && $user->id === $event->user_id) {
            return true;
        }

        // Admins can create tickets for any event
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Ticket $ticket)
    {
        // Event organizers can update tickets for their events
        if ($ticket->event && $user->id === $ticket->event->user_id) {
            return true;
        }

        // Admins can update any ticket
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Ticket $ticket)
    {
        // Event organizers can delete tickets for their events
        // but only if no tickets of this type have been sold
        if ($ticket->event && $user->id === $ticket->event->user_id) {
            // Check if tickets have been sold
            if ($ticket->orderItems()->count() === 0) {
                return true;
            }
        }

        // Admins can delete any ticket that hasn't been sold
        if ($user->isAdmin()) {
            return $ticket->orderItems()->count() === 0;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Ticket $ticket)
    {
        // Only admins can restore deleted tickets
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Ticket $ticket)
    {
        // Only admins can permanently delete tickets
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can adjust the ticket quantity.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function adjustQuantity(User $user, Ticket $ticket)
    {
        // Event organizers can adjust ticket quantities for their events
        if ($ticket->event && $user->id === $ticket->event->user_id) {
            return true;
        }

        // Admins can adjust any ticket quantity
        return $user->isAdmin();
    }
} 