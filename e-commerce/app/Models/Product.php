<?php

namespace App\Models;
use App\Models\User;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Sub_Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $fillable = [
        'product_name',
        'price_product',
        'image',
        'user_id',
        'subcategory_id',
      // 'cart_id',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subcategory() {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    // public function cart() {
    //     return $this->belongsTo(Cart::class, 'cart_id');
    // }
    public function favorite(){
        return $this->hasMany(Favorite::class);
    }



    // public function comments(){
    //     return $this->hasMany(Comment::class);
    // }

    // public function likes(){
    //     return $this->hasMany(Like::class);
    // }



}
