<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmFinalReport extends Model
{
    protected $fillable = ['product_id','pharm_testconducted_id','pharm_animal_model','num_of_animals','time_administration', 'time_administration','no_death','signs_toxicity','animal_sex',
    'method_of_admin','no_group','formulation','preparation','estimated_dose','no_days','dosage','added_by_id','created_at','updated_at'];


}
