<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'code',
        'price',
        'stock'
    ];


    function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    function variant()
    {
        return $this->belongsToMany('App\Models\AttributeOptions' ,'attribute_option_sku');
    }
    function isThereVariant()
    {
        return $this->variant()->exists();
    }
}
