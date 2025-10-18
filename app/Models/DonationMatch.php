<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationMatch extends Model
{
    use HasFactory;

    protected $table = 'donation_matches';

 protected $fillable = [
        'request_id',
        'donation_id',
        'allocated_quantity',
        'status',
        'admin_notes',
        'matched_at'
    ];

    protected $casts = [
        'matched_at' => 'datetime',
    ];


    public function donation()
{
    return $this->belongsTo(Donation::class, 'donation_id');
}

public function request()
{
    return $this->belongsTo(RecipientRequest::class, 'request_id');
}
}
