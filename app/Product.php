<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','customer_id','product_type_id','price','quantity','mfg_date','exp_date','indication','company','micro_comment','micro_conclution','micro_dateanalysed','micro_overall_status','micro_hod_evaluation','pharm_testconducted','pharm_overall_status','pharm_hod_evaluation','pharm_process_status','added_by_id'];
   
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
    public function departments(){
        return $this->belongsToMany('App\Department','product_depts','product_id','dept_id')
        ->withpivot('quantity','dept_id','status','distributed_by','received_by','delivered_by','created_at','updated_at');
    }

    //*******************************Microbiology*********************** */

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

    public function getProductStatusAttribute()
    {
        if ($this->pivot->status === 1) {
           return '<td><label class="badge badge-danger">Pending</label></td>';
        }elseif ($this->pivot->status === 2) {
            return '<td><label class="badge badge-success">Received</label></td>';
        }elseif ($this->pivot->status === 3) {
            return '<td><button type="button" class="btn btn-outline-warning btn-rounded">IN PROGRESS</button></td>';
        }elseif ($this->pivot->status === 4) {
            return '<td><button type="button" class="btn btn-outline-success btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>COMPLETED</button></td>';
        }

        
        elseif ($this->pivot->status === 7) {
            return '<td><button type="button" class="btn btn-outline-info btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>Under Experiment</button></td>';
        }
        elseif ($this->pivot->status === 8) {
            return '<td><button type="button" class="btn btn-outline-success btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>COMPLETED</button></td>';
        }
    }

    //*******************************Pharmacology*********************** */
   
    public function samplePreparation()
    {
        return $this->hasMany("App\PharmSamplePreparation","product_id");
    }
     
    public function pharmsamplePreparation()
    {
        return $this->belongsToMany('App\PharmTestConducted', "pharm_sample_preparations", 'product_id', 'pharm_testconducted_id')
        ->withPivot([ 'product_id','measurement']);
    }
    public function animalExperiment()
    {
        return $this->hasMany("App\PharmAnimalExperiment","product_id");
    }

    public function getPharmProductStatusAttribute()
    {
       if ($this->pharm_process_status === 3) {
            return '<span style="color:#ff0000; font-size:11.5px">Pending</span>';
        }elseif ($this->pharm_process_status === 4) {
            return '<span style="color:#0d8205; font-size:11.5px">received</span>';
        }
        elseif ($this->pharm_process_status === 5) {
            return '<td><button type="button" class="btn btn-outline-success btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>Inprogres</button></td>';
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
  
    
    // Micro Report Evaluations

    public function getEvaluationAttribute()
    {
       if($this->micro_hod_evaluation === 1){
        return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>';
      }elseif ($this->micro_hod_evaluation === 2) {
        return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>';
     }

    }

    public function getHodEvaluationAttribute()
    {
       if($this->micro_hod_evaluation === 1){
        return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Report Withheld</button>';
      }elseif ($this->micro_hod_evaluation === 2) {
        return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>';
     }

    }

    public function getReportEvaluationAttribute()
    {
       if($this->micro_hod_evaluation === 1){
        return '<label class="badge badge-danger"> Withheld</label>';
      }elseif ($this->micro_hod_evaluation === 2) {
        return '<label class="badge badge-success"> Approved</label>';
     }

    }
    // Pharm Report Evaluations

    public function getPharmEvaluationAttribute()
    {
       if($this->pharm_hod_evaluation === 1){
        return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>';
      }elseif ($this->pharm_hod_evaluation === 2) {
        return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>';
     }

    }

    public function getHodPharmEvaluationAttribute()
    {
       if($this->pharm_hod_evaluation === 1){
        return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Report Withheld</button>';
      }elseif ($this->pharm_hod_evaluation === 2) {
        return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>';
     }

    }

    public function getPharmReportEvaluationAttribute()
    {
       if($this->pharm_hod_evaluation === 1){
        return '<span style="color:#ff0000; font-size:11.5px">Withheld</span>';
      }elseif ($this->pharm_hod_evaluation === 2) {
        return '<span style="color:#0d8205; font-size:11.5px">Approved</span>';
    }

    }
}  
