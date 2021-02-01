<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhytoChemicalConstituents extends Model
{
    protected $fillable = ['name','description','action','addedby_id','created_at','updated_at'];

}
