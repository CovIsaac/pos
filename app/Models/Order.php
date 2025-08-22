<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'date_order',
        'total',
        'status',
        'payment_method'
    ];

    // Una orden tiene muchos detalles
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}