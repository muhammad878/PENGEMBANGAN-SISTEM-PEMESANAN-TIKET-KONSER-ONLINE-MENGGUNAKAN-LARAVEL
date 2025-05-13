<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
    ];

    /**
     * Get the events that belong to this category.
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'category_id');
    }

    /**
     * Get event count for this category.
     */
    public function getEventCountAttribute()
    {
        return $this->events()->count();
    }
} 