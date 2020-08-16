<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrobialReport extends Model
{
    protected $fillable = ['product_id','load_analyses_id'.'test_conducted','result','rs_total','acceptance_criterion','ac_total','efficacy_analyses_id','pathogen','pi_zone','ci_zone','fi_zone','added_by_id'];

}    