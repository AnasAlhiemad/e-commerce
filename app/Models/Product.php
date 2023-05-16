<?php

namespace App\Models;
use App\Models\User;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Cart_Order;
use App\Models\sub_Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $fillable = [
        'product_name',
        'price_product',
        'user_id',
        'subcategory_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subcategory() {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function cart_order() {
        return $this->hasMany(cart__orders::class, 'product_id');
    }
    public function favorite(){
        return $this->hasMany(Favorite::class,'product_id');
    }
    public function image(){
        return $this->hasMany(Image::class,'product_id');
    }



    // public function comments(){
    //     return $this->hasMany(Comment::class);
    // }

    // public function likes(){
    //     return $this->hasMany(Like::class);
    // }



}
