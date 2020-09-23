<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhytoChemicalConstituentsReport extends Model
{
    protected $fillable = ['product_id','phyto_testconducted_id','name','addedby_id','created_at','updated_at'];

}
