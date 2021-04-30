<?php

namespace App\Http\Controllers\AdminAuth\Pharmacology;

use Illuminate\Http\Request;
use App\Http\Requests\AcceptPharmProductRequest;
use App\Http\Controllers\Controller;
use App\Department;
use App\ProductDept;
use App\Admin;
use App\Product;
use App\ProductType;
use App\PharmTestConducted;
use App\PharmSamplePreparation;
use App\PharmAnimalExperiment;
use App\PharmToxicity;
use App\PharmAnimalModel;
use App\PharmFinalReport;
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

    //********************* pharm Receive Product ****************** */

    public function receiveproduct_index(){
          
          $data['product_type_id']= 0;
          $data['status'] = 0;
          $data['date'] = 0;
          $data['product_types'] = ProductType::all();
          $data['dept2'] = Department::find(2)->products()->with('departments')->where('status',1)->orderBy('status')->get();
        
          return View('admin.pharm.receiveproduct', $data); 

    }

    
    public function productlist_search(Request $r){
      // dd($r->all());
     $data['product_type_id'] = $r->product_type_id;
     $data['status'] = $r->status;
     $data['date'] = $r->date;

     $data['product_types'] = ProductType::all();

      if ($r->date == Null) {
        $data['dept2'] = Department::find(2)->products()->with('departments')->orderBy('status')
        ->whereHas("departments", function($q)use($r){
         return $q->where("dept_id",2)->where("status",$r->status);
        })->get();
      }
   
      if ($r->date == 1) {

        $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));

        $data['dept2'] = Department::find(2)->products()->orderBy('status')->with('departments')
        ->whereHas("departments", function($q)use($r,$week_start){
          return $q->where("dept_id",2)->where('product_depts.created_at','>=',$week_start);
        })->get();

        if ($r->status == 1) {

          $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));

          $data['dept2'] = Department::find(2)->products()->orderBy('status')->with('departments')
          ->whereHas("departments", function($q)use($r,$week_start){
            return $q->where("dept_id",2)->where("status",$r->status)->where('product_depts.created_at','>=',$week_start);
          })->get();
        }
   
        if ($r->status > 1) {
          $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));

          $data['dept2'] = Department::find(2)->products()->orderBy('status')->with('departments')
          ->whereHas("departments", function($q)use($r,$week_start){
            return $q->where("dept_id",2)->where("status",$r->status)->where('product_depts.received_at','>=',$week_start);
          })->get();
        }
   
      }

      if ($r->date == 2) {

        $month_start = date('Y-m-01 00:00:00');

        $data['dept2'] = Department::find(2)->products()->orderBy('status')->with('departments')->whereHas("departments", function($q)use($r,$month_start){
           return $q->where("dept_id",2)->where('product_depts.created_at','>=',$month_start);
         })->get();

        if ($r->status == 1) {
          $month_start = date('Y-m-01 00:00:00');

          $data['dept2'] = Department::find(2)->products()->orderBy('status')->with('departments')->whereHas("departments", function($q)use($r,$month_start){
             return $q->where("dept_id",2)->where("status",$r->status)->where('product_depts.created_at','>=',$month_start);
           })->get();
        }
        if ($r->status > 1) {
          $month_start = date('Y-m-01 00:00:00');

          $data['dept2'] = Department::find(2)->products()->orderBy('status')->with('departments')->whereHas("departments", function($q)use($r,$month_start){
             return $q->where("dept_id",2)->where("status",$r->status)->where('product_depts.received_at','>=',$month_start);
           })->get();
        }
    
      }
      elseif ($r->date == Null && $r->status == Null) {
    
      $data['dept2'] = Department::find(2)->products()->with('departments')->orderBy('status')
     ->whereHas("departments", function($q){
      return $q->where("dept_id",2);
     })->get();
     }
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

            if ($status == 1) {
              $data = 
              [ 
              'status' => $status,
              'received_by' => Null,
              'delivered_by' => NULL,
              'received_at' => Null,
              ];
        
              ProductDept::whereIN('product_id', $deptproduct_id)->where("dept_id", 2)->where("status", '<', 3)->update($data);
            
            }
            
            if ($status == 2) {
              $data = 
              [ 
              'status' => $status,
              'received_by' => $adminId,
              'delivered_by' => $delivered_by,
              'received_at' => \Carbon\Carbon::now(),
              ];
        
              ProductDept::whereIN('product_id', $deptproduct_id)->where("dept_id", 2)->where("status", '<', 3)->update($data);
            
            }
          
          
            Session::flash('message_title', 'success');
            Session::flash('message', 'Product(s) status successfully updated ');
            return redirect()->route('admin.pharm.receiveproduct')
            ->with('success', 'Section updated successfully');
          }

          public function checkuser(Request $request){
            
            $userEmail = $request->get('email');
            $adminPin = $request->get('pin');

            $checkmailonly = Admin::where('email', '=', $userEmail)->first();
            $admin = Admin::where('dept_id',4)->where('email', '=', $userEmail)->first();

            if (!$checkmailonly) {
              return response()->json(['status' => false, 'message' => "There's no user with the given email"]);
            }
            if(!$admin){
              return response()->json(['status' => false, 'message' => "Sorry you are not authorized to sign. Contact SID "]);
            }
            if(!Hash::check($adminPin, $admin->pin)){
              return response()->json(['status' => false, 'message' => "Your PIN is invalid. Please check and sign"]);
            }
            
          return response()->json(['status' => true, 'message' => "success", 'admin' => $admin->id]);
            // if ($user) {
            //   return redirect()->route('admin.user.microproduct', $user);
            // }
           
         }
    
         //**************************************************************************************** Report Index ********************************* */
         public function pharmreport_index(){
          $data['pharm_testconducteds'] = PharmTestConducted::all();

           $data['samples_to_animalhouses'] = Product::with('departments')->whereHas("departments", function($q){
             return $q->where("dept_id", 2)->where("status", 2);
           })->with('samplePreparation')->whereHas("samplePreparation", function($q){
             return $q->where("created_by", Auth::guard('admin')->id());
           })->get();

           $data['sample_preps'] = Product::orderBy('pharm_process_status')->with('departments')->whereHas("departments", function($q){
             return $q->where("dept_id", 2)->where("status", 3);
           })->with('samplePreparation')->whereHas("samplePreparation", function($q){
            return $q->where("created_by", Auth::guard('admin')->id());
          })->get();


           $data['exp_inprogress'] = Product::with('departments')->whereHas("departments", function($q){
             return $q->where("dept_id", 2)->where("status", 7);
           })->with('animalExperiment')->whereHas("animalExperiment")->with('samplePreparation')->whereHas("samplePreparation", function($q){
             return $q->where("created_by", Auth::guard('admin')->id()); })->get();

           $data['exp_completeds'] = Product::with('departments')->whereHas("departments", function($q){
             return $q->where("dept_id", 2)->where("status", 8);
           })->with('animalExperiment')->whereHas("animalExperiment")->with('samplePreparation')->whereHas("samplePreparation")->get();

           return View('admin.pharm.report_index', $data); 
         }

         //******************************************************************************************Sample Preparation********************** */
              public function samplepreparation_create(){

                $data['product_type_id'] = 0;
                $data['list'] = 0;
                $data['date'] = Null;
           

                $data['product_types'] = \App\ProductType::all();
                $data['pharm_testconducteds'] = PharmTestConducted::all();
                $data['pharmproducts'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 2)->where("status", 2);
                })->with('samplePreparation')->whereDoesntHave("samplePreparation")->get();
     
                return View('admin.pharm.samplepreparation.create', $data); 

              }
              public function samplepreparation_search(Request $r){

                 $data['product_type_id'] = $r->product_type_id;
                 $data['list'] = $r->otherlist;
                 $data['date'] = $r->date;

                 $data['product_types'] = \App\ProductType::all();
                 $data['pharm_testconducteds'] = PharmTestConducted::all();
                 $data['pharmproducts'] = Product::with('departments')->whereHas("departments", function($q){
                   return $q->where("dept_id", 2)->where("status", 2);
                 })->with('samplePreparation')->whereDoesntHave("samplePreparation")->get();

                 if ($r->date == 1) {

                  $today = \Carbon\Carbon::now();
          
                  $data['pharmproducts'] = Product::with('departments')->whereHas("departments", function($q)use($r,$today){
                    return $q->where("dept_id", 2)->where("status", 2)->where('product_depts.received_at','>=',$today);
                  })->with('samplePreparation')->whereDoesntHave("samplePreparation")->get();

                }
                
                 if ($r->date == 2) {

                  $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));
          
                  $data['pharmproducts'] = Product::with('departments')->whereHas("departments", function($q)use($r,$week_start){
                    return $q->where("dept_id", 2)->where("status", 2)->where('product_depts.received_at','>=',$week_start);
                  })->with('samplePreparation')->whereDoesntHave("samplePreparation")->get();

                }
                
                if ($r->date == 3) {

                  $month_start = date('Y-m-01 00:00:00');
          
                  $data['pharmproducts'] = Product::with('departments')->whereHas("departments", function($q)use($r,$month_start){
                    return $q->where("dept_id", 2)->where("status", 2)->where('product_depts.received_at','>=',$month_start);
                  })->with('samplePreparation')->whereDoesntHave("samplePreparation")->get();

                }
      
                 return View('admin.pharm.samplepreparation.create', $data); 
              }

              public function samplepreparation_store(Request $r){
                  // dd(($r->all()));

                  $in_array = PharmSamplePreparation::whereIn('product_id',$r->product_id);
                  if (count($in_array->get()) > 0) {
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Sorry Selected product has been submited by another user.(Duplicate data entry)');
                      return redirect()->route('admin.pharm.samplepreparation.create');
                  }
                   $weight = [];
                   $dosage = [];
                   $yield = [];
                   $remarks = [];
                   $pharm_testconducted = [];
                   $product = $r->product_id;
                   if ($product == Null) {
                    Session::flash('message_title', 'error');
                    Session::flash('message', 'Please select required product or wait to recieve product from the SID Unit.');
                    return redirect()->route('admin.pharm.samplepreparation.create');  
                   }

                  foreach ($r->product_id as $key => $value) {
                    if(!isset($r->{'weight_'.$value}) or $r->{'weight_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'weight field is required.');
                      return redirect()->route('admin.pharm.samplepreparation.create');  
                    }
                    if(!isset($r->{'dosage_'.$value}) or $r->{'dosage_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Dosage field is required.');
                      return redirect()->route('admin.pharm.samplepreparation.create');  
                    }
                    if(!isset($r->{'yield_'.$value}) or $r->{'yield_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Yield field is required.');
                      return redirect()->route('admin.pharm.samplepreparation.create');  
                    }
                    if(!isset($r->{'pharm_testconducted_'.$value}) or $r->{'pharm_testconducted_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Pharm testconducted field is required.');
                      return redirect()->route('admin.pharm.samplepreparation.create');  
                    }
                    array_push($weight,$r->{'weight_'.$value});
                    array_push($dosage,$r->{'dosage_'.$value});
                    array_push($yield,$r->{'yield_'.$value});
                    array_push($pharm_testconducted,$r->{'pharm_testconducted_'.$value});
                    array_push($remarks,$r->{'remarks_'.$value});
                  }
                  
               
                for ($i=0; $i < count($r->product_id); $i++) { 
                  
                    PharmSamplePreparation::create([
                    'product_id'=>$r->product_id[$i],
                    'weight'=>$weight[$i],
                    'dosage'=>$dosage[$i],
                    'yield'=>$yield[$i], 
                    'pharm_testconducted_id'=>$pharm_testconducted[$i], 
                    'samplestatus'=>0, 
                    'created_by'=>Auth::guard('admin')->id(),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                    ]);
                    
                }

                // $data = [ 
                // 'pharm_process_status' => 3,
                // ];
                // Product::whereIN('id',$r->product_id)->where("pharm_process_status", 1)->update($data);
                // $productdepts = ProductDept::whereIn('product_id',$r->product_id)->where("dept_id", 2)->where("status",2)->update(['status' => 3]);
                           
                Session::flash("message", "Sample preparation completed and stored successfully");
                Session::flash("message_title", "success");
                return redirect()->route('admin.pharm.samplepreparation.create');
             }

             public function samplepreparation_update(Request $r){


               $r->validate([
                'weight' => 'required',
                'dosage' => 'required',
                'yield' => 'required',
                'pharm_testconducted' => 'required',
                ]);
                 
                $data = ([
                  'weight'=>$r->weight,
                  'dosage'=>$r->dosage,
                  'yield'=>$r->yield, 
                  'pharm_testconducted_id'=>$r->pharm_testconducted, 
                  'updated_at' => \Carbon\Carbon::now(),
                ]);

                PharmSamplePreparation::where('id',$r->recordbook_id)->update($data);

                Session::flash("message", "Product sample data updated successfully");
                Session::flash("message_title", "success");
                return redirect()->back();
             }

             public function sampleprep_animalhouse(Request $r){
              // dd(($r->all()));
              if ($r->product_id == Null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required product.');
                return redirect()->back(); 
              }


              // $measurement = $r->measurement;
              // if (in_array(Null,$measurement)){
              //   Session::flash('message_title', 'error');
              //   Session::flash('message', 'Please check measurement field(s) and insert data. Measurement field(s) is/are required');
              //   return redirect()->back(); 
              // }
     

              $l = 0;
              $count1 = count($r->item_id);
              while($l < $count1){
              DB::table('pharm_sample_preparations')->where('id', $r->item_id[$l])
                    ->update([
                      'measurement' => $r->measurement[$l],
                      'remarks' => $r->remarks[$l],
                      'distributed_by'=>Auth::guard('admin')->id(),
                      'distributed_at' => \Carbon\Carbon::now(),
                    ]  
                    );
                $l++;
              }
              // $data = [ 
              //   'samplestatus' => 1,
              //  ];
              // PharmSamplePreparation::whereNotNull('measurement')->update($data);

            $data = [ 
            'pharm_process_status' => 3,
            ];
            Product::whereIN('id',$r->product_id)->where("pharm_process_status", 1)->update($data);
            $productdepts = ProductDept::whereIn('product_id',$r->product_id)->where("dept_id", 2)->where("status",2)->update(['status' => 3]);
                       
            Session::flash("message", "Sample preparation completed. Product(s) is/are yet to be receieved for experimentation at the animal house");
            Session::flash("message_title", "success");
            return redirect()->route('admin.pharm.report.index');
         }

              public function sampleprep_animalhouse_delete($id){

                $product = Product::where('id',$id)->where("pharm_process_status",3)->first();
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
                
                  $data = [ 
                    'samplestatus' => 0,
                    'measurement' => Null,
                    'distributed_by' => Null,
                    'distributed_at' => Null,

                   ];
                  PharmSamplePreparation::where('product_id',$id)->update($data);
               
                  Session::flash("message", "Sample Preparation to animal house successfully deleted");
                  Session::flash("message_title", "success");
                  return redirect()->back();
              }

             public function samplepreparation_delete($id){
               
               $product = Product::where('id',$id)->where("pharm_process_status", '<',3)->first();
              if ($product == null)
              {
               Session::flash('message_title', 'error');
               Session::flash('message', 'Sorry Product cant be deleted! Animal experimention in progress with sample details');
               return redirect()->back();
              } 
                $data = [ 
                'pharm_process_status' => 1,
                ];
                Product::where('id',$id)->where("pharm_process_status", '<',3)->update($data);
                $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 2)->where("status",3)->update(['status' => 2]);
                
                $deleteData=PharmSamplePreparation::where('product_id',$id); 
                $deleteData->delete(); 

              Session::flash("message", "Sample Preparation successfully deleted");
              Session::flash("message_title", "success");
              return redirect()->back();
             }
 
              public function samplepreparation_samplesindex(){

              $data['admin'] = Auth::guard('admin')->id();
               $data['year'] = \Carbon\Carbon::now('y');
               $data['admins'] = Admin::where('dept_id',2)->where('dept_office_id','<',3)->get();

              $data['recordbooks'] = Product::whereHas("departments", function ($q){
                return $q->where("dept_id", 2)->where("status", '>',1);
               })->whereHas("samplePreparation", function ($q) use($data){
                return $q->whereRaw('YEAR(created_at)= ?', array($data['year']));
               })->get();

                return View('admin.pharm.samplepreparation.samplesindex',$data); 
              }

              public function samplepreparation_animalhouse(){


                $data['year'] = \Carbon\Carbon::now('y');
                $data['admins'] = Admin::where('dept_id',2)->where('dept_office_id','<',3)->get();

               $data['animalhouse_recordbooks'] = Product::whereHas("departments", function ($q){
                  return $q->where("dept_id", 2)->where("status", '>',1);
                 })->whereHas("samplePreparation", function ($q) use($data){
                  return $q->whereNotNull("measurement")->whereRaw('YEAR(created_at)= ?', array($data['year']));
                 })->get();
   
                 return View('admin.pharm.samplepreparation.samplestoanimalhouse',$data); 
               }
 

               public function samplepreparation_report(Request $r){

                $data['admins'] = Admin::where('dept_id',2)->where('dept_office_id','<',3)->get();

                    if ($r->pharm_admin == Null) {
                      $data['recordbooks'] = Product::whereHas("departments", function ($q){
                        return $q->where("dept_id", 2)->where("status", '>',1);
                       })->whereHas("samplePreparation", function ($q) use($r){
                        return $q->whereDate('created_at', '>=', $r->from_date)->whereDate('created_at','<=',$r->to_date);
                       })->get();
                    }
                    if ($r->pharm_admin != Null) {

                      $data['recordbooks'] = Product::whereHas("departments", function ($q){
                        return $q->where("dept_id", 2)->where("status", '>',1);
                       })->whereHas("samplePreparation", function ($q) use($r){
                        return $q->where('created_by',$r->pharm_admin)->whereDate('created_at', '>=', $r->from_date)->whereDate('created_at','<=',$r->to_date);
                       })->get();
                    }
       
                  return View('admin.pharm.samplepreparation.samplesindex',$data);
               
              }

              public function samplepreparation_animalhouse_report(Request $r){

                   $data['admins'] = Admin::where('dept_id',2)->where('dept_office_id','<',3)->get();
                  
                    if ($r->pharm_admin == Null) {
                      $data['animalhouse_recordbooks'] = Product::whereHas("departments", function ($q){
                        return $q->where("dept_id", 2)->where("status", '>',1);
                       })->whereHas("samplePreparation", function ($q) use($r){
                        return $q->whereNotNull("measurement")->whereDate('created_at', '>=', $r->from_date)->whereDate('created_at','<=',$r->to_date);
                       })->get();
                    }
                  
                   if ($r->pharm_admin != Null) {
                   
                     $data['animalhouse_recordbooks'] = Product::whereHas("departments", function ($q){
                      return $q->where("dept_id", 2)->where("status", '>',1);
                     })->whereHas("samplePreparation", function ($q) use($r){
                      return $q->whereNotNull("measurement")->where('distributed_by',$r->pharm_admin)->whereDate('created_at', '>=', $r->from_date)->whereDate('created_at','<=',$r->to_date);
                     })->get();
                  
                   }

                   return View('admin.pharm.samplepreparation.samplestoanimalhouse',$data);                                
             }
          

