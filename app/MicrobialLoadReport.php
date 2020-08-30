<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrobialLoadReport extends Model
{
    protected $fillable = ['product_id','load_analyses_id','test_conducted','result','rs_total','acceptance_criterion','ac_total','added_by_id'];

   
}
