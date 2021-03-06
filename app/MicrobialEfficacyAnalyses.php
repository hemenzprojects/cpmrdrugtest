<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrobialEfficacyAnalyses extends Model
{
    protected $fillable = ['pathogen','pi_zone','ci_zone','fi_zone','action','reference','added_by_id'];
 
    
    public function getRefAttribute(){

        if ($this->reference == 1) {
            return '<p style="font-style: italic; font-size:12px">The efficacy analysis was conducted using agar well diffusion method. (Holder and Boyce, 1994. Burns 20:264-9). The diametre of the cork borer used = 6 mm.  (- or N/A) = Not Applicable </p>';
        }
    }
}