//************************************************************************************Animal Experimentation********************************************* */
               public function animalexperimentation_create(){

              $data['sample_preps'] = Product::where('pharm_process_status',3)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 3);
              })->with('samplePreparation')->whereHas("samplePreparation")->get();

              return View('admin.pharm.animalexperiment.receiveproduct',$data); 
             }

              public function animalexperimentation_receive(Request $r){
               
                $admins = Admin::where('dept_id',2)->where('dept_office_id','<',3)->pluck('id')->toArray();
             
              if (!in_array($r->officer,$admins)) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Ypu are not authorized to receive product.');
                return redirect()->back();
              }
              if ($r->product_id == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required product.');
                return redirect()->back();
              }
              
              $data = 
              [ 
              'received_by' => Auth::guard('admin')->id(),
              'delivered_by' => $r->officer,
              'delivered_at' => \Carbon\Carbon::now(),
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
                
                $data = 
                [ 
                'received_by' => Null,
                'delivered_by' => Null,
                'delivered_at' => Null,
                ];
          
                 PharmSamplePreparation::where('product_id', $id)->update($data);
                Session::flash("message", "Product successfully rejected");
                Session::flash("message_title", "success");
                return redirect()->back();
              }

              public function maketest(){
              
              $data['pharm_toxicity'] = PharmToxicity::all();

              $data['animalexps'] = Product::where('pharm_process_status',4)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 3);
              })->with('samplePreparation')->whereHas("samplePreparation")->get();

              $data['exp_inprogress'] = Product::where('pharm_experiment_by',Auth::guard('admin')->id())->where('pharm_process_status',5)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 3);
              })->with('samplePreparation')->whereHas("samplePreparation")->with('animalExperiment')->whereHas("animalExperiment")->get();

              $data['completed_reports'] = Product::where('pharm_process_status',5)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
                })->with('animalExperiment')->whereHas("animalExperiment")->orderBy('id','DESC')->limit(100)->get();

              
              return View('admin.pharm.animalexperiment.maketest',$data); 
             }

             public function animalexperiment_store(Request $r){

              // dd($r->all());         
                $data = $r->validate([
                'product_id' => 'required', 
                'pharm_testconducted' => 'required|numeric', 
                'animalmodel' => 'required', 
                'weight' => 'required', 
                'group' => 'required|numeric', 
                'time_administration' => 'required', 
                'death' => 'required', 
                'toxicity' => 'required', 
                'sex' => 'required', 
                'total_days' => 'required',  
                'dosage' => 'required',
                
            ]);
           
               $toxicity = array_values($r->toxicity);
              if ($r->animalmodel) {
                for ($i=0; $i < count($r->animalmodel); $i++) { 
                  
                  PharmAnimalExperiment::create([
                  'product_id'=>$r->product_id,
                  'pharm_testconducted_id'=>$r->pharm_testconducted,
                  'animal_model'=>$r->animalmodel[$i],
                  'weight'=>$r->weight[$i],
                  'volume'=>$r->volume_given[$i],
                  'time_administration'=>$r->time_administration[$i], 
                  'death'=>$r->death[$i], 
                  'toxicity'=>serialize($toxicity[$i]),
                  'sex'=>$r->sex[$i],
                  'method'=>$r->method_of_admin[$i],
                  'group'=>$r->group,
                  'time_death'=>$r->time_death[$i],
                  'total_days'=>$r->total_days,
                  'dosage'=>$r->dosage[$i],
                  'added_by_id'=> Auth::guard('admin')->id(),
                  'created_at' => \Carbon\Carbon::now(),
                  'updated_at' => \Carbon\Carbon::now(),
                  ]);
                   
                }
              }
                
                 PharmFinalReport::create(['product_id' => $r->product_id]);
                  $data = [ 
                  'pharm_testconducted' => $r->pharm_testconducted,
                  'pharm_process_status' => 5,
                  'pharm_experiment_by'  => Auth::guard('admin')->id(),
                  ];
                 Product::where('id',$r->product_id)->where("pharm_process_status", 4)->update($data);
                Session::flash("message", "Animal experiment completed and saved. Proceed by sending saved result for report preparation");
                Session::flash("message_title", "success");
                return redirect()->route('admin.pharm.animalexperimentation.maketest');
             }

             public function send_animaltest(Request $r){
                //  dd($r->all());
                 if ($r->product_id ===null) {
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Sorry please select product');
                  return redirect()->back();
                 }
               $product = Product::whereIn('id',$r->product_id)->where("pharm_process_status", 5);
               if(count($product->get()) < 1){     
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry this product is under experiment ');
                return redirect()->back();
                }
                $data = [ 
                  'status' => 7,
                 ];
                ProductDept::whereIn('product_id',$r->product_id)->where("dept_id", 2)->where("status", 3)->update($data);
                Session::flash("message", "Result of experiment has been submitted to process report");
                Session::flash("message_title", "success");

                return redirect()->route('admin.pharm.animalexperimentation.maketest');  
             }

             public function delete_animaltest($id){

              $product = Product::where('id',$id)->where("pharm_process_status", 5)->first();
                if ( $product->pharm_hod_evaluation >0) {
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Sorry Experiment cant be deleted. In report process mode');
                  return redirect()->back();
                }
               $data = [ 
                'pharm_testconducted' => null,
                'pharm_process_status' => 4,
                ];
                Product::where('id',$id)->where("pharm_process_status", 5)->update($data);

              $deleteData=PharmAnimalExperiment::where('product_id',$id); 
              $deleteData->delete(); 

              $deleteData=PharmFinalReport::where('product_id',$id); 
              $deleteData->delete(); 

              Session::flash("message", "Animal Experiment deleted Successfully");
              Session::flash("message_title", "success");
              return redirect()->route('admin.pharm.animalexperimentation.maketest');
             }

             public function edit_animaltest($id){
            
                $product = Product::where('id',$id)->where("pharm_process_status", 5)->get();
              if (count($product) < 1) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! this record cant be edited. In report process mode');
                return redirect()->back();
              }

              $data['pharm_toxicity'] = PharmToxicity::all();

              $data['animalexps'] = Product::where('pharm_process_status',4)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 3);
              })->with('samplePreparation')->whereHas("samplePreparation")->get();

              $data['exp_inprogress'] = Product::where('pharm_experiment_by',Auth::guard('admin')->id())->where('pharm_process_status',5)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 3);
              })->with('samplePreparation')->whereHas("samplePreparation")->with('animalExperiment')->whereHas("animalExperiment")->get();

              $data['completed_reports'] = Product::where('pharm_process_status',5)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status",'>', 6);
                })->with('animalExperiment')->whereHas("animalExperiment")->orderBy('id','DESC')->limit(100)->get();

              

              $data['editexperiment'] = Product::where('id',$id)->where('pharm_process_status',5)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 2)->where("status", 3);
                })->with('samplePreparation')->whereHas("samplePreparation")->with('animalExperimentation')->whereHas("animalExperimentation")->orderBy('id','DESC')->first();

                Session::flash("message", "Please scroll down to edit product");
                Session::flash("message_title", "Attention");

                return View('admin.pharm.animalexperiment.editanimaltest',$data); 
             }

             public function update_animaltest(Request $r, $id){
              //  dd($r->all());
              $toxicity = array_values($r->toxicity);
              if ($r->product_id == $r->oldproduct_id ) {
              
                $deleteData=PharmAnimalExperiment::where('product_id',$r->oldproduct_id); 
                $deleteData->delete(); 
                if ($r->animalmodel) {
                  for ($i=0; $i <  count($r->animalmodel); $i++) { 
  
                    PharmAnimalExperiment::create([
                      'product_id'=>$r->oldproduct_id,
                      'pharm_testconducted_id'=>$r->pharm_testconducted,
                      'animal_model'=>$r->animalmodel[$i],
                      'weight'=>$r->weight[$i],
                      'volume'=>$r->volume_given[$i],
                      'time_administration'=>$r->time_administration[$i], 
                      'death'=>$r->death[$i], 
                      'toxicity'=>serialize($toxicity[$i]),
                      'sex'=>$r->sex[$i],
                      'method'=>$r->method_of_admin[$i],
                      'group'=>$r->group,
                      'time_death'=>$r->time_death[$i],
                      'total_days'=>$r->total_days,
                      'dosage'=>$r->dosage[$i],
                      'added_by_id'=> Auth::guard('admin')->id(),
                      'created_at' => \Carbon\Carbon::now(),
                      'updated_at' => \Carbon\Carbon::now(),
                      ]);   
                
                  }            
                }
              }else {
                return redirect()->back();
              }

              Session::flash("message", "Animal Experiment updated Successfully");
              Session::flash("message_title", "success");
              return redirect()->back();

             }

             public function animalexperiment_recordbook(){

             $data['year'] = \Carbon\Carbon::now('y');
             $data['admins'] = Admin::where('dept_id',2)->where('dept_office_id','<',3)->get();
             
             $data['recordbooks'] = Product::whereHas("departments", function ($q){
              return $q->where("dept_id", 2)->where("status", '>',1);
             })->whereHas("samplePreparation", function ($q) use($data){
              return $q->whereNotNull("measurement")->whereRaw('YEAR(created_at)= ?', array($data['year']));
             })->get();

              return View('admin.pharm.animalexperiment.recordbook',$data);
             }

                 
             public function animalexperiment_testconducted(){

             $data['all_exp_conducteds'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status",'>', 6);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

              return View('admin.pharm.animalexperiment.testconducted',$data);

             }

              public function animalexperiment_recordbook_report(Request $r){
              
                $data['admins'] = Admin::where('dept_id',2)->where('dept_office_id','<',3)->get();
                  
                if ($r->pharm_admin == Null) {
                  $data['recordbooks'] = Product::whereHas("departments", function ($q){
                    return $q->where("dept_id", 2)->where("status", '>',1);
                   })->whereHas("samplePreparation", function ($q) use($r){
                    return $q->whereNotNull("measurement")->whereDate('distributed_at', '>=', $r->from_date)->whereDate('distributed_at','<=',$r->to_date);
                   })->get();
                }
              
               if ($r->pharm_admin != Null) {
                $data['recordbooks'] = Product::whereHas("departments", function ($q){
                  return $q->where("dept_id", 2)->where("status", '>',1);
                 })->whereHas("samplePreparation", function ($q) use($r){
                  return $q->whereNotNull("measurement")->where('received_by',$r->pharm_admin)->whereDate('delivered_at', '>=', $r->from_date)->whereDate('delivered_at','<=',$r->to_date);
                 })->get();
              
               }
           
              return View('admin.pharm.animalexperiment.recordbook',$data); 
              }

              public function completed_animalexperiment_report(Request $r){

              $data['all_exp_conducteds'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 2)->where("status",'>', 6);
                })->with('animalExperiment')->whereHas("animalExperiment", function($q)use($r){
                  return $q->whereDate('created_at', '>=', $r->from_date)->whereDate('created_at','<=',$r->to_date);
                })->get();
  
                return View('admin.pharm.animalexperiment.testconducted',$data); 
              }

              public function completedexperiment_show($id){

                $data['editexperiment'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 2)->where("status",'>', 6);
                })->with('samplePreparation')->whereHas("samplePreparation")->with('animalExperimentation')->whereHas("animalExperimentation")->orderBy('id','DESC')->first();
  
                return View('admin.pharm.animalexperiment.showanimaltest',$data); 

               }

             public function report_show($id){

              $data['pharmreports'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->first();

              $data['pharm_finalreports'] = PharmFinalReport::where('product_id',$id)->first();

              if($data['pharmreports']  == null){     
              return redirect()->route('admin.pharm.samplepreparation.create');
              }
              return View('admin.pharm.createreport',$data);              
             }

                public function animalexperimentation_fetchtoxicity(){
                  return ['data'=>PharmToxicity::get(['id','name'])];
                }

                public function animalexperimentation_fetchanimalmodel(){

                  return ['data'=>PharmAnimalModel::get(['id','name'])];
                }

                public function pharmreport_create(Request $r, $id){
               
                //  dd($r->all());
                 $date_analysed = (\Carbon\Carbon::parse($r->date_analysed));
                 if ($r->date_analysed > \Carbon\Carbon::now()) {
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Please check date field. Date must not exceed todays date');
                  return redirect()->back();
                 }
          
                 $products =Product::where('id', $id)->where("pharm_process_status", 5)->with("departments")->whereHas("departments", function($q){
                  return $q->where("dept_id", 2);
                  });
                    if(count($products->get()) < 1){    
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'System Error! Product is not ready for report preparation'); 
                      return redirect()->back();
                    } 
                    $product = $products->first();
                    $product->pharm_acute_comment = $r->pharm_acute_comment;
                    $product->pharm_dermal_comment = $r->pharm_dermal_comment;
                    $product->pharm_result = $r->pharm_result;
                    $product->pharm_standard = $r->pharm_standard;
                    $product->pharm_analysed_by = Auth::guard('admin')->id();
                    $product->pharm_grade = $r->pharm_grade;
                    $product->pharm_dateanalysed = $date_analysed;
                    $product->update();

             
                  $data = ([
                    'product_id'=>$id,
                    'pharm_testconducted_id'=>$r->pharm_testconducted,
                    'pharm_animal_model'=>$r->animal_model,
                    'num_of_animals'=>$r->animal_sex,
                    'animal_sex'=>$r->num_of_animals,
                    'no_group'=>$r->no_group, 
                    'method_of_admin'=>$r->method_of_admin, 
                    'formulation'=>$r->formulation,
                    'preparation'=>$r->preparation,
                    'no_days'=>$r->no_days,
                    'no_death'=>$r->no_death,
                    'dosage'=>$r->dosage,
                    'estimated_dose'=>$r->estimated_dose,
                    'signs_toxicity'=>$r->signs_toxicity,
                    'added_by_id'=> Auth::guard('admin')->id(),
                    'updated_at' => \Carbon\Carbon::now(),
                    ]);
                    PharmFinalReport::where('product_id', $id)->update($data);
                    Session::flash("message", "Report successfully saved");
                    Session::flash("message_title", "success");

                    if ($r->complete_report) {
                      $product->pharm_hod_evaluation = 0;
                      $product->pharm_datecompleted = \Carbon\Carbon::now();
                      $product->update();
                      Session::flash("message", "Report has been submitted to the Head of Department");
                      Session::flash("message_title", "success");
                    }
                return redirect()->back();
             }

             //**************************************** HOD office */
             public function hodoffice_evaluation(){
          
              
              $data['evaluations'] = Product::where('pharm_hod_evaluation','>=',0)->where('pharm_process_status','<',6)->with('departments')->whereHas("departments", function($q){
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
   
               $data['final_reports'] = Product::where('pharm_hod_evaluation',2)->where('pharm_process_status','>',5)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

          
               return view('admin.pharm.hodoffice.evaluation',$data);

            }

             public function evaluate_one_index($id){
             
              $data['evaluations'] = Product::where('pharm_hod_evaluation','>=',0)->where('pharm_process_status','<',6)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();

              $data['final_reports'] = Product::where('pharm_hod_evaluation',2)->where('pharm_process_status','>',5)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->get();


              $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 2)->where("status",7);
               if(count($productdepts->get()) < 1){     
                 return redirect()->route('admin.pharm.hod_office.approval');
               }  
               $data['report_id'] = $id; 

              $data['pharmreports'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->with('animalExperiment')->whereHas("animalExperiment")->first();

              $data['pharm_finalreports'] = PharmFinalReport::where('product_id',$id)->first();
               return view('admin.pharm.hodoffice.showreport',$data);
             }

            public function evaluate(Request $r){
                $input = $r->all();
              // dd($r->all()) ;
       
              if ($r->pharm_evaluated_product == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required reports for evaluation');
                return redirect()->back();
              }
              $p = Product::whereIn('id',$r->pharm_evaluated_product )->where('pharm_process_status',"<",8)->get();
              if (count($p) > 0 ) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry product cant be completed');
                return redirect()->back();
              }
              $productdept =  Product::whereIn('id',$r->pharm_evaluated_product )->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 7);
              })->first();
              
              if ($productdept->pharm_hod_evaluation < 2) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select approved reports only ');
                return redirect()->back();
              }
              $data = [ 
                'status' => 8,
              ];
             ProductDept::whereIn('product_id', $r->pharm_evaluated_product)->where("dept_id", 2)->where("status", 7)->update($data);

             Session::flash("message", "Evaluation completed for selected reports.");
             Session::flash("message_title", "success");
           
              return redirect()->back();
             }


           
           public function checkhodsign(Request $request){
             
            $userEmail = $request->get('email');
            $adminPin = $request->get('pin');

            $checkallmail = Admin::where('email', '=', $userEmail)->first();
            $checkmailonly = Admin::where('dept_id',2)->where('email', '=', $userEmail)->first();
            $admin = Admin::where('dept_id',2)->where('dept_office_id', '<',3)->where('email', '=', $userEmail)->first();

            if (!$checkallmail) {
              return response()->json(['status' => false, 'message' => "Sorry there is no such email in the system"]);
            }
            if (!$checkmailonly) {
              return response()->json(['status' => false, 'message' => "Sorry This section is authorised by the head of department"]);
            }
            if(!$admin){
              return response()->json(['status' => false, 'message' => "Sorry you are not authorized to sign. Contact Department Head "]);
            }
            if(!Hash::check($adminPin, $admin->pin)){
              return response()->json(['status' => false, 'message' => "Invalid PIN. Please check and sign "]);
            }
            
            return response()->json(['status' => true, 'message' => "success", 'admin' => $admin->id]);
            
          }

            
          public function checkhodfinalapprovalsign(Request $request){
         
            $userEmail = $request->get('email');
            $adminPin = $request->get('pin');

            $checkallmail = Admin::where('email', '=', $userEmail)->first();
            $checkmailonly = Admin::where('dept_id',2)->where('email', '=', $userEmail)->first();
            $admin = Admin::where('dept_id',2)->where('dept_office_id',1)->where('user_type_id',1)->where('email', '=', $userEmail)->first();

            if (!$checkallmail) {
              return response()->json(['status' => false, 'message' => "Sorry there is no such email in the system"]);
            }
            if (!$checkmailonly) {
              return response()->json(['status' => false, 'message' => "Sorry This section is authorised by the head of department"]);
            }
            if(!$admin){
              return response()->json(['status' => false, 'message' => "Sorry you are not authorized to sign. Contact Department Head "]);
            }
            if(!Hash::check($adminPin, $admin->pin)){
              return response()->json(['status' => false, 'message' => "Invalid PIN. Please check and sign "]);
            }
            
            return response()->json(['status' => true, 'message' => "success", 'admin' => $admin->id]);
            
          }

          public function evaluate_one_edit(Request $r, $id){
            
            if ($r->evaluate <1) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
              return redirect()->back();
            }
            if ($r->evaluate >2) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
              return redirect()->back();
            }
             $product = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 2);
             })->with('animalExperiment')->whereHas("animalExperiment");
             
             if(count($product->get()) < 1){
              Session::flash('message_title', 'error');
              Session::flash('message', 'System Error! Product cant be approved ');     
              return redirect()->back();
            }
            

            $p = Product::findOrFail($id);
            $p->update([
              'pharm_hod_evaluation'=> $r->evaluate,
              'pharm_approved_by'=>$r->adminid,
              'pharm_dateapproved'=>\Carbon\Carbon::now(),
            ]); 

            if ($r->evaluate ==1) {
              $p->update([
                'pharm_process_status'=> 5,
                'pharm_approved_by'=>Null,
                'pharm_dateapproved'=>Null,
              ]); 
            }

            // if ($p->micro_hod_evaluation == 2 && $p->pharm_hod_evaluation == 2 && $p->phyto_hod_evaluation ==2 ) {
            //   $p->update(['overall_status'=> 2]);
            // }else {
            //   $p->update(['overall_status'=> 1]);
            // }

           Session::flash("message", "Report Evaluation completed.");
           Session::flash("message_title", "success");  
           return redirect()->back();
           }
            
           public function finalhodevaluate_one_edit(Request $r, $id){
             
              // dd($r->all());
            if ($r->evaluate <1) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
              return redirect()->back();
            }
            if ($r->evaluate >2) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
              return redirect()->back();
            }
             $product = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 2);
             })->with('animalExperiment')->whereHas("animalExperiment");
             
             if(count($product->get()) < 1){
              Session::flash('message_title', 'error');
              Session::flash('message', 'System Error! Product cant be approved ');     
              return redirect()->back();
            }
             $evaluate = [];
            if ($r->evaluate ==1) {
               $evaluate = 7;//*** 7 means withheld */
            }
            if ($r->evaluate ==2) {
              $evaluate = 8;//*** 8 means Approved */
            }  
         
            $p = Product::findOrFail($id);
            $p->update([
              'pharm_process_status'=> $evaluate,
              'pharm_finalapproved_by'=>$r->adminid,
              'pharm_finaldateapproved'=>\Carbon\Carbon::now(),
            ]); 
            
            if ($r->evaluate ==1) {
              $p->update([
                'pharm_process_status'=> 7,
                'pharm_finalapproved_by'=>Null,
                'pharm_finaldateapproved'=>Null,
              ]); 
            }

            if ($p->micro_hod_evaluation == 2 && $p->pharm_hod_evaluation == 2 && $p->phyto_hod_evaluation ==2 ) {
              $p->update(['overall_status'=> 2]);
            }else {
              $p->update(['overall_status'=> 1]);
            }

           Session::flash("message", "Report Evaluation completed.");
           Session::flash("message_title", "success");  
           return redirect()->back();
           }


           public function hod_editreport(Request $r, $id){
            //  dd($r->all());

            $products =Product::where('id', $id)->where("pharm_process_status", ">",4)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id", 2);
              });
             if(count($products->get()) < 1){    
              Session::flash('message_title', 'error');
              Session::flash('message', 'System Error! Product cant be edited');  
               return redirect()->back();
              }
          
            if ($r->pharm_testconducted == 1 || $r->pharm_testconducted == 3) {
            
              $data = ([
                'product_id'=>$id,
                'pharm_testconducted_id'=>$r->pharm_testconducted,
                'pharm_animal_model'=>$r->animal_model,
                'num_of_animals'=>$r->animal_sex,
                'animal_sex'=>$r->num_of_animals,
                'no_group'=>$r->no_group, 
                'method_of_admin'=>$r->method_of_admin, 
                'formulation'=>$r->formulation,
                'preparation'=>$r->preparation,
                'no_days'=>$r->no_days,
                'no_death'=>$r->no_death,
                'dosage'=>$r->dosage,
                'estimated_dose'=>$r->estimated_dose,
                'signs_toxicity'=>$r->signs_toxicity,
                'added_by_id'=> Auth::guard('admin')->id(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                ]);
  
                PharmFinalReport::where('product_id', $id)->update($data);
                $product = $products->first();
                $product->pharm_acute_comment = $r->pharm_acute_comment;
                $product->update();
            }
              if ($r->pharm_testconducted == 2 || $r->pharm_testconducted == 3) {
                $product = $products->first();
                $product->pharm_result = $r->pharm_result;
                $product->pharm_standard = $r->pharm_standard;
                $product->pharm_acute_comment = $r->pharm_acute_comment;
                $product->pharm_dermal_comment = $r->pharm_dermal_comment;
                $product->update();
              }

              $product = $products->first();
              $product->pharm_grade = $r->pharm_grade;
              $product->pharm_hod_remarks = $r->pharm_hod_remarks;
              $product->pharm_dateanalysed = (\Carbon\Carbon::parse($r->date_analysed));
              $product->update();

              Session::flash("message", "Report updated successfully");
              Session::flash("message_title", "success");
               
              return redirect()->back();
           }

           public function hod_finalreport_send($id){
            
            $completed =ProductDept::where('product_id', $id)->where("dept_id", 2)->where("status", 7)->first();
           $withheld =Product::where('id', $id)->where("pharm_process_status",'>',5)->first();

            if (!$completed) {
             Session::flash('message_title', 'error');
             Session::flash('message', 'Warning! Product cant be submited for approval');
             return redirect()->route('admin.pharm.hod_office.approval');
            }
            if ($withheld) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! Product withheld and cant be submited for approval  ');
              return redirect()->route('admin.pharm.hod_office.approval');
             }

              $data = [ 
              'pharm_process_status' => 6,
              ];
              Product::where('id',$id)->where("pharm_process_status", 5)->update($data);
              
              Session::flash("message", "Report successfully submitted for final approval.");
              Session::flash("message_title", "success");  
             return redirect()->route('admin.pharm.hod_office.approval');
           }

           public function hod_finalreport_show($id){
           
            $data['final_reports'] = Product::where('pharm_hod_evaluation',2)->where('pharm_process_status','>',5)->with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 2)->where("status", 7);
            })->with('animalExperiment')->whereHas("animalExperiment")->get();

            $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 2)->where("status",7);
             if(count($productdepts->get()) < 1){     
               return redirect()->route('admin.pharm.hod_office.approval');
             }  
             $data['report_id'] = $id; 

          $data['pharmreports'] = Product::where('id',$id)->where('pharm_process_status','>',5)->with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 2)->where("status", 7);
            })->with('animalExperiment')->whereHas("animalExperiment")->first();

            $data['pharm_finalreports'] = PharmFinalReport::where('product_id',$id)->first();
             return view('admin.pharm.hodoffice.finalreport',$data);
           }


           public function hod_complete_report($id){
                
               $completed =ProductDept::where('product_id', $id)->where("dept_id", 2)->where("status", 7)->first();
               if (!$completed) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Warning! Product cant be completed ');
                return redirect()->route('admin.pharm.hod_office.approval');
               }
             
                $data2 = [ 
                  'status' => 8,
                ];
                ProductDept::where('product_id', $id)->where("dept_id", 2)->where("status", 7)->update($data2);
              
                $productdepts = ProductDept::where('product_id', $id)->where("dept_id", 2)->where("status",'>',6);
                if(count($productdepts->get()) < 1){     
                 return redirect()->back(); 
                 }

                $data['completed_report'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
               return $q->where("dept_id", 2)->where("status", '>',6);
               })->with('animalExperiment')->whereHas("animalExperiment")->first();

               $data['pharm_finalreports'] = PharmFinalReport::where('product_id',$id)->first();

               return view('admin.pharm.completedreport',$data);

           }
         
              public function completedreports_all(){

                $data['completed_reports'] = Product::where('pharm_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 2)->where("status", 8);
                })->with('animalExperiment')->whereHas("animalExperiment")->orderBy('id','DESC')->limit(100)->get();

                return view('admin.pharm.hodoffice.completedreport',$data);

             }

          
              public function animalexpe_config_index(){

                $data['toxicity'] = PharmToxicity::all();

                return view('admin.pharm.config.index',$data);
              }

              public function animalexpe_config_create(Request $r){
                $r->validate([
                  'name' => 'required', 
                ]);
               
                $data = ([
                  'name' => $r->name, 
                  'added_by_id'=> Auth::guard('admin')->id(),
                ]);
  
                PharmToxicity::create($data);
                Session::flash("message", "Toxicity Template created successfully");
                Session::flash("message_title", "success");  
                return redirect()->back();
              }

              public function animalexpe_config_update(Request $r){
                
                $r->validate([
                  'name' => 'required', 
                ]);

                    $l = 0;
                $count1 = count($r->pharm_toxicity_id);
                while($l < $count1){
                DB::table('pharm_toxicities')->where('id', $r->pharm_toxicity_id[$l])
                      ->update([
                        'name' => $r->name[$l],
                        'added_by_id'=> Auth::guard('admin')->id(),
                        'updated_at' => \Carbon\Carbon::now(),
                      ]  
                      );
                  $l++;
                }
                  Session::flash("message", "Toxicity Template updated successfully");
                Session::flash("message_title", "success");  
                return redirect()->back();
              }

             //*************************************************** General Report Section ************************** */\
             
             public function completedreport_show($id){
              
              $productdepts = ProductDept::where('product_id', $id)->where("dept_id", 2)->where("status",'>',6);
              if(count($productdepts->get()) < 1){     
               return redirect()->back(); 
               }

              $data['completed_report'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
             return $q->where("dept_id", 2)->where("status", '>',6);
             })->with('animalExperiment')->whereHas("animalExperiment")->first();

             $data['pharm_finalreports'] = PharmFinalReport::where('product_id',$id)->first();

             return view('admin.pharm.completedreport',$data);
             
             }

             public function generalreport_index(){
           
             $data['from_date'] = "2020-01-01";
            $data['to_date'] = now();

            $data['product_types'] = \App\ProductType::all();
            $data['year'] = \Carbon\Carbon::now('y');

            $data['pending_products1'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",2)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
            })->where('pharm_process_status','<>',8)->get();
            
            $data['pending_products2'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",2)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
            })->WhereNull("pharm_process_status")->get();

            $data['pending_products'] = $data['pending_products1']->merge($data['pending_products2']);

              $data['completed_products'] = Product::where('pharm_process_status', 8)->with("departments")->whereHas("departments", function($q)use ($data){
                return $q->where("dept_id",2)->where('status','>', 6)->whereRaw('YEAR(received_at)= ?', array($data['year']));
              })->get();

              return view('admin.pharm.generalreport.index',$data);
             }
             public function generalyearly_report(Request $r){
              $data = $r->all();
              $data['product_types'] = \App\ProductType::all();
              $data['from_date'] = "2020-01-01";
              $data['to_date'] = now();
   
              $data['pending_products1'] = Product::whereHas("departments", function($q)use ($data){
               return $q->where("dept_id",1)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
             })->where('pharm_hod_evaluation','<>',2)->get();
             
             $data['pending_products2'] = Product::whereHas("departments", function($q)use ($data){
               return $q->where("dept_id",1)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
             })->WhereNull("pharm_hod_evaluation")->get();
   
              $data['pending_products'] = $data['pending_products1']->merge($data['pending_products2']);

               $data['completed_products'] = Product::where('pharm_hod_evaluation', 2)->with("departments")
               ->whereHas("departments", function($q)use($data){
                return $q->where("dept_id",2)->where('status','>', 6)->whereRaw('YEAR(received_at)= ? ',array($data['year']));
              })->get();

               return view('admin.pharm.generalreport.index',$data);

              }

             public function completedreports_index($id){

              $data['ptype_id'] = $id;
              $data['completed_products'] = Product::where('product_type_id',$id)->where('pharm_hod_evaluation',2)->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id",2)->where('status','>', 6);
              })->get();

              return view('admin.pharm.generalreport.completedreports',$data);
             }

             public function pendingreports_index(Request $r, $id){
             
             $data['ptype_id'] = $id;
             $pending = Product::whereIn('id',$r->pending_product_ids)->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id",2)->where('status','>',1)->where('status','<', 8);
              })->pluck('id')->toArray();
             
             $data['dept2'] = Department::find(2)->products()->whereIn('product_id',$pending)->with('departments')->orderBy('status')->get();
          
              return view('admin.pharm.generalreport.pendingreports',$data);
             }

             public function between_months(Request $r){

              // $data = $r->all();
              if ($r->from_date == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required date to begin begin');
                return redirect()->route('admin.pharm.general_report.index');
               }
        
              if ($r->to_date == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required date to end report');
                return redirect()->route('admin.pharm.general_report.index');
               }
               
              $data['product_types'] = \App\ProductType::all();

           
             $data['pending_products1'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",1)->where("status", '>',1)->whereDate('product_depts.received_at', '>=', $r->from_date)->whereDate('product_depts.received_at', '<=', $r->to_date);
            })->where('pharm_hod_evaluation','<>',2)->get();
            
            $data['pending_products2'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",1)->where("status", '>',1)->whereDate('product_depts.received_at', '>=', $r->from_date)->whereDate('product_depts.received_at', '<=', $r->to_date);
            })->WhereNull("pharm_hod_evaluation")->get();
  
            $data['pending_products'] = $data['pending_products1']->merge($data['pending_products2']);

             $data['completed_products'] = Product::where('pharm_hod_evaluation', 2)->whereHas("departments", function($q)use($r){
                return $q->where("dept_id",2)->where('status','>', 6)->whereDate('received_at', '>=', $r->from_date)->whereDate('received_at','<=',$r->to_date);
              })->get(); 

              return view('admin.pharm.generalreport.index',$data);

             }

             public function yearly_report(Request $r){
              $data = $r->all();
              $data['ptype_id'] = $r->product_type;
  
              $data['completed_products'] = Product::where('product_type_id',$data['product_type'])->where('pharm_hod_evaluation', 2)->whereRaw('YEAR(created_at)= ? ',array($data['year']))->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id",2)->where('status','>', 6);
              })->get();
              return view('admin.pharm.generalreport.completedreports',$data);
             }
  
             public function monthly_report(Request $r){
  
              $data = $r->all();
              $data['ptype_id'] = $r->product_type;
              $data['completed_products'] = Product::where('product_type_id',$data['product_type'])->where('pharm_hod_evaluation', 2)->whereRaw('YEAR(created_at)= ? and MONTH  (created_at)=?',array($data['year'],$data['month']))->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id",2)->where('status','>', 6);
              })->get();
  
              return view('admin.pharm.generalreport.completedreports',$data);
  
             }

             public function pharmreport_pdf ($id){

            
           
              $productdepts = ProductDept::where('product_id', $id)->where("dept_id", 2)->where("status",'>',6);
              if(count($productdepts->get()) < 1){     
               return redirect()->back(); 
               }

              $data['completed_report'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
             return $q->where("dept_id", 2)->where("status", '>',6);
             })->with('animalExperiment')->whereHas("animalExperiment")->first();

              $data['pharm_finalreports'] = PharmFinalReport::where('product_id',$id)->first();

             
              // Send data to the view using loadView function of PDF facade
  
              $pdf = \PDF::loadView('admin.pharm.downloads.report',$data);
  
              $pdf->save(storage_path().'_filename.pdf');
  
              return $pdf->download('pharmreport.pdf');
  
              // return view('admin.micro.downloads.report',$data);
  
  
             }

  
}
