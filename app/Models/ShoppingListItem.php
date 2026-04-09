<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShoppingListItem extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'Fruit & Veg',
        'Dairy',
        'Frozen',
        'Bakery',
        'Household',
        'Other',
    ];

    protected $fillable = [
        'name',
        'quantity',
        'notes',
        'is_completed',
        'category',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'is_completed' => 'boolean',
    ];

    /**
     * Scope a query to a specific category.
     */
    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        if (empty($category) || $category === 'All') {
            return $query;
        }

        return $query->where('category', $category);
    }

    /**
     * Scope a query to only active (not completed) items.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_completed', false);
    }

    /**
     * Scope a query to only completed items.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('is_completed', true);
    }
}
