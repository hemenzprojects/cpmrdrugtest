<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    
    
    public function products(){
        return $this->belongsToMany('App\Product','product_depts','dept_id','product_id')
        ->withpivot('id','quantity','dept_id','status','distributed_by','received_by','delivered_by','created_at','updated_at');
    }


}
