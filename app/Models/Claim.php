<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = [
        'claim_number',
        'policy_id',
        'user_id',
        'incident_date',
        'description',
        'amount_claimed',
        'amount_approved',
        'evidence_files',
        'status',
        'rejection_reason',
        'approved_by',
        'approved_at',
        'paid_at'
    ];

    protected $casts = [
        'incident_date' => 'date',
        'evidence_files' => 'array',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->claim_number = 'CLM-' . now()->format('YmdHis') . rand(100,999);
        });
    }

}