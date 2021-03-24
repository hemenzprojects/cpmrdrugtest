<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductDept;
use App\ProductType;

class Product extends Model
{
    protected $fillable = ['code','name','customer_id','product_type_id','price','receipt_num','quantity','overall_status','micro_grade','pharm_grade','phyto_grade','mfg_date','exp_date','indication','single_multiple_lab','dosage',
    'micro_comment','micro_conclution','micro_la_conclution','micro_ea_conclution','micro_dateanalysed','micro_overall_status','micro_process_status','micro_hod_evaluation','micro_hod_remarks','micro_approved_by','micro_analysed_by','micro_finalapproved_by',
    'pharm_testconducted','pharm_overall_status','pharm_hod_evaluation','pharm_datecompleted','pharm_dateanalysed','pharm_process_status','pharm_comment','pharm_result','pharm_approved_by','pharm_finalapproved_by','pharm_analysed_by','pharm_experiment_by','pharm_hod_remarks',
    'phyto_overall_status','phyto_hod_evaluation','phyto_process_status','phyto_hod_remarks','phtyo_comment','phyto_dateanalysed','phyto_approved_by','phyto_analysed_by','phyto_finalapproved_by','failed_tag','added_by_id','updated_by_id'];

    protected $appends = [
        "experimental_deaths", "experimental_lives"
    ];
    // public static function completedReports()
    // {
    //     return self::whereHas('productDept')->get()->where("overall_status",2);
    // }

    // public static function pendingReports($from_date=null, $to_date=null)
    // {
    //     if($from_date || $to_date){
    //         return self::whereHas("departments", function($q) use($from_date, $to_date){
    //             return $q->with("departments")->where("status", '>=', 2)
    //                 ->where('product_depts.created_at', '>=', $from_date)
    //                 ->where('product_depts.created_at','<=',$to_date);
    //           })->get()->where('overall_status', '<', 2);
    //     }

    //     return self::whereHas('productDept')->get()->where('overall_status', '<', 2);
    // }
    
    // public function getOverallStatusAttribute()
    // {
    //     if($this->micro_hod_evaluation >= 2 && $this->pharm_hod_evaluation >= 2 && $this->phyto_hod_evaluation >= 2){
    //         return 2;
    //     }
        
    //     $sum = $this->micro_hod_evaluation + $this->pharm_hod_evaluation + $this->phyto_hod_evaluation;

    //     if($sum < 3){
    //         return 1;
    //     }
        
    //     return 1;
    // }

 

    public function getExperimentalDeathsAttribute()
    {
        return count($this->animalExperiment->where("death",2));
    }

    public function getExperimentalLivesAttribute()
    {
        return count($this->animalExperiment->where("death",1));
    }

    public static function generateCode(ProductType $product_type){
        $products_count = count(
            self::where("product_type_id", $product_type->id)
            ->where("created_at", ">=", date("y") . "-01-01 00:00:00")->get()
        );

        $code = "";
        
        do {
            $products_count++;
            $code = $product_type->code."/".str_pad($products_count,  3, "0", STR_PAD_LEFT) . "/" . date("y");
            $already_existing = count(self::where("code", $code)->get());
        } while($already_existing);

        return $code;
    }  

    public function isReviewedByDept($dept_id)
    {

        $product_ids = Product::where("failed_tag",'!=', Null)->where("failed_tag", $this->failed_tag)->pluck("id")->toArray();
        
        $related_tests = ProductDept::whereIn("product_id", $product_ids)->where("dept_id", $dept_id)->get();
       
        return count($related_tests) > 1;
    }

    public function getFailedFinalGradeAttribute()
    {
        return !($this->micro_grade == 2 && $this->pharm_grade == 2 &&  $this->phyto_grade == 2);
    }
    public function getPendingReviewProductAttribute()
    {
        return ($this->micro_grade == Null || $this->pharm_grade == Null || $this->phyto_grade == Null);
    }

    public function getLastReviewProductAttribute()
    {
        return self::where('failed_tag', $this->failed_tag)->orderBy("created_at", "DESC")->first();
    }

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

    public function account()
    {
        return $this->hasMany("App\Account","product_id");
    }

    public function productDept()
    {
        return $this->hasMany("App\ProductDept","product_id");
    }

    public function departmentById($dept_id)
    {
        return $this->departments->where("id", $dept_id)->first();
    }

    public function departments(){
        return $this->belongsToMany('App\Department','product_depts','product_id','dept_id')
        ->withpivot('quantity','dept_id','status','distributed_by','received_by','delivered_by','received_at','created_at','updated_at');
    }


