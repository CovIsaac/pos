<?php
// archivo: app/Models/Subcategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'url_img',
        'sizes',
        'extras'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sizes' => 'array',
        'extras' => 'array',
    ];

    /**
     * Obtiene la categoría a la que pertenece la subcategoría.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtiene los productos asociados con la subcategoría.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
