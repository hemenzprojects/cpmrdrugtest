<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicrobialLoadReport extends Model
{
    protected $fillable = ['product_id','load_analyses_id','test_conducted','result','rs_total','acceptance_criterion','ac_total','date_template','compliance','added_by_id'];

   


    
    public function getMicroComplianceAttribute(){

        if ($this->compliance === 1) {
            return  '<span style="color:#ff0000; font-size:11.5px">Failed</span>';
         }

        if ($this->compliance === 2) {
            return '<span style="color:#0d8205; font-size:11.5px">Passed</span>';
        }

    }
      
    public function getMicroComplianceReportAttribute(){

        if ($this->compliance === 1) {
            return  '<span style="color:#000; font-size:11.5px">Failed</span>';
         }

        if ($this->compliance === 2) {
            return '<span style="color:#000; font-size:11.5px">Passed</span>';
        }

    }
}
