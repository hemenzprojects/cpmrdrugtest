<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MicrobialLoadAnalyses extends Model
{
    protected $fillable = ['test_conducted','result','acceptance_criterion','compliance','date','added_by_id'];
   
    
    public function getExpiredAtAttribute( $value ) {
       return $this->attributes['date'] = (new Carbon($value))->format('Y');
      }
}
