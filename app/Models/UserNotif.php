<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotif extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function relto_user(){
        return $this->belongsTo(User::class, 'creator');
    }
}
