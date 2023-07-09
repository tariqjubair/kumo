<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Inventory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    function relto_color(){
        return $this->belongsTo(Color::class, 'color');
    }

    function relto_size(){
        return $this->belongsTo(Size::class, 'size');
    }

    function relto_length(){
        return $this->belongsTo(Length::class, 'length');
    }

    function relto_user(){
        return $this->belongsTo(User::class, 'updated_by');
    }
}
