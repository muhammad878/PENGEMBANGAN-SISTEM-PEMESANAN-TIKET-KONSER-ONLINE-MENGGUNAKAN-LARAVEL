<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Event;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\ETicket;
use App\Policies\UserPolicy;
use App\Policies\EventPolicy;
use App\Policies\OrderPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\TicketPolicy;
use App\Policies\ETicketPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Event::class => EventPolicy::class,
        Order::class => OrderPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Ticket::class => TicketPolicy::class,
        ETicket::class => ETicketPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define role-based gates for simpler policy checking
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('organizer', function (User $user) {
            return $user->isEventOrganizer();
        });

        Gate::define('active', function (User $user) {
            return $user->isActive();
        });
        
        // Define object-specific gates
        Gate::define('manage-event', function (User $user, Event $event) {
            return $user->id === $event->user_id || $user->isAdmin();
        });
        
        Gate::define('approve-event', function (User $user) {
            return $user->isAdmin();
        });
        
        Gate::define('manage-tickets', function (User $user, Event $event) {
            return $user->id === $event->user_id || $user->isAdmin();
        });
        
        Gate::define('manage-orders', function (User $user, Event $event) {
            return $user->id === $event->user_id || $user->isAdmin();
        });
    }
} 