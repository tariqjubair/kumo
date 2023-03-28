<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    function relto_ctype(){
        return $this->belongsTo(CoupType::class, 'type');
    }

    function relto_subcata(){
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
