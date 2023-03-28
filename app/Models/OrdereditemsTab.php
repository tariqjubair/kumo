<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdereditemsTab extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function relto_product(){
        return $this->belongsTo(Product_list::class, 'product_id');
    }
    function relto_size(){
        return $this->belongsTo(Size::class, 'size_id');
    }
    function relto_color(){
        return $this->belongsTo(Color::class, 'color_id');
    }
    function relto_cust(){
        return $this->belongsTo(CustInfo::class, 'customer_id');
    }
}
