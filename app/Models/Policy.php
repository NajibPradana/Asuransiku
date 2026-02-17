<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    protected $fillable = [
        'policy_number',
        'user_id',
        'product_id',
        'renewal_from_policy_id',
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

    public function renewalFrom()
    {
        return $this->belongsTo(Policy::class, 'renewal_from_policy_id');
    }

    public function renewals()
    {
        return $this->hasMany(Policy::class, 'renewal_from_policy_id');
    }

    /**
     * Check if policy is expired
     */
    public function isExpired()
    {
        return $this->status === 'expired' || $this->end_date->isPast();
    }

    /**
     * Check if policy can be renewed
     */
    public function canBeRenewed()
    {
        return $this->isExpired();
    }

    /**
     * Check if policy is active
     */
    public function isActive()
    {
        return $this->status === 'active' && $this->end_date->isFuture();
    }

    /**
     * Check if policy is pending approval
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if policy is cancelled/rejected
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->policy_number = 'POL-' . now()->format('YmdHis') . rand(100,999);
        });
    }

}
