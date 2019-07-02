<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['client_email', 'status'];

    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'order_products')->withPivot('quantity', 'price');;
    }

    public function getCostAttribute()
    {
        $ret = 0;
        foreach ($this->products as $product) {
            $ret += $product['pivot']['quantity']*$product['pivot']['price'];
        }
        return $ret;
    }
}
