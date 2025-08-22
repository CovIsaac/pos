<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['subcategory_id', 'name', 'sizes', 'image', 'extras'];

    protected $casts = [
        'sizes' => 'array',
        'extras' => 'array',
    ];

    // Un producto pertenece a una subcategoría
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}