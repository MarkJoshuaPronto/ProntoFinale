<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationModel extends Model
{
    protected $table = 'donations';
    protected $fillable = ['user_id','inneed_id', 'image','name','description','status','item_status','dropofflocation'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function inneed(){
        return $this->belongsTo(InNeedsModel::class,'inneed_id');
    }



    public function recipientRequest()
    {
        return $this->belongsTo(RecipientRequest::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSubcategory($query, $subcategory)
    {
        return $query->where('subcategory', $subcategory);
    }


}
