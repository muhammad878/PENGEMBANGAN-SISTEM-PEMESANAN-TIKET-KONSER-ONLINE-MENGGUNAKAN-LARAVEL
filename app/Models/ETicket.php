<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class ETicket extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_id',
        'order_item_id',
        'code',
        'status',
        'is_used',
        'used_at',
        'event_date',
        'accessed_at',
        'accessed_by',
        'access_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'accessed_at' => 'datetime',
        'used_at' => 'datetime',
        'event_date' => 'datetime',
        'is_used' => 'boolean',
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
        if (Schema::hasTable('e_tickets')) {
            $columns = Schema::getColumnListing('e_tickets');
            $this->fillable = array_intersect($this->fillable, $columns);
        }
        
        parent::__construct($attributes);
    }

    /**
     * Get the user that owns the e-ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order that owns the e-ticket (old structure).
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the order item that owns the e-ticket (new structure).
     */
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the event associated with the ticket.
     */
    public function event()
    {
        // Check which relation should be used based on table structure
        if (Schema::hasColumn('e_tickets', 'order_id')) {
            return $this->order ? $this->order->event() : null;
        } else {
            return $this->orderItem ? $this->orderItem->event() : null;
        }
    }

    /**
     * Get the ticket type associated with this e-ticket.
     */
    public function ticket()
    {
        // Check which relation should be used based on table structure
        if (Schema::hasColumn('e_tickets', 'order_id')) {
            return $this->order ? $this->order->ticket() : null;
        } else {
            return $this->orderItem ? $this->orderItem->ticket() : null;
        }
    }

    /**
     * Check if the e-ticket is valid.
     */
    public function isValid()
    {
        return $this->status === 'active';
    }

    /**
     * Mark e-ticket as used.
     */
    public function markAsUsed($accessedBy = null, $notes = null)
    {
        $this->status = 'used';
        $this->accessed_at = now();
        $this->accessed_by = $accessedBy;
        $this->access_notes = $notes;
        return $this->save();
    }

    /**
     * Get the QR code for the ticket.
     */
    public function getQrCode()
    {
        // Implementation will depend on the QR code package used
        return $this->code;
    }
} 