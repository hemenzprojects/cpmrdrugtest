<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhytoOrganoleptics extends Model
{
    protected $fillable = ['name','feature','action','addedby_id','created_at','updated_at'];

}
