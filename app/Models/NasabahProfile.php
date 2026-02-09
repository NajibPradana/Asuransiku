<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NasabahProfile extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'birth_place',
        'birth_date',
        'address',
        'occupation',
        'monthly_income',
        'assets',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
