<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'url_img'];

    // Una subcategoría pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Una subcategoría tiene muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}