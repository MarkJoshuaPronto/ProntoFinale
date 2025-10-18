<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportModel extends Model
{
    protected $table = 'supports';
    protected $fillable = ['name','email','address'];
}
