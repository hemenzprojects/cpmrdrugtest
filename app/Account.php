<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['product_id','price','receipt_num','customer','created_at','updated_at'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
}
