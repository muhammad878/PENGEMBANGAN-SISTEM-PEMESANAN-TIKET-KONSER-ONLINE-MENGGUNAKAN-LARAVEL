<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
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
        // Regular users can see their transactions
        // Admins can see all transactions
        // Organizers can see transactions related to their events
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Transaction $transaction)
    {
        // Users can view their own transactions
        if ($user->id === $transaction->user_id) {
            return true;
        }

        // Event organizers can view transactions for their events
        if ($transaction->event && $user->id === $transaction->event->user_id) {
            return true;
        }

        // Admins can view any transaction
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
        // Any authenticated user can create a transaction
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Transaction $transaction)
    {
        // Users can only update their own transactions if they are pending
        if ($user->id === $transaction->user_id && $transaction->status === 'pending') {
            return true;
        }

        // Event organizers can update transaction status for their events
        if ($transaction->event && $user->id === $transaction->event->user_id) {
            return true;
        }

        // Admins can update any transaction
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Transaction $transaction)
    {
        // Users can cancel their own pending transactions
        if ($user->id === $transaction->user_id && $transaction->status === 'pending') {
            return true;
        }

        // Admins can delete any transaction
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Transaction $transaction)
    {
        // Only admins can restore deleted transactions
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Transaction $transaction)
    {
        // Only admins can permanently delete transactions
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can confirm payment for the transaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function confirmPayment(User $user, Transaction $transaction)
    {
        // Event organizers can confirm payments for their events
        if ($transaction->event && $user->id === $transaction->event->user_id) {
            return true;
        }

        // Admins can confirm any payment
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can refund the transaction.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function refund(User $user, Transaction $transaction)
    {
        // Only event organizers and admins can process refunds
        if ($transaction->event && $user->id === $transaction->event->user_id) {
            return true;
        }

        // Admins can refund any transaction
        return $user->isAdmin();
    }
} 