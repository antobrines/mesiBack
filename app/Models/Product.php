<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_ht',
        'description',
        'stock',
        'user_id',
        'product_image'
    ];

    public function user_product()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    
}
