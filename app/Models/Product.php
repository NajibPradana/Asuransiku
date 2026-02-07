<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_premium',
        'coverage_amount',
        'is_active'
    ];

    public function policies()
    {
        return $this->hasMany(Policy::class);
    }
}