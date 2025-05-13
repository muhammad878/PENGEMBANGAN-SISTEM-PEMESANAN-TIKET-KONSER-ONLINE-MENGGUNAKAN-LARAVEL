<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'order_number',
        'status',
        'payment_status',
        'payment_method',
        'total_amount',
        'transaction_id',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    /**
     * Create a new instance of the model.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        // First make sure only existing columns are in fillable
        if (Schema::hasTable('orders')) {
            $columns = Schema::getColumnListing('orders');
            $this->fillable = array_intersect($this->fillable, $columns);
        }
        
        parent::__construct($attributes);
    }

    /**
     * Get the user that made the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment information for this order.
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the e-tickets related to this order.
     */
    public function eTickets()
    {
        return $this->hasMany(ETicket::class);
    }

    /**
     * Get the tickets related to this order through order items.
     */
    public function tickets()
    {
        return $this->hasManyThrough(Ticket::class, OrderItem::class, 'order_id', 'id', 'id', 'ticket_id');
    }

    /**
     * Get the events related to this order through tickets.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'order_items', 'order_id', 'event_id')
            ->distinct()
            ->withTimestamps();
    }

    /**
     * Get the event that this order is for (direct relation).
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Determine if the order is paid.
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber()
    {
        $prefix = 'KUY';
        $timestamp = now()->format('YmdHis');
        $random = rand(1000, 9999);
        
        return $prefix . $timestamp . $random;
    }
} 