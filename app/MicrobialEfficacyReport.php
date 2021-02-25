<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrobialEfficacyReport extends Model
{
    protected $fillable = ['product_id','efficacy_analyses_id','pathogen','pi_zone','ci_zone','fi_zone','reference','added_by_id'];
     
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function getEfficacyStatusAttribute()
    {
        if ($this->efficacy_analyses_id === 2) {
           return '<td><label class="badge badge-danger">Pending</label></td>';
        }elseif ($this->efficacy_analyses_id === null) {
            'j';
        }
    }
    public function getRefAttribute(){

        if ($this->reference) {
            return '<p style="font-style: italic;">The efficacy analysis was conducted using agar well diffusion method. (Holder and Boyce, 1994. Burns 20:264-9). The diametre of the cork borer used = 6 mm.</p>';
        }
    }
}
