<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = [
        'policy_number',
        'user_id',
        'product_id',
        'start_date',
        'end_date',
        'premium_paid',
        'status',
        'approved_by',
        'approved_at',
        'rejection_note'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->policy_number = 'POL-' . now()->format('YmdHis') . rand(100,999);
        });
    }

}
