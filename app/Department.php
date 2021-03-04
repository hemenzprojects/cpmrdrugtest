<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    
    
    public function products(){
        return $this->belongsToMany('App\Product','product_depts','dept_id','product_id')
        ->withpivot('id','quantity','dept_id','status','distributed_by','received_by','delivered_by','created_at','updated_at');
    }


    public function getProductStatusAttribute()
    {
        if ($this->pivot->status === 1) {
           return '<label class="badge badge-danger">Pending</label>';
        }elseif ($this->pivot->status === 2) {
            return '<label class="badge badge-success">Received</label>';
        }
        elseif ($this->pivot->status === 3) {
            return '<button type="button" class="btn btn-outline-warning btn-rounded">IN PROGRESS</button>';
        }
        elseif ($this->pivot->status === 4) {
            return '<button type="button" class="btn btn-outline-success btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>COMPLETED</button>';
        }

        elseif ($this->pivot->status === 7) {
            return '<button type="button" class="btn btn-outline-info btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>UNDER EXPERIMENT</button>';
        }
        elseif ($this->pivot->status === 8) {
            return '<button type="button" class="btn btn-outline-success btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>COMPLETED</button>';
        }

      
    }
}
