<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
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
        // Users can see a list of their own orders
        // Admins can see all orders
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Order $order)
    {
        // Users can view their own orders
        if ($user->id === $order->user_id) {
            return true;
        }

        // Event organizers can view orders for their events
        foreach ($order->events as $event) {
            if ($user->id === $event->user_id) {
                return true;
            }
        }

        // Admins can view any order
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Any authenticated user can create an order
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Order $order)
    {
        // Users can update their own orders if not yet paid
        if ($user->id === $order->user_id && $order->payment_status !== 'paid') {
            return true;
        }

        // Admins can update any order
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Order $order)
    {
        // Users can cancel their own orders if not yet paid
        if ($user->id === $order->user_id && $order->payment_status !== 'paid') {
            return true;
        }

        // Admins can delete any order
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Order $order)
    {
        // Only admins can restore deleted orders
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Order $order)
    {
        // Only admins can permanently delete orders
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can manage payment for the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function managePayment(User $user, Order $order)
    {
        // Users can manage payment for their own orders
        if ($user->id === $order->user_id) {
            return true;
        }

        // Admins can manage payment for any order
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can download tickets for the order.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function downloadTickets(User $user, Order $order)
    {
        // Users can download tickets for their own paid orders
        if ($user->id === $order->user_id && $order->payment_status === 'paid') {
            return true;
        }

        // Event organizers can validate tickets for their events
        foreach ($order->events as $event) {
            if ($user->id === $event->user_id) {
                return true;
            }
        }

        // Admins can download tickets for any order
        return $user->isAdmin();
    }
} 