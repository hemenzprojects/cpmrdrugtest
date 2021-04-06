<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhytoOrganolepticsReport extends Model
{
    protected $fillable = ['product_id','phyto_testconducted_id','phyto_organoleptics_id','name','feature','roworder','addedby_id','created_at','updated_at'];

}
