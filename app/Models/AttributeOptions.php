<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOptions extends Model
{
    use HasFactory;

    protected $fillable =[
        'attribute_id',
        'value',
    ];

     function attribute()
    {
        return $this->belongsTo('App\Models\Attribute');
    }

    function cart()
    {
        return $this->hasMany('App\Models\Cart');
    }

    function variant()
    {
        return $this->belongsToMany('App\Models\Sku' ,'attribute_option_sku');
    }

    public function subOptions()
    {
        return $this->belongsToMany(AttributeOptions::class, 'attribute_option_sub', 'attribute_option_id', 'attribute_option_sub_id')
        ->withPivot('price')
        ->withPivot('stock');
    }

    public function childSubOptions()
    {
        return $this->belongsToMany(AttributeOptions::class, 'attribute_option_sub', 'attribute_option_sub_id', 'attribute_option_id')
        ->withPivot('price')
        ->withPivot('stock');
    }
}
