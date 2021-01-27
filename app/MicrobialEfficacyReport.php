<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrobialEfficacyReport extends Model
{
    protected $fillable = ['product_id','efficacy_analyses_id','pathogen','pi_zone','ci_zone','fi_zone','added_by_id'];
     
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
}
