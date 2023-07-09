<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CustInfo extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $guard = 'CustLogin';

    function relto_city(){
        return $this->belongsTo(City::class, 'city');
    }
    function relto_country(){
        return $this->belongsTo(Country::class, 'country');
    }
}
