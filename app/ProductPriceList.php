<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPriceList extends Model
{
    protected $fillable = ['description','alllabs_price','singlelab_price','multilab_price','added_by_id','updated_by_id','created_at'];
}
