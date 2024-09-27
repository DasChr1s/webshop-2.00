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
        'name',
        'billing_city',
        'billing_postal_code',
    ];

    // Beziehung zu `GuestOrderItem`
    public function items()
    {
        return $this->hasMany(GuestOrderItem::class, 'guest_order_id');
    }
}
