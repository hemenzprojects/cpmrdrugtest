<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhytoPhysicochemDataReport extends Model
{
    protected $fillable = ['product_id','phyto_testconducted_id','phyto_physicochemdata_id','name','result','unit','location','addedby_id','created_at','updated_at'];

}
