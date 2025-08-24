<?php
// archivo: app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subcategory_id',
        'name',
        'size_oz', // <-- ¡Esta es la corrección!
        'price',
        'image',
        'extras'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'extras' => 'array',
        'size_oz' => 'float',
    ];

    /**
     * Obtiene la subcategoría a la que pertenece el producto.
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    /**
     * Obtiene el tamaño en mililitros.
     */
    public function getSizeMlAttribute(): float
    {
        // 1 onza fluida = 29.5735 mililitros
        return round($this->size_oz * 29.5735, 2);
    }
}
