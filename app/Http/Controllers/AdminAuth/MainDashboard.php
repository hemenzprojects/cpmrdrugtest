<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\ProductDistributionRequest;
use App\Http\Requests\UpdatecustomerRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use App\PharmSamplePreparation;
use App\PharmAnimalExperiment;
use App\MicrobialLoadReport;
use App\MicrobialEfficacyReport;
use App\MicrobialEfficacyAnalyses;
use App\MicrobialLoadAnalyses;
use App\PhytoPhysicochemData;
use App\PhytoOrganoleptics;
use App\PhytoChemicalConstituents;
use App\Admin;
use App\Customer;
use App\Department;
use App\ProductType;
use App\Product;
use App\Account;
use App\UserType;
use App\PharmStandards;
use App\ProductDept;
use \Auth;
use \DB;
use Session;

class MainDashboard extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    //************************************************************ Home Dashboard *********************************************** */

    public function homedashboard()
    {  

        //************************************ SID */
        $data['year'] = \Carbon\Carbon::now('y');

       $data['all_product'] = Product::whereHas("departments", function ($q) use ($data) {
            return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
        })->get();
        
        $data['all_pendingproduct'] = Product::where('overall_status','<', 2)    
        ->whereHas("departments", function ($q) use ($data) {
            return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
        })->get();

        $data['all_completedproduct'] = Product::where('overall_status', 2)
        ->whereHas("departments", function ($q) use ($data) {
            return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
        })->get();

        $data['all_failedproduct'] = Product::where('micro_grade','!=',2)->orwhere('pharm_grade','!=',2)->orwhere('phyto_grade','!=',2)
        ->whereHas("departments", function ($q) use ($data) {
            return $q->whereRaw('YEAR(received_at)= ?', array($data['year']));
        })->get();

      //****************************************** MICRO */

       $data['micro_products'] = Product::whereHas("departments", function ($q) use ($data) {
        return $q->where("dept_id", 1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();
    
        
       $data['micro_pendingproduct'] = Product::  
      whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 1)->where("status", '>',1)->where("status", '<',4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

      $data['micro_completedproduct'] = Product::whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 1)->where("status", 4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

      
      $data['micro_failedproduct'] = Product::where('micro_grade', 1)    
      ->whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 1)->where("status", 4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

        //****************************************** PHARM */

         $data['pharm_products'] = Product::whereHas("departments", function ($q) use ($data) {
            return $q->where("dept_id", 2)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

          $data['pharm_pendingproduct'] = Product::whereHas("departments", function ($q) use ($data) {
              return $q->where("dept_id", 2)->where("status", '>',1)->where("status", '<',8)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

          $data['pharm_completedproduct'] = Product::where('pharm_hod_evaluation', 2)    
          ->whereHas("departments", function ($q) use ($data) {
              return $q->where("dept_id", 2)->where("status", 8)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

          $data['pharm_failedproduct'] = Product::where('pharm_grade', 1)    
          ->whereHas("departments", function ($q) use ($data) {
              return $q->where("dept_id", 2)->where("status", 8)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();
     

          $month_start = date('Y-m-01 00:00:00');

          $data['pharm_sample_products'] = Product::whereHas("departments", function ($q) use ($data) {
            return $q->where("dept_id", 2)->where("status", '<',3)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

           $data['prepared_samples'] = Product::whereHas("departments", function ($q){
            return $q->where("dept_id", 2)->where("status", '>',1);
           })->whereHas("samplePreparation", function ($q) use($month_start){
            return $q->where('pharm_sample_preparations.created_at','>=',$month_start);
           })->get();

            $data['prepared_samples_animalhouse'] = Product::where('pharm_process_status','>',3)->whereHas("departments", function ($q){
            return $q->where("dept_id", 2)->where("status", '>',1);
           })->whereHas("samplePreparation", function ($q) use($month_start) {
            return $q->where("samplestatus",1)->where('pharm_sample_preparations.created_at','>=',$month_start);
           })->get();

          //*************************************************Animal House ************************** */

          $data['pharm_animalexp_products'] = Product::where('pharm_process_status',4)->whereHas("departments", function ($q) use ($data) {
            return $q->where("dept_id", 2)->where("status",3)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

           $data['acute_toxicty_total'] = Product::where('pharm_process_status',5)->where('pharm_testconducted',1)   
          ->whereHas("departments", function ($q) use ($data) {
              return $q->where("dept_id", 2)->where("status",7)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

          $data['pharm_completedexperiments'] = Product::where('pharm_process_status',5)    
          ->whereHas("departments", function ($q) use ($data) {
              return $q->where("dept_id", 2)->where("status",7)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();

          $data['dermal_toxicty_total'] = Product::where('pharm_process_status',5)->where('pharm_testconducted',2)   
          ->whereHas("departments", function ($q) use ($data) {
              return $q->where("dept_id", 2)->where("status",7)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->get();
          
      //****************************************** PHYTO */

       $data['phyto_products'] = Product::whereHas("departments", function ($q) use ($data) {
        return $q->where("dept_id", 3)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();
    
        
      $data['phyto_pendingproduct'] = Product::  
      whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 3)->where("status", '>',1)->where("status", '<',4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

      $data['phyto_completedproduct'] = Product::where('phyto_hod_evaluation', 2)    
      ->whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 3)->where("status", 4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

      $data['phyto_failedproduct'] = Product::where('phyto_grade', 1)    
      ->whereHas("departments", function ($q) use ($data) {
          return $q->where("dept_id", 3)->where("status", 4)->whereRaw('YEAR(received_at)= ?', array($data['year']));
      })->get();

      return view('admin.home', $data);
        
    }

  
}
