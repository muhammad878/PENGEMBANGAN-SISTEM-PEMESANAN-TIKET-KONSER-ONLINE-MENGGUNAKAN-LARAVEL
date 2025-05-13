<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_id',
        'ticket_type',
        'price',
        'quota',
        'sold',
        'ticket_code',
        'sale_start_date',
        'sale_end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'quota' => 'integer',
        'sold' => 'integer',
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['isAvailable'];

    /**
     * Get the event that owns the ticket.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the order items for the ticket.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Determine if the ticket is available.
     */
    public function getIsAvailableAttribute()
    {
        return ($this->quota - $this->sold) > 0;
    }

    /**
     * Check if ticket is available
     * 
     * @return bool
     */
    public function isAvailable()
    {
        return ($this->quota - $this->sold) > 0;
    }
    
    /**
     * Get remaining tickets
     * 
     * @return int
     */
    public function getRemainingAttribute()
    {
        return $this->quota - $this->sold;
    }
    
    /**
     * Get name attribute (for backward compatibility)
     */
    public function getNameAttribute()
    {
        return $this->ticket_type;
    }
    
    /**
     * Get type attribute (for backward compatibility)
     */
    public function getTypeAttribute()
    {
        return $this->attributes['ticket_type'] ?? null;
    }
    
    /**
     * Get quantity attribute (for backward compatibility)
     */
    public function getQuantityAttribute()
    {
        return $this->quota;
    }
} 