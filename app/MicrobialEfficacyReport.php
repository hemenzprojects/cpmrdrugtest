<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrobialEfficacyReport extends Model
{
    protected $fillable = ['product_id','efficacy_analyses_id','pathogen','pi_zone','ci_zone','fi_zone','added_by_id'];

}
