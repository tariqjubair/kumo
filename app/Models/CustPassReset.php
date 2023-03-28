<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustPassReset extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function relto_cust(){
        return $this->belongsTo(CustInfo::class, 'customer_id');
    }
}
