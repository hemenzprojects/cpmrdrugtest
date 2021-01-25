<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PharmAnimalExperiment extends Model
{
    protected $fillable = ['product_id','pharm_testconducted_id','animal_model','weight','volume', 'time_administration','death','toxicity','sex','method','group','time_death','dosage','total_days','added_by_id','created_at','updated_at'];

    
    //******* pharm animal models */

    public function animalToxicity()
    {
        return $this->belongsTo('App\PharmToxicity', 'toxicity');
    }
    
    // public function getPharmAnimalModelAttribute(){
    //     if ($this->animal_model ==1) {
    //         return 'SRD Rat';
    //     } if ($this->animal_model ==2) {
    //         return 'SD Rats';
    //     }  
    //     if ($this->animal_model ==3) {
    //         return 'AD Mouse';
    //     }   
    //  }
     public function getNoDeathAttribute(){
        if ($this->death ==1) {
            return 'yes';
        } if ($this->death ==2) {
            return 'No';
        }      
     }
     public function getAnimalSexAttribute(){
        if ($this->sex ==1) {
            return 'Male';
        } if ($this->sex ==2) {
            return 'female';
        }  
     }
     public function getAnimalMethodAttribute(){
        if ($this->method ==1) {
            return 'Intravenous';
        } if ($this->method ==2) {
            return 'Intramuscular';
        } 
        if ($this->method ==3) {
            return 'sometext3';
        }
        if ($this->method ==4) {
            return 'sometext4';
        } 
     }

}
