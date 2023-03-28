<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingTab extends Model
{
    use HasFactory;

    function relto_city(){
        return $this->belongsTo(City::class, 'city');
    }

    function relto_country(){
        return $this->belongsTo(Country::class, 'country');
    }
}
