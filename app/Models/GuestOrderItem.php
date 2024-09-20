<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Beziehung zu `Product`
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Beziehung zu `GuestOrder`
    public function guestOrder()
    {
        return $this->belongsTo(GuestOrder::class, 'guest_order_id');
    }
}
