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
              
             $data['phytoreports'] = Product::with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 3)->where("status", 3);
             })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
             ->with('pchemconstReport')->whereHas('pchemconstReport')->get();

              $data['phyto_testconducted'] = PhytoTestConducted::all();
              $data['phyto_physicochemdata'] = PhytoPhysicochemData::all();
              $data['phyto_organoleptics'] = PhytoOrganoleptics::all();
              $data['phyto_chemicalconst'] = PhytoChemicalConstituents::all();

              return View('admin.phyto.createreport', $data); 
            }

            public function makereport_create(Request $r){

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
              $product->phyto_dateanalysed = $r->date_analysed;
              $product->update();

              Session::flash("message", "Report successfully created.");
              Session::flash("message_title", "success");
              return redirect()->back();
            }

            public function makereport_show ($id){

               $data['phytoshowreport'] = Product::with('departments')->whereHas("departments", function($q){
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

         

            public function organoleptics_delete($id){

                $deleteData=PhytoOrganolepticsReport::where('phyto_organoleptics_id',$id); 
                $deleteData->delete(); 

                Session::flash("message", "Organoleptics row deleted");
                Session::flash("message_title", "success");
                return redirect()->back();
            }

            public function physicochemdata_delete($id){

              $deleteData=PhytoPhysicochemDataReport::where('phyto_physicochemdata_id',$id); 
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
                $product->update();

                Session::flash("message", "Report successfully updated.");
                Session::flash("message_title", "success");
                return redirect()->back();
            }
}

