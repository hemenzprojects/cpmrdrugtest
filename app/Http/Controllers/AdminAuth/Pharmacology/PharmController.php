<?php

namespace App\Http\Controllers\AdminAuth\Pharmacology;

use Illuminate\Http\Request;
use App\Http\Requests\AcceptPharmProductRequest;
use App\Http\Controllers\Controller;
use App\Department;
use App\ProductDept;
use App\Admin;
use App\Product;
use App\PharmTestConducted;
use App\PharmSamplePreparation;
use App\PharmAnimalExperiment;
use App\PharmToxicity;
use \Session;
use \Hash;
use \Auth;
use \DB;

class PharmController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin');
    }

    //********************* Micro Receive Product ****************** */

    public function receiveproduct_index(){
          
          $data['dept2'] = Department::find(2)->products()->get();
        
          return View('admin.pharm.receiveproduct', $data); 

    }

    public function acceptproduct(AcceptPharmProductRequest $request)
        {   
        
            $adminId = Auth::guard('admin')->id();
            $deptproduct_id = $request->deptproduct_id;
            $status = $request->status;
            $delivered_by = $request->adminid;
            
              if ($status > 2 ) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
              return redirect()->back();
          } 
              if ($deptproduct_id == 0) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required product and submit.');
              return redirect()->back();
          }  

            $productdeptstatus = ProductDept::whereIn('product_id', $deptproduct_id)->where("dept_id", 2)->where("status", '>', 2)->first();
            if ($status < (!empty($productdeptstatus->status) ? $productdeptstatus->status: '')) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Sorry Product(s) is/are now in a work process mode..');
              return redirect()->back();
            } 
                        
            $data = 
            [ 
            'status' => $status,
            'received_by' => $adminId,
            'delivered_by' => $delivered_by,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            ];
      
            ProductDept::whereIN('product_id', $deptproduct_id)->where("dept_id", 2)->where("status", '<', 3)->update($data);
            
            Session::flash('message_title', 'success');
            Session::flash('message', 'Product(s) status successfully updated ');
            return redirect()->route('admin.pharm.receiveproduct')
            ->with('success', 'Section updated successfully');
          }

            public function checkuser(Request $request){
              
              $userEmail = $request->get('email');
              $adminPassword = $request->get('password');

              $checkmailonly = Admin::where('email', '=', $userEmail)->first();
              $admin = Admin::where('dept_id',4)->where('email', '=', $userEmail)->first();

              if (!$checkmailonly) {
                return response()->json(['status' => false, 'message' => "There's no user with the given email"]);
              }
              if(!$admin){
                return response()->json(['status' => false, 'message' => "Sorry you are not authorized to sign. Contact SID "]);
              }
              if(!Hash::check($adminPassword, $admin->password)){
                return response()->json(['status' => false, 'message' => "Your password is invalid"]);
              }
              
            return response()->json(['status' => true, 'message' => "success", 'admin' => $admin->id]);
              // if ($user) {
              //   return redirect()->route('admin.user.microproduct', $user);
              // }
             
    }   
    

    
            public function samplepreparation_create(){

              $data['pharm_testconducteds'] = PharmTestConducted::all();
              $data['pharmproducts'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 2);
              })->with('samplePreparation')->whereDoesntHave("samplePreparation")->get();

              $data['sample_preps'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 3);
              })->with('samplePreparation')->whereHas("samplePreparation")->get();

              $data['exp_inprogress'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

              $data['exp_completeds'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 8);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

              return View('admin.pharm.samplepreparation.createsample', $data); 
            }

            
              public function samplepreparation_store(Request $r){
                  // dd(($r->all()));
                   $measurement = [];
                   $dosage = [];
                   $yield = [];
                   $remarks = [];
                   $pharm_testconducted = [];
                   if ($r->product_id == null) {
                    Session::flash('message_title', 'error');
                    Session::flash('message', 'Please select required product or wait to recieve product from the SID Unit.');
                    return redirect()->back();
                  }
                  foreach ($r->product_id as $key => $value) {
                    if(!isset($r->{'measurement_'.$value}) or $r->{'measurement_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Measurement field is required.');
                      return redirect()->back();
                    }
                    if(!isset($r->{'dosage_'.$value}) or $r->{'dosage_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Dosage field is required.');
                      return redirect()->back();
                    }
                    if(!isset($r->{'yield_'.$value}) or $r->{'yield_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Yield field is required.');
                      return redirect()->back();
                    }
                    if(!isset($r->{'pharm_testconducted_'.$value}) or $r->{'pharm_testconducted_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Pharm testconducted field is required.');
                      return redirect()->back();
                    }
                    array_push($measurement,$r->{'measurement_'.$value});
                    array_push($dosage,$r->{'dosage_'.$value});
                    array_push($yield,$r->{'yield_'.$value});
                    array_push($pharm_testconducted,$r->{'pharm_testconducted_'.$value});
                    array_push($remarks,$r->{'remarks_'.$value});
                  }
                  
               
                for ($i=0; $i < count($r->product_id); $i++) { 
                  
                    PharmSamplePreparation::create([
                    'product_id'=>$r->product_id[$i],
                    'measurement'=>$measurement[$i],
                    'dosage'=>$dosage[$i],
                    'yield'=>$yield[$i], 
                    'pharm_testconducted_id'=>$pharm_testconducted[$i], 
                    'remarks'=>$remarks[$i],
                    'distributed_by'=> Auth::guard('admin')->id(),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                    ]);
                    
                }

                $data = [ 
                'pharm_process_status' => 3,
                ];
                Product::whereIN('id',$r->product_id)->where("pharm_process_status", 1)->update($data);
                $productdepts = ProductDept::whereIn('product_id',$r->product_id)->where("dept_id", 2)->where("status",2)->update(['status' => 3]);
                           
                Session::flash("message", "Sample preparation completed. Product(s) is/are yet to be receieved for experimentation at the animal house");
                Session::flash("message_title", "success");
                return redirect()->route('admin.pharm.samplepreparation.create');
             }

             public function samplepreparation_delete($id){
               $product = Product::where('id',$id)->where("pharm_process_status", 3)->first();
              if ($product == null)
              {
               Session::flash('message_title', 'error');
               Session::flash('message', 'Sorry Product cant be deleted! Animal experimention in progress with sample details');
               return redirect()->back();
              } 
                $data = [ 
                'pharm_process_status' => 1,
                ];
                Product::where('id',$id)->where("pharm_process_status", 3)->update($data);
                $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 2)->where("status",3)->update(['status' => 2]);
                
                $deleteData=PharmSamplePreparation::where('product_id',$id); 
                $deleteData->delete(); 

              Session::flash("message", "Sample Preparation successfully deleted");
              Session::flash("message_title", "success");
              return redirect()->back();
             }



               public function animalexperimentation_create(){

              $data['sample_preps'] = Product::where('pharm_process_status',3)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 3);
              })->with('samplePreparation')->whereHas("samplePreparation")->get();

              return View('admin.pharm.animalexperiment.receiveproduct',$data); 
             }

              public function animalexperimentation_receive(Request $r){
               
             
              if ($r->product_id == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required product.');
                return redirect()->back();
              }
              $data = 
              [ 
              'received_by' => Auth::guard('admin')->id(),
              'delivered_by' => $r->officer,
              'updated_at' => \Carbon\Carbon::now(),
              ];
        
               PharmSamplePreparation::whereIN('product_id', $r->product_id)->update($data);

                $data = [ 
                'pharm_process_status' => 4,
                ];
                Product::whereIN('id',$r->product_id)->where("pharm_process_status", 3)->update($data);
            
                Session::flash("message", "Product successfully received and ready for experiment. Please view record book for all received product");
                Session::flash("message_title", "success");
                return redirect()->route('admin.pharm.animalexperimentation.create');
             
             }

             public function animalexperimentation_reject($id){

                $data = [ 
                'pharm_process_status' => 3,
                ];
                Product::where('id',$id)->where("pharm_process_status", 4)->update($data);
            
                Session::flash("message", "Product successfully rejected");
                Session::flash("message_title", "success");
                return redirect()->back();
             }

              public function maketest(){

              $data['pharm_toxicity'] = PharmToxicity::all();

              $data['animalexps'] = Product::where('pharm_process_status',4)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 3);
              })->with('samplePreparation')->whereHas("samplePreparation")->get();

              $data['exp_inprogress'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

              $data['completed_reports'] = Product::where('pharm_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 8);
                })->with('animalExperiment')->whereHas("animalExperiment")->orderBy('id','DESC')->limit(100)->get();
              
              return View('admin.pharm.animalexperiment.maketest',$data); 
             }

             public function animalexperiment_store(Request $r){

              // dd($r->all());
                    
              if ($r->animalmodel) {
                for ($i=0; $i < count($r->animalmodel); $i++) { 
                  
                  PharmAnimalExperiment::create([
                  'product_id'=>$r->product_id,
                  'pharm_testconducted_id'=>$r->pharm_testconducted,
                  'animal_model'=>$r->animalmodel[$i],
                  'weight'=>$r->weight[$i],
                  'volume'=>$r->volume_given[$i],
                  'death'=>$r->death[$i], 
                  'toxicity'=>$r->toxicity[$i],
                  'sex'=>$r->sex[$i],
                  'method'=>$r->method_of_admin[$i],
                  'group'=>$r->group[$i],
                  'period'=>$r->period[$i],
                  'total_days'=>$r->total_days,
                  'dosage'=>$r->dosage[$i],
                  'added_by_id'=> Auth::guard('admin')->id(),
                  'created_at' => \Carbon\Carbon::now(),
                  'updated_at' => \Carbon\Carbon::now(),
                  ]);
                   
                }
              }
               

                 $data = [ 
                  'pharm_testconducted' => $r->pharm_testconducted,
                  ];
                  Product::where('id',$r->product_id)->where("pharm_process_status", 4)->update($data);
                $data = [ 
                  'status' => 7,
                ];
                ProductDept::where('product_id', $r->product_id)->where("dept_id", 2)->where("status", 3)->update($data);
                Session::flash("message", "Result of experiment has been submitted to process report");
                Session::flash("message_title", "success");
                return redirect()->route('admin.pharm.animalexperimentation.maketest');
               

             }

             public function delete_animaltest($id){

              // return $id;
              $product = Product::where('id',$id)->where("pharm_process_status", 4)->first();
                if ( $product->pharm_hod_evaluation >1) {
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Sorry Experiment cant be deleted. In report process mode');
                  return redirect()->back();
                }
               $data = [ 
                'pharm_testconducted' => null,
                ];
                Product::where('id',$id)->where("pharm_process_status", 4)->update($data);
              $data = [ 
                'status' => 3,
              ];
              ProductDept::where('product_id', $id)->where("dept_id", 2)->where("status", 7)->update($data);
 
              $deleteData=PharmAnimalExperiment::where('product_id',$id); 
              $deleteData->delete(); 

              Session::flash("message", "Animal Experiment deleted Successfully");
              Session::flash("message_title", "success");
              return redirect()->back();
             }

             public function update_animaltest(Request $r, $id){
              // dd($r->all(),$id);
              $deleteData=PharmAnimalExperiment::where('product_id',$id); 
              $deleteData->delete(); 

              if ($r->pharm_animal_model) {
                for ($i=0; $i <  count($r->pharm_animal_model); $i++) { 
                  PharmAnimalExperiment::create([
                    'product_id'=>$id,
                    'pharm_testconducted_id'=>$r->pharm_testconducted,
                    'animal_model'=>$r->pharm_animal_model[$i],
                    'weight'=>$r->weight[$i],
                    'volume'=>$r->volume[$i],
                    'death'=>$r->death[$i], 
                    'toxicity'=>$r->toxicity[$i],
                    'sex'=>$r->sex[$i],
                    'method'=>$r->method[$i],
                    'group'=>$r->group[$i],
                    'period'=>$r->period[$i],
                    'total_days'=>$r->total_days,
                    'dosage'=>$r->dosage[$i],
                    'added_by_id'=> Auth::guard('admin')->id(),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                    ]);
              
                }            
              }
               
              Session::flash("message", "Animal Experiment updated Successfully");
              Session::flash("message_title", "success");
              return redirect()->back();
             }

             public function animalexperiment_recordbook(){

             $data['recordbooks'] = PharmSamplePreparation::orderBy('id','DESC')->limit(100)->get();
             
              return View('admin.pharm.animalexperiment.recordbook',$data);
             }

             public function report_show($id){

              // dd($id);
            
              $data['pharmreports'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->first();

              if($data['pharmreports']  == null){     
              return redirect()->route('admin.pharm.samplepreparation.create');
              }

              return View('admin.pharm.createreport',$data); 

             }

             public function animalexperimentation_fetchtoxicity(){
               return ['data'=>PharmToxicity::get(['id','name'])];
             }

               public function pharmreport_create(Request $r, $id){
               
                 if ($r->date_analysed > \Carbon\Carbon::now()) {
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Please check date field. Date must not exceed todays date');
                  return redirect()->back();
                 }
      
                $data1 = [ 
                'pharm_comment' => $r->pharm_remmarks,
                'pharm_dateanalysed' => $r->date_analysed,
                ];
                Product::where('id',$id)->where("pharm_process_status", 4)->update($data1);
             
                Session::flash("message", "Result of experiment has been submitted to process report");
                Session::flash("message_title", "success");
               
                return redirect()->back();
             }

             public function hodoffice_evaluation(){
              //  return $data['finalreport'] = Product::with('departments')->whereHas("departments", function($q){
              //     return $q->whereIN("dept_id", [1,2,3])->where("status", 1);
              //   })->get();;
              
              $data['evaluations'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

              $data['withhelds'] = Product::where('pharm_hod_evaluation',1)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

              $data['approvals'] = Product::where('pharm_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

              $data['completeds'] = Product::where('pharm_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 8);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

               return view('admin.pharm.hodoffice.evaluation',$data);

            }
            public function evaluate(Request $r){
              $input = $r->all(); 
              if ($r->evaluation == null) {
                Session::flash('message_title', 'error');
                  Session::flash('message', 'Please select options to evaluate report');
                return redirect()->back();
              }
              if ($r->pharm_evaluated_product == null) {
                Session::flash('message_title', 'error');
                  Session::flash('message', 'Please select required reports for evaluation');
                return redirect()->back();
              }
      
             Product::whereIn('id',$r->pharm_evaluated_product)->update([
                   'pharm_hod_evaluation'=>$r->evaluation
             ]);
                   
             Session::flash("message", "Evaluation completed for selected reports.");
             Session::flash("message_title", "success");
           
             return redirect()->back();
           }

            public function completedreport_show($id){

                $data2 = [ 
                  'status' => 8,
                ];
                ProductDept::where('product_id', $id)->where("dept_id", 2)->where("status", 7)->update($data2);
                $data3 = [ 
                  'updated_at' => \Carbon\Carbon::now(),                 
                ];
                PharmAnimalExperiment::where('product_id', $id)->update($data3);

                $data['completed_report'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 8);
                })->with('animalExperiment')->whereHas("animalExperiment")->first();

                return view('admin.pharm.completedreport',$data);

             }

              public function hodoffice_completedreports(){

                $data['completed_reports'] = Product::where('pharm_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 8);
                })->with('animalExperiment')->whereHas("animalExperiment")->orderBy('id','DESC')->limit(100)->get();

                return view('admin.pharm.hodoffice.completedreport',$data);

             }
}