    public function getProductStatusAttribute()
    {
        if ($this->pivot->status == 1) {
           return '<label class="badge badge-danger">#Pending</label>';
        }elseif ($this->pivot->status == 2) {
            return '<label class="badge badge-success">#Received</label>';
        }
        elseif ($this->pivot->status == 3) {
            return '<button type="button" class="btn btn-outline-warning btn-rounded">IN PROGRESS</button>';
        }
        elseif ($this->pivot->status == 4) {
            return '<button type="button" class="btn btn-outline-success btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>COMPLETED</button>';
        }


        elseif (($this->pharm_hod_evaluation === Null) && ($this->pivot->status ===7)) {
            return '<button type="button" class="btn btn-outline-info btn-rounded"></i>UNDER EXPERIMENT</button>';
        }
        elseif (($this->pharm_hod_evaluation < 1) && ($this->pivot->status ===7)) {
            return '<button type="button" class="btn btn-outline-info btn-rounded"></i>REPORT PREPARATION</button>';
        }
        elseif (($this->pharm_hod_evaluation === 1) && ($this->pivot->status ===7)) {
            return '<button type="button" class="btn btn-outline-danger btn-rounded"></i>Hod Evaluation</button>';
        }
        elseif (($this->pharm_hod_evaluation > 1) && ($this->pivot->status ===7)) {
            return '<button type="button" class="btn btn-outline-success btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>APPROVED </button>';
        }
        
        elseif ($this->pivot->status === 8) {
            return '<button type="button" class="btn btn-outline-success btn-rounded"><i class="ik ik-check-square" style="color:#000"></i>COMPLETED</button>';
        }

      
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
        ->withPivot(['efficacy_analyses_id','pathogen','pi_zone','ci_zone','fi_zone','created_at','added_by_id','updated_at']);
    }

    public function getMicroGradeReportAttribute(){

        if ($this->micro_grade === Null) {
           return 'None';
        }

        if ($this->micro_grade === 1) {
            return  '<span style="color:#ff0000; font-size:11.5px">Failed</span>';
         }

        if ($this->micro_grade === 2) {
            return '<span style="color:#0d8205; font-size:11.5px">Passed</span>';
        }

    }

    
    public function getMicroloadConcAttribute(){

        if ($this->micro_la_conclution === Null) {
           return 'None';
        }

        if ($this->micro_la_conclution === 1) {
            return  '<span  font-size:18.5px">The sample complies with the requirements as per BP specifications</span>';
         }

        if ($this->micro_la_conclution === 2) {
            return '<span  font-size:18.5px">The sample does not comply with the requirements as per BP specifications</span>';
        }

    }

