<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function order_line_items(){
        return $this->hasMany(OrderLineItem::class, 'order_id', 'shopify_id');
    }
}
