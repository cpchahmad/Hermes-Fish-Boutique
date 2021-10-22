<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLineItem extends Model
{
    use HasFactory;
    public function product_varient(){
        return $this->hasOne(ProductVarient::class, 'shopify_id', 'variant_id');
    }
}
