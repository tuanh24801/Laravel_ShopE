<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductImage;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'status'
    ];

    public function products(){
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function productImages(){
        return $this->hasManyThrough(
            ProductImage::class,
            Product::class,
            'category_id',
            'product_id',
            'id',
            'id',
        );
    }
}
