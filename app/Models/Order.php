<?php
// PASO 4: Reemplaza tu modelo Order con este.
// archivo: app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'total_price',
        'payment_method',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
