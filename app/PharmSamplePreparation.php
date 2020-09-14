<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmSamplePreparation extends Model
{
    protected $fillable = ['product_id','pharm_testconducted_id','measurement','dosage','yield','remarks','distributed_by','received_by','delivered_by','created_at','updated_at'];

    public function getAnimalMeasurementAttribute(){
        return $this->measuerment;
    }
}
