<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmReference extends Model
{
    protected $fillable = ['name','reference','action','added_by_id','created_at','updated_at'];

}
