<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmSamplePreparation extends Model
{
    protected $fillable = ['product_id','pharm_testconducted_id','measurement','weight','dosage','yield','remarks','samplestatus','created_by','distributed_by','received_by','delivered_by','delivered_at','distributed_at','created_at','updated_at'];

    public function getAnimalMeasurementAttribute(){
        return $this->measuerment;
    }

    
}