    public function getMicroEfficacyConcAttribute(){

        if ($this->micro_ea_conclution === Null) {
           return 'None';
        }

        if ($this->micro_ea_conclution === 1) {
            return  '<span  font-size:18.5px">The product did not show antimicrobial activity</span>';
         }

        if ($this->micro_ea_conclution === 2) {
            return '<span  font-size:18.5px">The product showed antimicrobial activity</span>';
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

    public function animalExperimentation()
    {
        return $this->belongsToMany('App\PharmTestConducted', "pharm_animal_experiments", 'product_id', 'pharm_testconducted_id')
        ->withPivot([ 'death']);
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
            return '<span style="color:#007bff; font-size:11.5px">Inprogress</span>';

        }
        elseif ($this->pharm_process_status > 5) {
            return '<span style="color:#0d8205; font-size:11.5px">Completed</span>';

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
  
    public function getPharmGradeReportAttribute(){

        if ($this->pharm_grade === Null) {
           return 'None';
        }

        if ($this->pharm_grade === 1) {
            return  '<span style="color:#ff0000; font-size:11.5px">Failed</span>';
         }

        if ($this->pharm_grade === 2) {
            return '<span style="color:#0d8205; font-size:11.5px">Passed</span>';
        }

    }
    
    // Micro Report Evaluations

    public function getEvaluationAttribute()
    {
       if($this->micro_hod_evaluation === 0){
        return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>';
      } if($this->micro_hod_evaluation === 1){
        return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Withheld </button>';
      }
      elseif ($this->micro_hod_evaluation === 2) {
        return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>';
     }

    }

    public function getHodEvaluationAttribute()
    {
       if($this->micro_hod_evaluation === 0){
        return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Report Pending </button>';
      }
      if($this->micro_hod_evaluation === 1){
       return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Report Withheld</button>';
     }
      elseif ($this->micro_hod_evaluation === 2) {
        return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>';
     }

    }

    public function getReportEvaluationAttribute()
    {
        
       if($this->micro_hod_evaluation === 0){
        return '<span style="color:#ff0000; font-size:11.5px">pending</span>';
       }
       if($this->micro_hod_evaluation === 1){
        return '<span style="color:#ff0000; font-size:11.5px">Withheld</span>';
      }elseif ($this->micro_hod_evaluation === 2) {
        return '<span style="color:#0d8205; font-size:11.5px">Approved</span>';
     }

    }

    public function getFinalHodMicroEvaluationAttribute()
    {
           if ($this->micro_hod_evaluation === 2 && $this->micro_process_status === 1) {
            return '<span style="color:#ff0000; font-size:11.5px">  Pending</span>';
         }
         if ($this->micro_hod_evaluation === 2 && $this->micro_process_status === 2) {
            return '<span style="color:#ff0000; font-size:11.5px">  Withheld</span>';
         }
         if ($this->micro_hod_evaluation === 2 && $this->micro_process_status === 3) {
            return '<span style="color:#0d8205; font-size:11.5px">  Approved</span>';
         }

    }
    // Pharm Report Evaluations

    
    public function getPharmEvaluationAttribute()
    {
       if($this->pharm_hod_evaluation === 0){
        return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>';
      }  if($this->pharm_hod_evaluation === 1){
        return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Report Withheld </button>';
      }
      elseif ($this->pharm_hod_evaluation === 2) {
        return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>';
     }

    }

    public function getHodPharmEvaluationAttribute()
    {
        if($this->pharm_hod_evaluation === 0){
       return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>';
          } 
        if($this->pharm_hod_evaluation === 1){
            return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Report Withheld </button>';
          }
        if ($this->pharm_hod_evaluation === 2 &&  $this->pharm_process_status < 6) {
            return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>';
         } 
           if ($this->pharm_hod_evaluation === 2 && $this->pharm_process_status === 6) {
            return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Final Approval Process </button>';
         }

    }

    public function getFinalHodPharmEvaluationAttribute()
    {
           if ($this->pharm_hod_evaluation === 2 && $this->pharm_process_status === 6) {
            return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-check"></i>Final Report Pending</button>';
         }
         if ($this->pharm_hod_evaluation === 2 && $this->pharm_process_status === 7) {
            return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-check"></i>Final Report Withheld</button>';
         }
         if ($this->pharm_hod_evaluation === 2 && $this->pharm_process_status === 8) {
            return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Final Report Approved</button>';
         }

    }


    public function getPharmReportEvaluationAttribute()
    {
       if($this->pharm_hod_evaluation === 0){
        return '<span style="color:#ff0000; font-size:11.5px">Pending</span>';
      } if($this->pharm_hod_evaluation === 1){
        return '<span style="color:#ff0000; font-size:11.5px">Withheld</span>';
      }
      elseif ($this->pharm_hod_evaluation === 2) {
        return '<span style="color:#0d8205; font-size:11.5px">Approved</span>';
      }

    }

      //*******************************Phytochemistry*********************** */

      public function organolipticReport()
      {
          return $this->hasMany("App\PhytoOrganolepticsReport","product_id");
      }
       
      public function phytOrganoliptic()
      {
          return $this->belongsToMany('App\PhytoTestConducted', "phyto_organoleptics_reports", 'product_id', 'phyto_testconducted_id')
          ->withPivot([ 'product_id','phyto_organoleptics_id','id','name','feature']);
      }


      public function pchemData()
      {
          return $this->hasMany("App\PhytoPhysicochemData","product_id");
      }
       
      public function phytochemdataReport(){
        return $this->hasMany("App\PhytoPhysicochemDataReport","product_id");
      }

      public function pchemdataReport()
      {
          return $this->belongsToMany('App\PhytoTestConducted', "phyto_physicochem_data_reports", 'product_id', 'phyto_testconducted_id')
          ->withPivot([ 'product_id','phyto_physicochemdata_id','id','name','result']);
      }

      public function pchemConstituent()
      {
          return $this->hasMany("App\PhytoPhysicochemData","product_id");
      }
       
      public function phytochemconstReport(){
        return $this->hasMany("App\PhytoChemicalConstituentsReport","product_id");
      }

      public function pchemconstReport()
      {
          return $this->belongsToMany('App\PhytoTestConducted', "phyto_chemical_constituents_reports", 'product_id', 'phyto_testconducted_id')
          ->withPivot([ 'product_id','name']);
      }


      public function getPhyHodEvaluationAttribute()
      {
         if($this->phyto_hod_evaluation === 1){
          return '<button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Report Withheld</button>';
        }elseif ($this->phyto_hod_evaluation === 2) {
          return '<button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>';
       }
  
      }

      public function getPhytoReportEvaluationAttribute()
      {
        if($this->phyto_hod_evaluation === 0){
            return '<span style="color:#ff0000; font-size:11.5px">pending</span>';
        }
         if($this->phyto_hod_evaluation === 1){
          return '<span style="color:#ff0000; font-size:11.5px">Withheld</span>';
        }elseif ($this->phyto_hod_evaluation === 2) {
          return '<span style="color:#0d8205; font-size:11.5px">Approved</span>';
        }
  
      }

      
    public function getPhytoGradeReportAttribute(){

        if ($this->phyto_grade === Null) {
           return 'None';
        }

        if ($this->phyto_grade === 1) {
            return  '<span style="color:#ff0000; font-size:11.5px">Failed</span>';
         }

        if ($this->phyto_grade === 2) {
            return '<span style="color:#0d8205; font-size:11.5px">Passed</span>';
        }

    }
  
}  
