<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'sku_code',
        'sub_option_id',
        'quantity',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    function options()
    {
        return $this->belongsTo('App\Models\AttributeOptions' , 'sub_option_id');
    }
}
