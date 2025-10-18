<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

protected $fillable = [
        'user_id',
        'full_name',
        'contact_number',
        'location',
        'category',
        'subcategory',
        'wearable_type',
        'size',
        'quantity',
        'unit', // NEW
        'available_quantity',
        'condition',
        'notes',
        'specific_items',
        'item_description', // NEW
        'accessories_included', // NEW
        'tested_functionality', // NEW
        'data_privacy_agreement', // NEW
        'expiration_date', // NEW
        'is_anonymous', // NEW
        'available_date',
        'donation_photo',
        'status'
    ];

    protected $casts = [
        'data_privacy_agreement' => 'boolean',
        'is_anonymous' => 'boolean',
        'available_date' => 'date',
        'expiration_date' => 'date',
        'status' => 'string' // or update your enum values to include 'matched'

    ];

    // Relationship with matches
    public function matches()
    {
        return $this->hasMany(DonationMatch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donationMatches()
{
    return $this->hasMany(DonationMatch::class);
}

    public function recipientRequest()
{
    return $this->hasOne(RecipientRequest::class);
}

}