<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PrintJob;

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

    protected static function booted(): void
    {
        static::created(function ($order) {
            PrintJob::create([
                'order_id' => $order->id,
                'payload' => $order->load('details.product', 'details.extra')->toArray(),
            ]);
        });
    }

    // Una orden tiene muchos detalles
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}