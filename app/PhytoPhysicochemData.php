<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhytoPhysicochemData extends Model
{
    protected $fillable = ['name','result','unit','action','addedby_id','created_at','updated_at'];

}
