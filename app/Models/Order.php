<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'total',
        'status',
    ];

    // Beziehung zu `OrderItem`
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Beziehung zu `User`
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Beziehung zu `Address`
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
