<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'event_id',
        'ticket_id',
        'quantity',
        'price',
        'subtotal',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'quantity' => 'integer',
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
        if (Schema::hasTable('order_items')) {
            $columns = Schema::getColumnListing('order_items');
            $this->fillable = array_intersect($this->fillable, $columns);
        }
        
        parent::__construct($attributes);
    }

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the ticket that belongs to the order item.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the event that belongs to the order item.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    
    /**
     * Get the e-tickets for the order item
     */
    public function eTickets()
    {
        return $this->hasMany(ETicket::class);
    }
} 