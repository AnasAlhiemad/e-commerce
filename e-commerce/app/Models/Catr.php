<?php

namespace App\Models;
use App\Models\User;
use App\Models\Prduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = "carts";
    protected $fillable = [
        'user_id','cart_name',
    ];
    //  protected $primaryKey = "id";
   // public $timestamps = true;

    public function products() {
        return $this->hasMany(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
