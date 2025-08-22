<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'extra_id',
        'unit_price',
        'quantity',
        'subtotal'
    ];

    // Un detalle pertenece a una orden
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Un detalle corresponde a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Un detalle puede tener un extra
    public function extra()
    {
        return $this->belongsTo(Extra::class);
    }
}