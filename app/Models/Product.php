<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'user_id',
        'category_id',
    ];

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    function sku()
    {
        return $this->hasMany('App\Models\Sku');
    }

    public function favorite()
    {
        return $this->belongsToMany('App\Models\User', 'user_favorite');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order', 'order_product');
    }

    public function rating()
    {
        return $this->belongsToMany('App\Models\User', 'product_rating')->withPivot(['rating', 'message' ,'created_at']);
    }

    public function scopeisProductRatedByUser()
    {
        return $this->rating()->where('user_id' , Auth::user()->id)->exists();
    }

    public function is_favorited($user)
    {
        if ($user) {
            return $this->favorite()->where('user_id', $user)->exists();
        } else {
            return false;
        }
    }


}