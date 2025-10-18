<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecipientRequest extends Model
{
    // Fields that can be mass-assigned
    protected $fillable = [
    'user_id',
    'full_name',
    'contact_number',
    'address',
    'category',
    'subcategory',
    'wearable_type',
    'size',
    'quantity',
    'unit',
    'remaining_quantity',
    'condition',
    'description',
    'urgency',
    'status',
    'specific_items',
    'item_description',
    'accessories_included',
    'functionality_requirement',
    'expiration_preference',
    'admin_notes'
];
    protected $casts = [
    'status' => 'string' // or update your enum values to include 'matched'
    ];

 public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeFulfilled($query)
    {
        return $query->where('status', 'fulfilled');
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function donationMatches()
{
    return $this->hasMany(DonationMatch::class);
}

public function matches()
{
    return $this->hasMany(DonationMatch::class, 'request_id');
}

}


