<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrobialEfficacyAnalyses extends Model
{
    protected $fillable = ['pathogen','pi_zone','ci_zone','fi_zone','action','added_by_id'];
    
}
