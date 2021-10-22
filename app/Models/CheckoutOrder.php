<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutOrder extends Model
{
    use HasFactory;
    protected $table = 'checkout_orders';
    public function checklineitems(){
        return $this->hasMany(CheckOrderLine::class, 'order_id', 'id');
    }

}
