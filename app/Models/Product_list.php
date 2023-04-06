<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product_list extends Model
{
    protected $guarded = ['id'];

    use HasFactory;
    use SoftDeletes;

    function relto_cata(){
        return $this->belongsTo(category::class, 'cata_id');
    }
}
