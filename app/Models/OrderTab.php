<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTab extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function relto_custinfo(){
        return $this->belongsTo(CustInfo::class, 'customer_id');
    }
}
