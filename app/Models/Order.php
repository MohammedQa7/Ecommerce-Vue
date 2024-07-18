<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const ON_THE_WAY = 'Shipped';
    const PENDING = 'Pending';
    const DELIVERD = 'Deliverd';
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'order_number',
        'option_id',
        'sub_option_id',
        'total_price',
        'status',
    ];


    public function variants()
    {
        return $this->belongsTo('App\Models\AttributeOptions', 'option_id');
    }
    
    public function subOptions()
    {
        return $this->belongsTo('App\Models\AttributeOptions', 'sub_option_id');
    }


    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_product');
    }
}
