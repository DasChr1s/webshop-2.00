<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_email',
        'billing_address',
        'total',
        'status',
    ];

    // Beziehung zu `GuestOrderItem`
    public function items()
    {
        return $this->hasMany(GuestOrderItem::class, 'guest_order_id');
    }
}
