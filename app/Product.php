<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','customer_id','product_type_id','price','quantity','mfg_date','exp_date','indication','company','overall_status','added_by_id'];
    
    public function productType()
    {
        return $this->belongsTo('App\ProductType', 'product_type_id');
    }
    public function admin(){
        return $this->belongsTo('App\Admin','added_by_id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function productDept()
    {
        return $this->hasMany("App\ProductDept","product_id");
    }

    public function microbialloadReports()
    {
        return $this->hasMany("App\MicrobialLoadReport", "product_id");
    }
    public function microbialefficacyReports()
    {
        return $this->hasMany("App\MicrobialEfficacyReport", "product_id");
    }
    
    public function loadAnalyses()
    {
        return $this->belongsToMany('App\MicrobialLoadAnalyses', "microbial_load_reports", 'product_id', 'load_analyses_id')
        ->withPivot(['test_conducted','result','rs_total','acceptance_criterion','ac_total','created_at','added_by_id','updated_at']);
    }
    public function efficacyAnalyses()
    {
        return $this->belongsToMany('App\MicrobialEfficacyAnalyses', "microbial_efficacy_reports", 'product_id', 'efficacy_analyses_id')
        ->withPivot(['efficacy_analyses_id','pathogen','pi_zone','ci_zone','fi_zone']);
    }

    public function departments(){
        return $this->belongsToMany('App\Department','product_depts','product_id','dept_id')
        ->withpivot('quantity','dept_id','status','distributed_by','received_by','delivered_by','created_at','updated_at');
    }
    

        
    public function getProductStatusAttribute()
    {
        if ($this->pivot->status === 1) {
           return '<td><label class="badge badge-danger">Pending</label></td>';
        }elseif ($this->pivot->status === 2) {
            return '<td><label class="badge badge-info">Received</label></td>';
        }elseif ($this->pivot->status === 3) {
            return '<td><button type="button" class="btn btn-outline-warning btn-rounded">IN PROGRESS</button></td>';
        }elseif ($this->pivot->status === 4) {
            return '<td><button type="button" class="btn btn-outline-success btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>COMPLETED</button></td>';
        }
    }
 
    public function getCustomerNameAttribute()
    {
        if ($this->customer){
            return $this->customer->title .' '. $this->customer->first_name .' - '. $this->customer->last_name;
        }
    }
 
    public function getCreatedByAttribute(){

        if ($this->admin){
           return $this->admin->first_name .'-'. $this->admin->last_name ;
        }
    }
    public function getEditTagAttribute()
    {
        return '<a data-toggle="tooltip" data-placement="auto" title="Edit Product" href="'. route('admin.sid.product.edit', ['id' => $this]) .'"> <i class="ik ik-edit-2"></i></a>';
    }

    
    public function getShowTagAttribute()
    {
        return '<a data-toggle="tooltip" data-placement="auto" title="View Product" href="'. route('admin.sid.product.show', ['id' => $this]) .'"><i class="ik ik-eye"></i></a>';
    }
}
