<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InNeedsModel extends Model
{
    protected $table = 'inneeds';
    protected $fillable = ['image','title','description','location','category'];

    public function donations(){
        return $this -> hasMany(DonationModel::class);
    }
}
