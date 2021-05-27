<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    
    protected $fillable = ['code','name','form','state','method_applied','pharm_standard_id','description','added_by_id','updated_by_id','created_at'];

    public function admin(){
        return $this->belongsTo('App\Admin','added_by_id');
    }

    public function product(){
        return $this->hasMany('App\Product', 'product_type_id');
    }

    public function pending()
    {
        return $this->hasMany('App\Product', 'product_type_id')->where('overall_status','<',2)->whereHas('departments');

    }
    public function singlelabpending()
    {
        return $this->hasMany('App\Product', 'product_type_id')->where('overall_status','<',2)->where('single_multiple_lab',1)->whereHas('departments');

    }
    public function multiplelabpending()
    {
        return $this->hasMany('App\Product', 'product_type_id')->where('overall_status','<',2)->where('single_multiple_lab',2)->whereHas('departments');

    }
    public function all_labpending()
    {
        return $this->hasMany('App\Product', 'product_type_id')->where('overall_status','<',2)->where('single_multiple_lab',NULL)->whereHas('departments');

    }
    

    public function completed()
    {
        return $this->hasMany('App\Product', 'product_type_id')->where('overall_status',2);

    }
    public function singlelabcompleted()
    {
        return $this->hasMany('App\Product', 'product_type_id')->where('overall_status',2)->where('single_multiple_lab',1);

    }
    public function multiplelabcompleted()
    {
        return $this->hasMany('App\Product', 'product_type_id')->where('overall_status',2)->where('single_multiple_lab',2);

    }
    public function all_labcompleted()
    {
        return $this->hasMany('App\Product', 'product_type_id')->where('overall_status',2)->where('single_multiple_lab',null);

    }



    public function getMicrobialFormAttribute(){
           
        if($this->form === 1){
            return 'Cold';
        }
        return "Hot";
    }

    
    public function getMicrobialStateAttribute(){
           
        if($this->state === 1){
            return 'Solid';
        }
        return "Liquid";
    }

      
    public function getPharmMethodAppliedAttribute(){
           
        if($this->method_applied === 1){
            return 'Aural';
        }
        return "Skin/ Dermal";
    }
}
