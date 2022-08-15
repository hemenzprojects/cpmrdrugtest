<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['product_id','price','receipt_num','customer','added_by_id','updated_by_id','created_at','updated_at'];

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }
    
}
