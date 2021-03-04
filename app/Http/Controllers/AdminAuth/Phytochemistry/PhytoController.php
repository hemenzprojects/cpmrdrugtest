<?php

namespace App\Http\Controllers\AdminAuth\Phytochemistry;

use Illuminate\Http\Request;
use App\Http\Requests\AcceptPhytoProductRequest;
use App\Http\Controllers\Controller;
use App\Department;
use App\ProductDept;
use App\Product;
use App\Admin;
use App\PhytoTestConducted;
use App\PhytoPhysicochemData;
use App\PhytoOrganoleptics;
use App\PhytoChemicalConstituents;
use App\PhytoOrganolepticsReport;
use App\PhytoPhysicochemDataReport;
use App\PhytoChemicalConstituentsReport;
use \Session;
use \Hash;
use \Auth;

class PhytoController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    //********************* Micro Receive Product ****************** */

    public function receiveproduct_index(){
          
          $data['dept3'] = Department::find(3)->products()->with('departments')->orderBy('status')->get();

          return View('admin.phyto.receiveproduct', $data); 

    }

    public function acceptproduct(AcceptPhytoProductRequest $request)
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

            $productdeptstatus = ProductDept::whereIn('product_id', $deptproduct_id)->where("dept_id", 3)->where("status", '>',2)->first();
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
            'received_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            ];
      
            ProductDept::whereIN('product_id', $deptproduct_id)->where("dept_id", 3)->where("status", '<',3)->update($data);

            
            Session::flash('message_title', 'success');
            Session::flash('message', 'Product(s) status successfully updated ');
            return redirect()->route('admin.phyto.receiveproduct')
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


             public function makereport_index(){
          
             $data['phytoproducts'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 3)->where("status", 2);
              })->with('organolipticReport')->whereDoesntHave("organolipticReport")->get();
              
             $data['phytoreports'] = Product::where('phyto_analysed_by',Auth::guard('admin')->id())->with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 3)->where("status", 3);
             })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
             ->with('pchemconstReport')->whereHas('pchemconstReport')->get();

             $data['phytocompleted_reports'] = Product::where('phyto_analysed_by',Auth::guard('admin')->id())->with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 3)->where("status", 4);
             })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
             ->with('pchemconstReport')->whereHas('pchemconstReport')->get();

              $data['phyto_testconducted'] = PhytoTestConducted::all();
              $data['phyto_physicochemdata'] = PhytoPhysicochemData::all();
              $data['phyto_organoleptics'] = PhytoOrganoleptics::all();
              $data['phyto_chemicalconst'] = PhytoChemicalConstituents::all();

              return View('admin.phyto.createreport', $data); 
            }

            public function makereport_create(Request $r){

              $checkifexist = PhytoOrganolepticsReport::where('product_id',$r->product_id)->get();
              if (count( $checkifexist) >0) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Multiple test entry error');
              }
              $checkifexist = PhytoPhysicochemDataReport::where('product_id',$r->product_id)->get();
              if (count( $checkifexist) >0) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Multiple test entry error');
              }
              $checkifexist = PhytoChemicalConstituentsReport::where('product_id',$r->product_id)->get();
              if (count( $checkifexist) >0) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Multiple test entry error');
              }


              $date_analysed = (\Carbon\Carbon::parse($r->date_analysed));
  
              if ($r->date_analysed > \Carbon\Carbon::now()) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please check date field. Date must not exceed todays date');
                return redirect()->back();
               }
               if ($r->organoleptics_id == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required organoleptics.');
                return redirect()->back();
              }
              if ($r->physicochemdata_id == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required physicochemical data.');
                return redirect()->back();
              }
              if ($r->chemicalconst == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required physicochemical constituents data.');
                return redirect()->back();
              }
              $organoleptics_name = [];
              $organoleptics_feature = [];

              $physicochem_name = [];
              $physicochem_result = [];

            foreach ($r->organoleptics_id as $key => $value) {

              if(!isset($r->{'organolepticsname_'.$value}) or $r->{'organolepticsname_'.$value}==null){
                Session::flash('message_title', 'error');
                Session::flash('message', 'organoleptic field is required.');
                return redirect()->back();
              }
              if(!isset($r->{'organolepticsfeature_'.$value}) or $r->{'organolepticsfeature_'.$value}==null){
                Session::flash('message_title', 'error');
                Session::flash('message', 'organoleptics feature field is required.');
                return redirect()->back();
              }
              array_push($organoleptics_name,$r->{'organolepticsname_'.$value});
              array_push($organoleptics_feature,$r->{'organolepticsfeature_'.$value});
             
            }

            for ($i=0; $i < count($r->organoleptics_id); $i++) { 
                  
               PhytoOrganolepticsReport::create([
              'product_id'=>$r->product_id,
              'phyto_testconducted_id'=>$r->phyto_testconducted_1,
              'phyto_organoleptics_id'=>$r->organoleptics_id[$i],
              'name'=>$organoleptics_name[$i],
              'feature'=>$organoleptics_feature[$i], 
              'addedby_id'=> Auth::guard('admin')->id(),
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now(),
              ]);
              
             }

             foreach ($r->physicochemdata_id as $key => $value) {
              if(!isset($r->{'physicochemname_'.$value}) or $r->{'physicochemname_'.$value}==null){
                Session::flash('message_title', 'error');
                Session::flash('message', 'Physicocheminal name field is required.');
                return redirect()->back();
              }
              if(!isset($r->{'physicochemresult_'.$value}) or $r->{'physicochemresult_'.$value}==null){
                Session::flash('message_title', 'error');
                Session::flash('message', 'Physicocheminal result field is required.');
                return redirect()->back();
              }
              array_push($physicochem_name,$r->{'physicochemname_'.$value});
              array_push($physicochem_result,$r->{'physicochemresult_'.$value});
             
             }
            for ($i=0; $i < count($r->physicochemdata_id); $i++) { 
                  
              PhytoPhysicochemDataReport::create([
              'product_id'=>$r->product_id,
              'phyto_testconducted_id'=>$r->phyto_testconducted_2,
              'phyto_physicochemdata_id'=>$r->physicochemdata_id[$i],
              'name'=>$physicochem_name[$i],
              'result'=>$physicochem_result[$i], 
              'addedby_id'=> Auth::guard('admin')->id(),
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now(),
              ]);
              
             }


             for ($i=0; $i < count($r->chemicalconst); $i++) { 
                  
              PhytoChemicalConstituentsReport::create([
              'product_id'=>$r->product_id,
              'phyto_testconducted_id'=>$r->phyto_testconducted_3,
              'name'=>$r->chemicalconst[$i],
              'addedby_id'=> Auth::guard('admin')->id(),
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now(),
              ]);
              
             }

             $productdepts = ProductDept::where('product_id',$r->product_id)->where("dept_id", 3)->where("status",2)->update(['status' => 3]);
             
             $products =Product::where('id', $r->product_id)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id", 3)->where("status", 3);
              });
                if(count($products->get()) < 1){     
                  return redirect()->back();
                }
              $product = $products->first();
              $product->phyto_comment = $r->comment;
              $product->phyto_dateanalysed = $date_analysed;
              $product->phyto_analysed_by = Auth::guard('admin')->id();
              $product->update();

              Session::flash("message", "Report successfully created.");
              Session::flash("message_title", "success");
              return redirect()->back();
            }

            public function makereport_show ($id){

              $data['report_id'] = $id; 

              $data['phytoshowreport'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 3)->where("status", 3);
               })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
               ->with('pchemconstReport')->whereHas('pchemconstReport')->first();

              $data['organoleptics_ids'] = PhytoOrganolepticsReport::where('product_id',$id)->pluck('phyto_organoleptics_id')->toArray();
              $data['physicochemdata_ids'] = PhytoPhysicochemDataReport::where('product_id',$id)->pluck('phyto_physicochemdata_id')->toArray();

               $data['phyto_physicochemdata'] = PhytoPhysicochemData::all();
               $data['phyto_organoleptics'] = PhytoOrganoleptics::all();
               $data['phyto_chemicalconsts'] = PhytoChemicalConstituents::all();
               return View('admin.phyto.showreport',$data);
            }

         

            public function organoleptics_delete($p_id,$organo_id){

              $po_report = PhytoOrganolepticsReport::where('product_id',$p_id);
              if(count($po_report->get()) < 2){ 
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! This row cant be deleted, Organoleptics cant be empty '); 
                return redirect()->back();
              }
                $deleteData=PhytoOrganolepticsReport::where('phyto_organoleptics_id',$organo_id); 
                $deleteData->delete(); 
                
                Session::flash("message", "Organoleptics row deleted");
                Session::flash("message_title", "success");
                return redirect()->back();
            }

            public function physicochemdata_delete($p_id,$physico_id){

              $phy_report = PhytoPhysicochemDataReport::where('product_id',$p_id);
              if(count($phy_report->get()) < 2){ 
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! This row cant be deleted, Physicochemical Data cant be empty '); 
                return redirect()->back();
              }

              $deleteData=PhytoPhysicochemDataReport::where('phyto_physicochemdata_id',$physico_id); 
              $deleteData->delete(); 

              Session::flash("message", "Organoleptics row deleted");
              Session::flash("message_title", "success");
              return redirect()->back();
            }

            public function organoleptics_update(Request $r){
            

              if ($r->organoleptics_id == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required organoleptics.');
                return redirect()->back();
              }
              $organoleptics_name = [];
              $organoleptics_feature = [];

               foreach ($r->organoleptics_id as $key => $value) {

                if(!isset($r->{'organolepticsname_'.$value}) or $r->{'organolepticsname_'.$value}==null){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'organoleptic field is required.');
                  return redirect()->back();
                }
                if(!isset($r->{'organolepticsfeature_'.$value}) or $r->{'organolepticsfeature_'.$value}==null){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'organoleptics feature field is required.');
                  return redirect()->back();
                }
                array_push($organoleptics_name,$r->{'organolepticsname_'.$value});
                array_push($organoleptics_feature,$r->{'organolepticsfeature_'.$value});
               
              }
          
              for ($i=0; $i < count($r->organoleptics_id); $i++) { 
                    
                 PhytoOrganolepticsReport::create([
                'product_id'=>$r->product_id,
                'phyto_testconducted_id'=>$r->phyto_testconducted_1,
                'phyto_organoleptics_id'=>$r->organoleptics_id[$i],
                'name'=>$organoleptics_name[$i],
                'feature'=>$organoleptics_feature[$i], 
                'addedby_id'=> Auth::guard('admin')->id(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                ]);
                
               }

              Session::flash("message", "Ornagoleptics row added successfully.");
              Session::flash("message_title", "success");
              return redirect()->back();
            }
            
            public function physicochemdata_update(Request $r){
            
              $physicochem_name = [];
              $physicochem_result = [];

              if ($r->physicochemdata_id == null) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Please select required physicochemical data.');
                return redirect()->back();
              }

              foreach ($r->physicochemdata_id as $key => $value) {
                if(!isset($r->{'physicochemname_'.$value}) or $r->{'physicochemname_'.$value}==null){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Physicocheminal name field is required.');
                  return redirect()->back();
                }
                if(!isset($r->{'physicochemresult_'.$value}) or $r->{'physicochemresult_'.$value}==null){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Physicocheminal result field is required.');
                  return redirect()->back();
                }
                array_push($physicochem_name,$r->{'physicochemname_'.$value});
                array_push($physicochem_result,$r->{'physicochemresult_'.$value});
               
               }


              for ($i=0; $i < count($r->physicochemdata_id); $i++) { 
                    
                PhytoPhysicochemDataReport::create([
                'product_id'=>$r->product_id,
                'phyto_testconducted_id'=>$r->phyto_testconducted_2,
                'phyto_physicochemdata_id'=>$r->physicochemdata_id[$i],
                'name'=>$physicochem_name[$i],
                'result'=>$physicochem_result[$i], 
                'addedby_id'=> Auth::guard('admin')->id(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                ]);
                
               }
  
              Session::flash("message", "Physicochemical data row added successfully.");
              Session::flash("message_title", "success");
              return redirect()->back();

            }

            public function makereport_update(Request $r, $id){
          
              //  dd($r->all());
              $data = $r->validate([
              'chemicalconst' => 'required', 
               ]);
              $deleteData=PhytoChemicalConstituentsReport::where('product_id',$id); 
              $deleteData->delete(); 

              for ($i=0; $i < count($r->chemicalconst); $i++) { 
                
                PhytoChemicalConstituentsReport::create([
                'product_id'=>$id,
                'phyto_testconducted_id'=>$r->phyto_testconducted_3,
                'name'=>$r->chemicalconst[$i],
                'addedby_id'=> Auth::guard('admin')->id(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                ]);
                
               }

               $products =Product::where('id', $id)->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id", 3)->where("status", 3);
                });
                  if(count($products->get()) < 1){     
                    return redirect()->back();
                  }
                $product = $products->first();
                $product->phyto_comment = $r->comment;
                $product->phyto_hod_evaluation = 1;
                $product->phyto_dateanalysed = $r->date_analysed;
                $product->phyto_grade = $r->phyto_grade;
                $product->phyto_analysed_by = Auth::guard('admin')->id();

                $product->update();

                Session::flash("message", "Report successfully updated.");
                Session::flash("message_title", "success");
                return redirect()->back();
            }

               //***********************HoD Office */
  

               public function hodoffice_evaluation(){
              
                 $data['evaluations'] = Product::where('phyto_hod_evaluation','>',0)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 3)->where("status", 3);
                 })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
                 ->with('pchemconstReport')->whereHas('pchemconstReport')->get();

  
                 $data['withhelds'] = Product::where('phyto_hod_evaluation',1)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 3)->where("status", 3);
                 })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
                 ->with('pchemconstReport')->whereHas('pchemconstReport')->get();

                 $data['approvals'] = Product::where('phyto_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 3)->where("status", 3);
                 })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
                 ->with('pchemconstReport')->whereHas('pchemconstReport')->get();

                 $data['completeds'] = Product::where('phyto_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 3)->where("status", 4);
                 })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
                 ->with('pchemconstReport')->whereHas('pchemconstReport')->get();
    
                  return view('admin.phyto.hodoffice.evaluation',$data);
    
                }

                  public function evaluate_one_index($id){
             
                  $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 3)->where("status",3);
                   if(count($productdepts->get()) < 1){     
                     return redirect()->route('admin.phyto.hod_office.approval');
                   }  

                   $data['report_id'] = $id; 

                   $data['phytoshowreport'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                    return $q->where("dept_id", 3)->where("status",3);
                  })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
                  ->with('pchemconstReport')->whereHas('pchemconstReport')->first();
                  
                   return view('admin.phyto.hodoffice.showreport',$data);
                 }

                 public function hod_complete_report($id){

                  $data['report_id'] = $id; 
              
                  $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 3)->where("status",3);
                  if(count($productdepts->get()) < 1){     
                      return redirect()->back();
                  }
                  $productdept = $productdepts->first();
                  $productdept->status = 4;
                  $productdept->update();
      
                  $data['phytoshowreport'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                    return $q->where("dept_id", 3)->where("status",4);
                  })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
                  ->with('pchemconstReport')->whereHas('pchemconstReport')->first();

                   return view('admin.phyto.completedreport',$data);
                  }

                 public function evaluate(Request $r){

                    // dd($r->all());
                  if ($r->evaluation == null) {
                    Session::flash('message_title', 'error');
                      Session::flash('message', 'Please select options to evaluate report');
                    return redirect()->back();
                  }
                  if ($r->evaluated_product == null) {
                    Session::flash('message_title', 'error');
                      Session::flash('message', 'Please select required reports for evaluation');
                    return redirect()->back();
                  }

                  $products = Product::whereIn('id',$r->evaluated_product)->where("phyto_hod_evaluation", 2)->with('departments')->whereHas("departments", function($q){
                    return $q->where("dept_id", 3)->where("status", 3);
                  });
                  if(count($products->get()) < 1){     
                       Session::flash('message_title', 'error');
                       Session::flash('message', 'Selected product needs to be approved before completion.');
                       return redirect()->back();
                   }  
                  else{
    
                  $p_ids =  $products->pluck('id')->toArray();
                  $productdepts = ProductDept::whereIn('product_id',$p_ids)->where("dept_id", 3)->where("status",3);
                  if(count($productdepts->get()) < 1){     
                      return redirect()->back();
                  }
                  $productdepts->update(['status' => 4]);
                  }
    
                  Session::flash("message", "Report Evaluation completed.");
                  Session::flash("message_title", "success");
                
                  return redirect()->back();
                 }
                  
                 public function checkhodsign(Request $request){
             
                  $userEmail = $request->get('email');
                  $adminPassword = $request->get('password');
      
                  $checkallmail = Admin::where('email', '=', $userEmail)->first();
                  $checkmailonly = Admin::where('dept_id',3)->where('email', '=', $userEmail)->first();
                  $admin = Admin::where('dept_id',3)->where('dept_office_id',1)->where('email', '=', $userEmail)->first();
      
                  if (!$checkallmail) {
                    return response()->json(['status' => false, 'message' => "Sorry there is no such email in the system"]);
                  }
                  if (!$checkmailonly) {
                    return response()->json(['status' => false, 'message' => "Sorry This section is authorised by the head of department"]);
                  }
                  if(!$admin){
                    return response()->json(['status' => false, 'message' => "Sorry you are not authorized to sign. Contact Department Head "]);
                  }
                  if(!Hash::check($adminPassword, $admin->password)){
                    return response()->json(['status' => false, 'message' => "Invalid passowrd. Please check and sign "]);
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
                  
                  $p= Product::find($id);
                  $p->update([
                    'phyto_hod_evaluation'=> $r->evaluate,
                    'phyto_appoved_by'=>$r->adminid,
                  ]); 
                 
                  if ($p->micro_hod_evaluation == 2 && $p->pharm_hod_evaluation == 2 && $p->phyto_hod_evaluation ==2 ) {
                    $p->update(['overall_status'=> 2]);
                  }else {
                    $p->update(['overall_status'=> 1]);
                  }
                  
                 Session::flash("message", "Report Evaluation completed.");
                 Session::flash("message_title", "success");  
                 return redirect()->back();
                 }

            //*************************************************** General Report Section ************************** */\
             
             public function completedreport_show($id){
              $productdepts = ProductDept::where('product_id', $id)->where("dept_id",3)->where("status",4);
              if(count($productdepts->get()) < 1){     
               return redirect()->back(); 
               }
          
              $data['report_id'] = $id; 

              $data['phytoshowreport'] = Product::where('id',$id)->where('phyto_hod_evaluation','!=',2)->orWhereNull('phyto_hod_evaluation')->with('departments')->whereHas("departments", function($q){
               return $q->where("dept_id", 3)->where("status",'>',2);
             })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")

             ->with('pchemconstReport')->whereHas('pchemconstReport')->first();

             return view('admin.phyto.completedreport',$data);
             
          }

          
           public function generalreport_index(){
    
              $data['from_date'] = "2020-01-01";
            $data['to_date'] = now();

            $data['product_types'] = \App\ProductType::all();
            $data['year'] = \Carbon\Carbon::now('y');
   
              $data['pending_products1'] = Product::whereHas("departments", function($q)use ($data){
               return $q->where("dept_id",3)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
             })->where('phyto_hod_evaluation','<>',2)->get();
             
             $data['pending_products2'] = Product::whereHas("departments", function($q)use ($data){
               return $q->where("dept_id",3)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
             })->WhereNull("phyto_hod_evaluation")->get();
   
            $data['pending_products'] = $data['pending_products1']->merge($data['pending_products2']);

          $data['completed_products'] = Product::where('phyto_hod_evaluation', 2)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id",3)->where('status','>',2);
            })->get();

            return view('admin.phyto.generalreport.index',$data);
           }


           public function completedreports_index($id){

           $data['ptype_id'] = $id;
           $data['completed_products'] = Product::where('phyto_hod_evaluation', 2)->where('product_type_id',$id)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id",3)->where('status','>',2);
            })->get();

            return view('admin.phyto.generalreport.completedreport',$data);
           }
           
           public function pendingreports_index(Request $r, $id){
             
            $data['ptype_id'] = $id;
            $pending = Product::whereIn('id',$r->pending_product_ids)->with("departments")->whereHas("departments", function($q){
               return $q->where("dept_id",3);
             })->pluck('id')->toArray();
            
            $data['dept3'] = Department::find(3)->products()->whereIn('product_id',$pending)->with('departments')->orderBy('status')->get();
         
             return view('admin.phyto.generalreport.pendingreports',$data);
            }

           public function between_months(Request $r){


            $data = $r->all();
           
            if ($r->from_date == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required date to begin begin');
              return redirect()->route('admin.phyto.general_report.index');
             }
      
            if ($r->to_date == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required date to end report');
              return redirect()->route('admin.phyto.general_report.index');
             }
       
             $data = $r->all();
             $data['product_types'] = \App\ProductType::all();


             $data['pending_products1'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",3)->where("status", '>',1)->whereDate('product_depts.received_at', '>=', $r->from_date)->whereDate('product_depts.received_at', '<=', $r->to_date);
            })->where('phyto_hod_evaluation','<>',2)->get();
            
            $data['pending_products2'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",3)->where("status", '>',1)->whereDate('product_depts.received_at', '>=', $r->from_date)->whereDate('product_depts.received_at', '<=', $r->to_date);
            })->WhereNull("phyto_hod_evaluation")->get();
  
           $data['pending_products'] = $data['pending_products1']->merge($data['pending_products2']);

            $data['completed_products'] = Product::where('phyto_hod_evaluation', 2)->with("departments")->whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",3)->where('status','>',2)->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
             })->get();
              

            return view('admin.phyto.generalreport.index',$data);
           }

           //************************************************Phyto Configurations ************************** */

           public function hodoffice_config(){
            $data['phyto_organoleptics'] = PhytoOrganoleptics::all();
            $data['phyto_physicochemdata'] = PhytoPhysicochemData::all();
            $data['phyto_chemicalconsts'] = PhytoChemicalConstituents::all();
            
            return view('admin.phyto.hodoffice.config',$data);
           }

           public function config_organoleptics_create(Request $r){

            $data = $r->validate([
              'name' => 'required', 
              'feature' => 'required',   
            ]);

            $data = ([
              'name' => $r->name,
              'feature' => $r->feature,
              'added_by_id' => Auth::guard('admin')->id(),
             ]);
             
            PhytoOrganoleptics::create($data);
            return redirect()->route('admin.phyto.hod_office.config');

           }

           public function config_organoleptics_update (Request $r){
              
            // dd($r->all());
            if ($r->action > 2 ) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin.');
              return redirect()->back();
          } 
              if ($r->action == 0 && $r->action == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required product and submit.');
              return redirect()->back();
          } 
 
            $data = 
            [ 
            'action' => $r->action,
            'added_by_id' => Auth::guard('admin')->id(),
            'created_at' => \Carbon\Carbon::now(),
            ];
           
            PhytoOrganoleptics::whereIN('id', $r->organo_item)->update($data);
            PhytoOrganoleptics::whereNotin('id',$r->organo_item)->update(['action' =>0]);
            Session::flash("message", "Template updated successfully");
            Session::flash("message_title", "success");  
            return redirect()->back();

           }

           
           public function config_physicochemdata_create(Request $r){

           
            $data = $r->validate([
              'name' => 'required', 
              'result' => 'required',   
            ]);

            $data = ([
              'name' => $r->name,
              'result' => $r->result,
              'added_by_id' => Auth::guard('admin')->id(),
             ]);
             
             PhytoPhysicochemData::create($data);
            return redirect()->route('admin.phyto.hod_office.config');
           }

           public function config_physicochemdata_update(Request $r){
              
            if ($r->action > 2 ) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin.');
              return redirect()->back();
          } 
              if ($r->action == 0 && $r->action == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required product and submit.');
              return redirect()->back();
          } 
 
            $data = 
            [ 
            'action' => $r->action,
            'added_by_id' => Auth::guard('admin')->id(),
            'created_at' => \Carbon\Carbon::now(),
            ];
           
            PhytoPhysicochemData::whereIN('id', $r->physicochem_item)->update($data);
            PhytoPhysicochemData::whereNotin('id',$r->physicochem_item)->update(['action' =>0]);
            Session::flash("message", "Template updated successfully");
            Session::flash("message_title", "success");  
            return redirect()->back();

           }

           public function config_chemicalconsts_create(Request $r){

           
            $data = $r->validate([
              'name' => 'required', 
              'description' => 'required',   
            ]);

            $data = ([
              'name' => $r->name,
              'description' => $r->description,
              'added_by_id' => Auth::guard('admin')->id(),
             ]);
             
             PhytoChemicalConstituents::create($data);
            return redirect()->route('admin.phyto.hod_office.config');
           }

           public function config_chemicalconsts_update(Request $r){
              
            if ($r->action > 2 ) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin.');
              return redirect()->back();
          } 
              if ($r->action == 0 && $r->action == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required product and submit.');
              return redirect()->back();
          } 
 
            $data = 
            [ 
            'action' => $r->action,
            'added_by_id' => Auth::guard('admin')->id(),
            'created_at' => \Carbon\Carbon::now(),
            ];
           
            PhytoChemicalConstituents::whereIN('id', $r->chemicalconsts_item)->update($data);
            PhytoChemicalConstituents::whereNotin('id',$r->chemicalconsts_item)->update(['action' =>0]);
            Session::flash("message", "Template updated successfully");
            Session::flash("message_title", "success");  
            return redirect()->back();

           }

           public function report_delete($id){
            
            $product = Product::where('id',$id)->where('phyto_hod_evaluation','=',2)->whereHas("departments", function($q){
             return $q->where("dept_id", 3)->where("status", 3);
             })->first();
             if($product){
               Session::flash('message_title', 'error');
               Session::flash('message', 'Sorry product can not be deleted.');     
               return redirect()->back();
             }
             
             PhytoOrganolepticsReport::where('product_id',$id)->delete();
             PhytoPhysicochemDataReport::where('product_id',$id)->delete();
             PhytoChemicalConstituentsReport::where('product_id',$id)->delete();

          $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 3)->where("status",3);
          if(count($productdepts->get()) < 1){
              
              return redirect()->back();
          }
          $productdept = $productdepts->first();
          $productdept->status = 2;
          $productdept->update();
          
          $data = ([
           'phyto_hod_evaluation'=>Null,
           'phyto_dateanalysed'=>Null,
           'phyto_grade'=>Null,
           'phyto_analysed_by'=>Null,
          ]);
          Product::where('id',$id)->update($data);

          return redirect()->back();
       }
}


