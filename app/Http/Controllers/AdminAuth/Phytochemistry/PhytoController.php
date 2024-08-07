<?php

namespace App\Http\Controllers\AdminAuth\Phytochemistry;

use Illuminate\Http\Request;
use App\Http\Requests\AcceptPhytoProductRequest;
use App\Http\Controllers\Controller;
use App\Department;
use App\ProductDept;
use App\Product;
use App\ProductType;
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
use \DB;


class PhytoController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    //*********************  Receive Product ****************** */

    public function receiveproduct_index(){

          $data['dept3'] = Department::find(3)->products()->with('departments')->where('status',1)->orderBy('status')->get();

          $data['product_type_id']= 0;
          $data['product_types'] = ProductType::all();

          return View('admin.phyto.receiveproduct', $data);

    }



       public function productlist_search(Request $r){

       $data['product_type_id'] = $r->product_type_id;
       $data['product_types'] = ProductType::all();


       if ($r->date == Null) {
        $data['dept3'] = Department::find(3)->products()->with('departments')->orderBy('status')
        ->whereHas("departments", function($q)use($r){
          return $q->where("dept_id",3)->where("status",$r->status);
        })->get();
      }

       if ($r->date == 1) {
        $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));

        $data['dept3'] = Department::find(3)->products()->orderBy('status')->with('departments')
        ->whereHas("departments", function($q)use($r,$week_start){
          return $q->where("dept_id",3)->where('product_depts.created_at','>=',$week_start);
        })->get();

      if ($r->status == 1) {

          $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));

         $data['dept3'] = Department::find(3)->products()->orderBy('status')->with('departments')
          ->whereHas("departments", function($q)use($r,$week_start){
            return $q->where("dept_id",3)->where("status",$r->status)->where('product_depts.created_at','>=',$week_start);
          })->get();
        }

        if ($r->status > 1) {

          $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));

          $data['dept3'] = Department::find(3)->products()->orderBy('status')->with('departments')
          ->whereHas("departments", function($q)use($r,$week_start){
            return $q->where("dept_id",3)->where("status",$r->status)->where('product_depts.received_at','>=',$week_start);
          })->get();
        }

      }

      if ($r->date == 2){

          $month_start = date('Y-m-01 00:00:00');

          $data['dept3'] = Department::find(3)->products()->orderBy('status')->with('departments')->whereHas("departments", function($q)use($r,$month_start){
             return $q->where("dept_id",3)->where('product_depts.created_at','>=',$month_start);
           })->get();

        if ($r->status == 1) {
          $month_start = date('Y-m-01 00:00:00');

          $data['dept3'] = Department::find(3)->products()->orderBy('status')->with('departments')->whereHas("departments", function($q)use($r,$month_start){
             return $q->where("dept_id",3)->where("status",$r->status)->where('product_depts.created_at','>=',$month_start);
           })->get();
        }
        if ($r->status > 1) {
          $month_start = date('Y-m-01 00:00:00');

          $data['dept3'] = Department::find(3)->products()->orderBy('status')->with('departments')->whereHas("departments", function($q)use($r,$month_start){
             return $q->where("dept_id",3)->where("status",$r->status)->where('product_depts.received_at','>=',$month_start);
           })->get();
        }

      }
      elseif ($r->date == Null && $r->status == Null) {
        $data['dept3'] = Department::find(3)->products()->with('departments')->orderBy('status')
       ->whereHas("departments", function($q){
        return $q->where("dept_id",3);
       })->get();
       }


      return View('admin.phyto.receiveproduct', $data);
    }

    public function acceptproduct(AcceptPhytoProductRequest $request)
      {
            // dd($request->all());
            $adminId = Auth::guard('admin')->id();
            $deptproduct_id = $request->deptproduct_id;
            $status = $request->status;
            $delivered_by = $request->adminid;

              if ($status > 2 ) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin. ');
              return redirect()->route('admin.phyto.receiveproduct');
          }
              if ($deptproduct_id == 0) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required product and submit.');
              return redirect()->route('admin.phyto.receiveproduct');
          }
            $productdeptstatus = ProductDept::whereIn('product_id', $deptproduct_id)->where("dept_id", 3)->where("status", '>',2)->first();
            if ($status < (!empty($productdeptstatus->status) ? $productdeptstatus->status: '')) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Sorry Product(s) is/are now in a work process mode..');
              return redirect()->route('admin.phyto.receiveproduct');
            }


            if ($status == 1) {

              $data =
              [
              'status' => 1,
              'received_by' => Null,
              'delivered_by' => Null,
              'received_at' => Null,
              ];
            }

            if ($status == 2) {
              $data =
              [
              'status' => 2,
              'received_by' => $adminId,
              'delivered_by' => $delivered_by,
              'received_at' => \Carbon\Carbon::now(),
              ];
            }

            ProductDept::whereIN('product_id', $deptproduct_id)->where("dept_id", 3)->where("status", '<',3)->update($data);

            Session::flash('message_title', 'success');
            Session::flash('message', 'Product(s) status successfully updated ');
            return redirect()->route('admin.phyto.receiveproduct')
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
                return response()->json(['status' => false, 'message' => "Your PIN is invalid"]);
              }

              return response()->json(['status' => true, 'message' => "success", 'admin' => $admin->id]);
              // if ($user) {
              //   return redirect()->route('admin.user.microproduct', $user);
              // }

            }


             public function makereport_index(){

              $data['auth'] = Admin::where('id',Auth::guard('admin')->id())->get();
              $data['auth_id'] = Admin::where('id',Auth::guard('admin')->id())->first();

               $data['week_start'] = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));

             $data['phytoproducts'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 3)->where("status", 2);
              })->orderBy('id', 'desc')->get();

             //********************* section for authusers who perform repot ***** */
            $data['auth_phytoreports'] = Product::where('phyto_analysed_by',Auth::guard('admin')->id())->with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 3)->where("status", 3);
             })->orderBy('phyto_hod_evaluation', 'asc')->get();
             //********************* section for the dept offcie only ***** */
             $data['phytoreports'] = Product::with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 3)->where("status", 3);
             })->orderBy('phyto_hod_evaluation', 'asc')->get();

             $data['phytocompleted_reports'] = Product::with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 3)->where("status", 4);
             })->limit(99)->get();

              $data['phyto_testconducted'] = PhytoTestConducted::all();

              $admin_organolepticts_options = json_decode(Admin::findOrFail(Auth::guard("admin")->id())->organolepticts_options);
              $admin_physicochemical_options= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->physicochemical_options);
              $admin_chemicalconsts_options= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->chemical_constituents_options);


               $data['phyto_organoleptics_admin'] = PhytoOrganoleptics::whereIn('id',$admin_organolepticts_options)->get();
               $data['phyto_physicochemdata_admin'] = PhytoPhysicochemData::whereIn('id',$admin_physicochemical_options)->get();
               $data['phyto_chemicalconsts_admin'] = PhytoChemicalConstituents::whereIn('id',$admin_chemicalconsts_options)->get();

               $withheld_notify = Product::where('phyto_hod_evaluation',1)->where('phyto_analysed_by',Auth::guard('admin')->id())->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 3)->where("status", 3);
               })->count();

               if ($withheld_notify > 0 ) {
                Session::flash('warning', 'Info');
                Session::flash('message', 'You have '.$withheld_notify.' report(s) withheld. Please check and resubmit for evaluation');
               }

              return View('admin.phyto.createreport', $data);
            }

            public function makereport_create(Request $r){

              // dd($r->all());
              $products =Product::where('id', $r->product_id)->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id", 3)->where("status", 2);
                });
                  if(count($products->get()) < 1){
                    Session::flash('message_title', 'error');
                    Session::flash('message', ' test error detected');
                    return redirect()->back();
               }
              $checkifexist = PhytoOrganolepticsReport::where('product_id',$r->product_id)->get();
              if (count( $checkifexist) >0) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Multiple test entry error');
                return redirect()->back();

              }
              $checkifexist = PhytoPhysicochemDataReport::where('product_id',$r->product_id)->get();
              if (count( $checkifexist) >0) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Multiple test entry error');
                return redirect()->back();

              }
              $checkifexist = PhytoChemicalConstituentsReport::where('product_id',$r->product_id)->get();
              if (count( $checkifexist) >0) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Multiple test entry error');
                return redirect()->back();

              }

              $date_analysed = (\Carbon\Carbon::parse($r->date_analysed));

              if ($date_analysed > \Carbon\Carbon::now()) {
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
              $organoleptics_roworder = [];

              $physicochem_name = [];
              $physicochem_result = [];
              $physicochem_unit = [];
              $physicochem_location = [];
              $physicochem_roworder = [];


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
              array_push($organoleptics_roworder,$r->{'organolepticsroworder_'.$value});


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
              if(!isset($r->{'physicochemdata_location_'.$value}) or $r->{'physicochemdata_location_'.$value}==null){
                Session::flash('message_title', 'error');
                Session::flash('message', 'System Error Physicocheminal location field is required.');
                return redirect()->back();
              }
              array_push($physicochem_name,$r->{'physicochemname_'.$value});
              array_push($physicochem_result,$r->{'physicochemresult_'.$value});
              array_push($physicochem_unit,$r->{'physicochemunit_'.$value});
              array_push($physicochem_location,$r->{'physicochemdata_location_'.$value});
              array_push($physicochem_roworder,$r->{'physicochemdata_roworder_'.$value});

             }

            $productdepts = ProductDept::where('product_id',$r->product_id)->where("dept_id", 3)->where("status",2)->update(['status' => 3]);

            $inprogressproducts =Product::where('id', $r->product_id)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id", 3)->where("status", 3);
              });
                if(count($inprogressproducts->get()) < 1){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'System Error .');
                  return redirect()->back();
             }

            for ($i=0; $i < count($r->organoleptics_id); $i++) {

               PhytoOrganolepticsReport::create([
              'product_id'=>$r->product_id,
              'phyto_testconducted_id'=>$r->phyto_testconducted_1,
              'phyto_organoleptics_id'=>$r->organoleptics_id[$i],
              'name'=>$organoleptics_name[$i],
              'feature'=>$organoleptics_feature[$i],
              'roworder'=>$organoleptics_roworder[$i],
              'addedby_id'=> Auth::guard('admin')->id(),
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now(),
              ]);

             }


            for ($i=0; $i < count($r->physicochemdata_id); $i++) {


              PhytoPhysicochemDataReport::create([
              'product_id'=>$r->product_id,
              'phyto_testconducted_id'=>$r->phyto_testconducted_2,
              'phyto_physicochemdata_id'=>$r->physicochemdata_id[$i],
              'name'=>$physicochem_name[$i],
              'result'=>$physicochem_result[$i],
              'unit'=>$physicochem_unit[$i],
              'location'=>$physicochem_location[$i],
              'roworder'=>$physicochem_roworder[$i],
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

              $product = $inprogressproducts->first();
              $product->phyto_comment = $r->comment;
              $product->phyto_dateanalysed = $date_analysed;
              $product->phyto_grade = $r->phyto_grade;
              $product->phyto_hod_evaluation = Null;
              $product->phyto_analysed_by = Auth::guard('admin')->id();
              $product->update();

              Session::flash("message", "Report successfully created.");
              Session::flash("message_title", "success");
              return redirect()->back();
            }

            public function makereport_show ($id){
              // return Product::find($id);
               $phytoshowreport = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 3)->where("status", 3);
               })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
               ->with('pchemconstReport')->whereHas('pchemconstReport');

               if(count($phytoshowreport->get()) < 1){
                return redirect()->back();
               }
               $data['report_id'] = $id;

               $data['phyto_physicochreport'] = PhytoPhysicochemDataReport::where('product_id',$id)->orderBy('roworder')->get();
               $data['phyto_organolepticsreport'] = PhytoOrganolepticsReport::where('product_id',$id)->orderBy('roworder')->get();
               $data['phyto_chemicalconstsreport'] = PhytoChemicalConstituentsReport::where('product_id',$id)->get();

              $data['organoleptics_ids'] = PhytoOrganolepticsReport::where('product_id',$id)->pluck('phyto_organoleptics_id')->toArray();
              $data['physicochemdata_ids'] = PhytoPhysicochemDataReport::where('product_id',$id)->pluck('phyto_physicochemdata_id')->toArray();
              $data['organoleptics_roworder'] = PhytoOrganolepticsReport::where('product_id',$id)->pluck('roworder')->toArray();
              $data['physicochemdata_roworder'] = PhytoPhysicochemDataReport::where('product_id',$id)->pluck('roworder')->toArray();

              $admin_organolepticts_options = json_decode(Admin::findOrFail(Auth::guard("admin")->id())->organolepticts_options);
              $admin_physicochemical_options= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->physicochemical_options);
              $admin_chemicalconsts_options= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->chemical_constituents_options);

               $data['phyto_organoleptics'] = PhytoOrganoleptics::whereIn('id',$admin_organolepticts_options)->get();
               $data['phyto_physicochemdata'] = PhytoPhysicochemData::whereIn('id',$admin_physicochemical_options)->get();
               $data['phyto_chemicalconsts'] = PhytoChemicalConstituents::whereIn('id',$admin_chemicalconsts_options)->get();

               return View('admin.phyto.showreport',$data);
            }



            public function organoleptics_delete($p_id,$organo_id){

              $po_report = PhytoOrganolepticsReport::where('product_id',$p_id);
              if(count($po_report->get()) < 2){
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry! This row cant be deleted, Organoleptics cant be empty ');
                return redirect()->back();
              }
                $deleteData=PhytoOrganolepticsReport::where('product_id',$p_id)->where('id',$organo_id);
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

              $deleteData=PhytoPhysicochemDataReport::where('product_id',$p_id)->where('id',$physico_id);
              $deleteData->delete();

              Session::flash("message", "Physicochemical row deleted");
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
              $organoleptics_roworder = [];

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
                array_push($organoleptics_roworder,$r->{'organolepticsroworder_'.$value});


              }

              for ($i=0; $i < count($r->organoleptics_id); $i++) {

                 PhytoOrganolepticsReport::create([
                'product_id'=>$r->product_id,
                'phyto_testconducted_id'=>$r->phyto_testconducted_1,
                'phyto_organoleptics_id'=>$r->organoleptics_id[$i],
                'name'=>$organoleptics_name[$i],
                'feature'=>$organoleptics_feature[$i],
                'roworder'=>$organoleptics_roworder[$i],
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

              // dd($r->all());
              $physicochem_name = [];
              $physicochem_result = [];
              $physicochem_unit = [];
              $physicochem_location = [];
              $physicochem_roworder = [];



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

                if(!isset($r->{'physicochemdata_location_'.$value}) or $r->{'physicochemdata_location_'.$value}==null){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'System Error Physicochemical location field is required.');
                  return redirect()->back();
                }
                array_push($physicochem_name,$r->{'physicochemname_'.$value});
                array_push($physicochem_result,$r->{'physicochemresult_'.$value});
                array_push($physicochem_unit,$r->{'physicochemunit_'.$value});
                array_push($physicochem_location,$r->{'physicochemdata_location_'.$value});
                array_push($physicochem_roworder,$r->{'physicochemdata_roworder_'.$value});

               }



              for ($i=0; $i < count($r->physicochemdata_id); $i++) {

                PhytoPhysicochemDataReport::create([
                'product_id'=>$r->product_id,
                'phyto_testconducted_id'=>$r->phyto_testconducted_2,
                'phyto_physicochemdata_id'=>$r->physicochemdata_id[$i],
                'name'=>$physicochem_name[$i],
                'result'=>$physicochem_result[$i],
                'unit'=>$physicochem_unit[$i],
                'location'=>$physicochem_location[$i],
                'roworder'=>$physicochem_roworder[$i],
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
                // return Product::find($id);
                // dd($r->all());



              if ($r->savereport) {

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

                $data = $r->validate([
                  'phyto_grade' => 'required',
                  'comment' => 'required',
                ]);

                if ($r->organoleptics_id) {
                  $l = 0;
                  $count1 = count($r->organoleptics_id);
                  while($l < $count1){
                  DB::table('phyto_organoleptics_reports')->where('id', $r->organoleptics_id[$l])
                        ->update([
                          'name' => $r->organolepticsname[$l],
                          'feature' => $r->organolepticsfeature[$l],
                          'roworder' => $r->organolepticsroworder[$l],
                          'updated_at' => \Carbon\Carbon::now(),
                        ]
                        );
                    $l++;
                  }
                }

                if ($r->physicochemdata_id){
                  $l = 0;
                  $count1 = count($r->physicochemdata_id);
                  while($l < $count1){
                  DB::table('phyto_physicochem_data_reports')->where('id', $r->physicochemdata_id[$l])
                        ->update([
                          'name' => $r->physicochemname[$l],
                          'result' => $r->physicochemresult[$l],
                          'unit' => $r->physicochemunit[$l],
                          'roworder' => $r->physicochemroworder[$l],
                          'updated_at' => \Carbon\Carbon::now(),
                        ]
                        );
                    $l++;
                  }
                }

                if ($r->chemicalconst) {
                    $data = $r->validate([
                    'chemicalconst' => 'required',
                     ]);
                    // $const = PhytoChemicalConstituentsReport::where('product_id',$id)->whereIn('name',$r->chemicalconst)->get();
                    //  if (count($const->get()) < 1) {
                    //  }
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
                }



               $products =Product::where('id', $id)->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id", 3)->where("status", 3);
                });
                  if(count($products->get()) < 1){
                    return redirect()->back();
                  }

                $product = $products->first();
                $product->phyto_comment = $r->comment;
                $product->phyto_dateanalysed = $r->date_analysed;
                $product->phyto_grade = $r->phyto_grade;
                $product->update();

                $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 3)->where("status",3);
                $productdept = $productdepts->first();
                $productdept->received_at = $r->date_received;
                $productdept->update();
              }


                if ($r->complete_report) {
                  $products =Product::where('id', $id)->with("departments")->whereHas("departments", function($q){
                    return $q->where("dept_id", 3)->where("status", 3);
                    });
                      if(count($products->get()) < 1){
                        return redirect()->back();
                      }
                    $product = $products->first();
                    $product->phyto_hod_evaluation = 0;
                    $product->phyto_approved_by = $r->adminid;

                    $product->update();

                }

                Session::flash("message", "Report successfully updated.");
                Session::flash("message_title", "success");
                return redirect()->back();
            }

               //***********************HoD Office */


               public function hodoffice_evaluation(){

                //  $evaluations = Product::where('phyto_hod_evaluation',0)->with('departments')->whereHas("departments", function($q){
                //   return $q->where("dept_id", 3)->where("status",'<', 3);
                //  })->pluck('id')->toArray();

                //    Product::whereIn('id', $evaluations)->update(['phyto_hod_evaluation' => Null]);
                //    return $evaluations;

                  $data['evaluations'] = Product::where('phyto_hod_evaluation','>=',0)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 3)->where("status", 3);
                 })->get();

                 $data['withhelds'] = Product::where('phyto_hod_evaluation',1)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 3)->where("status", 3);
                 })->get();

//                 $data['approvals'] = Product::where('phyto_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
//                  return $q->where("dept_id", 3)->where("status", 3);
//                 })->get();

//                 $data['completeds'] = Product::where('phyto_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
//                  return $q->where("dept_id", 3)->where("status", 4);
//                 })->get();
                  return view('admin.phyto.hodoffice.evaluation',$data);

                }

                  public function evaluate_one_index($id){

                  $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 3)->where("status",3);
                   if(count($productdepts->get()) < 1){
                     return redirect()->route('admin.phyto.hod_office.approval');
                   }

                   $data['report_id'] = $id;

                   $data['evaluations'] = Product::where('phyto_hod_evaluation','>=',0)->with('departments')->whereHas("departments", function($q){
                    return $q->where("dept_id", 3)->where("status", 3);
                   })->get();

                  $phytoshowreport = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                    return $q->where("dept_id", 3)->where("status", 3);
                   })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
                   ->with('pchemconstReport')->whereHas('pchemconstReport');

                   if(count($phytoshowreport->get()) < 1){
                    return redirect()->back();
                   }
                   $data['report_id'] = $id;
                   $data['phyto_physicochreport'] = PhytoPhysicochemDataReport::where('product_id',$id)->orderBy('roworder')->get();
                   $data['phyto_organolepticsreport'] = PhytoOrganolepticsReport::where('product_id',$id)->orderBy('roworder')->get();
                   $data['phyto_chemicalconstsreport'] = PhytoChemicalConstituentsReport::where('product_id',$id)->get();



                  $data['organoleptics_ids'] = PhytoOrganolepticsReport::where('product_id',$id)->pluck('phyto_organoleptics_id')->toArray();
                  $data['physicochemdata_ids'] = PhytoPhysicochemDataReport::where('product_id',$id)->pluck('phyto_physicochemdata_id')->toArray();
                  $data['physicochemdata_roworder'] = PhytoPhysicochemDataReport::where('product_id',$id)->pluck('roworder')->toArray();
                  $data['organoleptics_roworder'] = PhytoOrganolepticsReport::where('product_id',$id)->pluck('roworder')->toArray();

                  $admin_organolepticts_options = json_decode(Admin::findOrFail(Auth::guard("admin")->id())->organolepticts_options);
                  $admin_physicochemical_options= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->physicochemical_options);
                  $admin_chemicalconsts_options= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->chemical_constituents_options);

                   $data['phyto_organoleptics'] = PhytoOrganoleptics::whereIn('id',$admin_organolepticts_options)->get();
                   $data['phyto_physicochemdata'] = PhytoPhysicochemData::whereIn('id',$admin_physicochemical_options)->get();
                   $data['phyto_chemicalconsts'] = PhytoChemicalConstituents::whereIn('id',$admin_chemicalconsts_options)->get();


//
//                 $data['withhelds'] = Product::where('phyto_hod_evaluation',1)->with('departments')->whereHas("departments", function($q){
//                  return $q->where("dept_id", 3)->where("status", 3);
//                 })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
//                 ->with('pchemconstReport')->whereHas('pchemconstReport')->get();
//
//                 $data['approvals'] = Product::where('phyto_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
//                  return $q->where("dept_id", 3)->where("status", 3);
//                 })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
//                 ->with('pchemconstReport')->whereHas('pchemconstReport')->get();
//
//                 $data['completeds'] = Product::where('phyto_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
//                  return $q->where("dept_id", 3)->where("status", 4);
//                 })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
//                 ->with('pchemconstReport')->whereHas('pchemconstReport')->get();

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

                  Product::where('id',$id)->update(['phyto_reportdatecompleted' => \Carbon\Carbon::now()]);

                  $data['phytoshowreport'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
                    return $q->where("dept_id", 3)->where("status",4);
                  })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
                  ->with('pchemconstReport')->whereHas('pchemconstReport')->first();

                  Session::flash("message", "Report Evaluation completed.");
                  Session::flash("message_title", "success");
                  return redirect()->back();
                  }

                 public function evaluate(Request $r){


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
                  Product::whereIn('id',$r->evaluated_product)->update(['phyto_reportdatecompleted' => \Carbon\Carbon::now()]);

                  Session::flash("message", "Report Evaluation completed.");
                  Session::flash("message_title", "success");

                  return redirect()->back();
                  }

                 }

                 public function checkhodsign(Request $request){

                  $userEmail = $request->get('email');
                  $adminPin  = $request->get('pin');

                  $checkallmail  = Admin::where('email', '=', $userEmail)->first();
                  $checkmailonly = Admin::where('dept_id',3)->where('email', '=', $userEmail)->first();
                  $admin = Admin::where('dept_id',3)->where('dept_office_id',1)->where('email', '=', $userEmail)->first();

                  if (!$checkallmail) {
                    return response()->json(['status' => false, 'message' => "Sorry there is no such email in the system"]);
                  }
                  if (!$checkmailonly) {
                    return response()->json(['status' => false, 'message' => "Sorry This section is authorised by recognised and approved staffs"]);
                  }
                  if(!$admin){
                    return response()->json(['status' => false, 'message' => "Sorry you are not authorized to sign. Contact Department Head "]);
                  }
                  if(!Hash::check($adminPin, $admin->pin)){
                    return response()->json(['status' => false, 'message' => "Invalid PIN. Please check and sign "]);
                  }

                  return response()->json(['status' => true, 'message' => "success", 'admin' => $admin->id]);

                }

                public function checkanalystsign(Request $request){

                  $userEmail = $request->get('email');
                  $adminPin = $request->get('pin');

                  $checkallmail = Admin::where('email', '=', $userEmail)->first();
                  $checkmailonly = Admin::where('dept_id',3)->where('email', '=', $userEmail)->first();
                  $admin = Admin::where('dept_id',3)->where('dept_office_id',2)->where('email', '=', $userEmail)->first();

                  if (!$checkallmail) {
                    return response()->json(['status' => false, 'message' => "Sorry there is no such email in the system"]);
                  }
                  if (!$checkmailonly) {
                    return response()->json(['status' => false, 'message' => "Sorry This section is authorised by recognised and approved staffs"]);
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

                  $p= Product::find($id);
                  $p->update([
                    'phyto_hod_evaluation'=> $r->evaluate,
                    'phyto_finalapproved_by'=>$r->adminid,
                    'phyto_finaldateapproved'=>\Carbon\Carbon::now(),
                  ]);

                  if ($r->evaluate ==1) {
                    $p->update([
                      'phyto_finalapproved_by'=> Null,
                      'overall_status'=> 1,
                      'phyto_finaldateapproved'=>Null,
                      ]);
                     }

                  if ($r->evaluate ==2) {
                    $complete = ($p->micro_hod_evaluation + $p->pharm_hod_evaluation + $p->phyto_hod_evaluation);

                     if ($p->single_multiple_lab == Null) {
                       if ($complete == 6 ) {
                         $p->update(['overall_status'=> 2]);
                       }else {
                         $p->update(['overall_status'=> 1]);
                       }
                     }

                     if ($p->single_multiple_lab == 1) {
                       if ($complete == 2 ) {
                         $p->update(['overall_status'=> 2]);
                       }else {
                         $p->update(['overall_status'=> 1]);
                       }
                     }

                     if ($p->single_multiple_lab == 2) {

                       if ($complete == 4 ) {
                         $p->update(['overall_status'=> 2]);
                       }else {
                         $p->update(['overall_status'=> 1]);
                       }
                     }
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

              //*************************************************** General Report Section ************************** */\


             public function completedreport_show($id){

              $productdepts = ProductDept::where('product_id', $id)->where("dept_id",3)->where("status",4);
              if(count($productdepts->get()) < 1){
               return redirect()->back();
               }

              $data['report_id'] = $id;

              $data['phytoshowreport'] = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
               return $q->where("dept_id", 3)->where("status",'>',2);
             })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")

             ->with('pchemconstReport')->whereHas('pchemconstReport')->first();

             return view('admin.phyto.completedreport',$data);

          }


           public function generalreport_index(){

            $data['from_date'] = "2020-01-01";
            $data['to_date'] = now();

            $data['product_types'] = \App\ProductType::all();
            $data['year'] = \Carbon\Carbon::now()->year;


            $data['all_product_lab'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",3)->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
            })->get();

            $data['all_pending_products'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",3)->where("status",1)->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
            })->get();

            $data['all_recieved_products'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",3)->where("status",'>',1)->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
            })->get();


              $data['pending_products1'] = Product::whereHas("departments", function($q)use ($data){
               return $q->where("dept_id",3)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
             })->where('phyto_hod_evaluation','<>',2)->get();

             $data['pending_products2'] = Product::whereHas("departments", function($q)use ($data){
               return $q->where("dept_id",3)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
             })->WhereNull("phyto_hod_evaluation")->get();

            $data['pending_products'] = $data['pending_products1']->merge($data['pending_products2']);

           $data['completed_products'] = Product::where('phyto_hod_evaluation', 2)->with("departments")->whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",3)->where('status','>',2)->whereRaw('YEAR(received_at)= ?', array($data['year']));
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

             $data['all_product_lab'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",3)->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
            })->get();

            $data['all_pending_products'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",3)->where("status",1)->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
            })->get();

            $data['all_recieved_products'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",3)->where("status",'>',1)->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
            })->get();



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


            public function completedreports_all(){

              $data['year'] = \Carbon\Carbon::now()->year;

              $data['all_completed_products'] = Product::where('phyto_hod_evaluation',2)->with('departments')->whereHas("departments", function($q)use($data){
                return $q->where("dept_id", 3)->where("status", 4)->whereRaw('YEAR(product_depts.created_at)= ?', array($data['year']));
               })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
               ->with('pchemconstReport')->whereHas('pchemconstReport')->get();


               return view('admin.phyto.generalreport.allcompletedreports',$data);
            }


           //************************************************Phyto Configurations ************************** */

           public function hodoffice_config(){

            $admin_organolepticts_options = json_decode(Admin::findOrFail(Auth::guard("admin")->id())->organolepticts_options);
            $admin_physicochemical_options= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->physicochemical_options);
            $admin_chemicalconsts_options= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->chemical_constituents_options);


            $data['phyto_organoleptics'] = PhytoOrganoleptics::all();
           $data['phyto_organoleptics_admin'] = PhytoOrganoleptics::whereIn('id',$admin_organolepticts_options)->get();

            $data['phyto_physicochemdata'] = PhytoPhysicochemData::all();
           $data['phyto_physicochemdata_admin'] = PhytoPhysicochemData::whereIn('id',$admin_physicochemical_options)->get();

            $data['phyto_chemicalconsts'] = PhytoChemicalConstituents::all();
           $data['phyto_chemicalconsts_admin'] = PhytoChemicalConstituents::whereIn('id',$admin_chemicalconsts_options)->get();

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
              if ($r->action == 0 || $r->action == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select feature product and submit.');
              return redirect()->back();
          }


          if ($r->action == 1) {

            if ($r->organo_item == NULL) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select Organolepticts feature to activate.');
              return redirect()->back();
            }
            $admin = Admin::findOrFail(Auth::guard('admin')->id());
            $admin->organolepticts_options = json_encode($r->get("organo_item"));
            $admin->save();
            $data =
            [
            'action' => $r->action,
            'added_by_id' => Auth::guard('admin')->id(),
            'updated_at' => \Carbon\Carbon::now(),
            ];
            PhytoOrganoleptics::whereIN('id', $r->organo_item)->update($data);
            PhytoOrganoleptics::whereNotin('id',$r->organo_item)->update(['action' =>0]);
           }

           if($r->action ==2){


            $l = 0;
            $count1 = count($r->organo_item_id);
            while($l < $count1){
            DB::table('phyto_organoleptics')->where('id', $r->organo_item_id[$l])
                  ->update([
                    'name' => $r->name[$l],
                    'feature' => $r->feature[$l],
                    'action'=> 1,
                    'added_by_id'=> Auth::guard('admin')->id(),
                  ]
                  );
              $l++;
            }
          }
            Session::flash("message", "Organoleptics Template updated successfully");
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
              'unit' => $r->unit,
              'location' => $r->location,


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

          if ($r->action == 1) {

            if ($r->physicochem_item == NULL) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select Physicochemical feature(s) to activate.');
              return redirect()->back();
            }

            $admin = Admin::findOrFail(Auth::guard('admin')->id());
            $admin->physicochemical_options = json_encode($r->get("physicochem_item"));
            $admin->save();
            $data =
            [
            'action' => $r->action,
            'added_by_id' => Auth::guard('admin')->id(),
            'updated_at' => \Carbon\Carbon::now(),
            ];

            PhytoPhysicochemData::whereIN('id', $r->physicochem_item)->update($data);
            PhytoPhysicochemData::whereNotin('id',$r->physicochem_item)->update(['action' =>0]);
            Session::flash("message", "Selected features activated successfully");
            Session::flash("message_title", "success");
            return redirect()->back();
           }

           if($r->action ==2){

            $l = 0;
            $count = count($r->physicochem_item_id);
            while($l < $count){
            DB::table('phyto_physicochem_data')->where('id', $r->physicochem_item_id[$l])
                  ->update([
                    'name' => $r->name[$l],
                    'result' => $r->result[$l],
                    'unit' => $r->unit[$l],
                    'action'=> 1,
                    'added_by_id'=> Auth::guard('admin')->id(),
                  ]
                  );
              $l++;
            }
            Session::flash("message", "Template updated successfully");
            Session::flash("message_title", "success");
            return redirect()->back();
          }

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
              // dd($r->all());
            if ($r->action > 2 ) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin.');
              return redirect()->back();
          }
              if ($r->action == 0 && $r->action == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required feature and submit.');
              return redirect()->back();
          }

          if ($r->action ==1) {

            if ($r->chemicalconsts_item == NULL) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select Phytochemical Constituents feature(s) to activate.');
              return redirect()->back();
            }

            $admin = Admin::findOrFail(Auth::guard('admin')->id());
            $admin->chemical_constituents_options = json_encode($r->get("chemicalconsts_item"));
            $admin->save();
            $data =
            [
            'action' => $r->action,
            'added_by_id' => Auth::guard('admin')->id(),
            'updated_at' => \Carbon\Carbon::now(),
            ];

            PhytoChemicalConstituents::whereIN('id', $r->chemicalconsts_item)->update($data);
            PhytoChemicalConstituents::whereNotin('id',$r->chemicalconsts_item)->update(['action' =>0]);
            Session::flash("message", "Selected features activated successfully");
            Session::flash("message_title", "success");
            return redirect()->back();
           }


           if($r->action ==2){
            $l = 0;
            $count = count($r->chemicalconsts_item_id);
            while($l < $count){
            DB::table('phyto_chemical_constituents')->where('id', $r->chemicalconsts_item_id[$l])
                  ->update([
                    'name' => $r->name[$l],
                    'description' => $r->description[$l],
                    'action'=> 1,
                    'added_by_id'=> Auth::guard('admin')->id(),
                  ]
                  );
              $l++;
            }
            Session::flash("message", "Template updated successfully");
            Session::flash("message_title", "success");
            return redirect()->back();
          }

           }

           public function report_delete($id){

            $product = Product::where('id',$id)->where('phyto_hod_evaluation',0)->whereHas("departments", function($q){
             return $q->where("dept_id", 3)->where("status", 3);
             })->first();

             if($product){
               Session::flash('message_title', 'error');
               Session::flash('message', 'Sorry product under evaluation and can not be deleted. Thank You');
               return redirect()->back();
             }
             $product = Product::where('id',$id)->where('phyto_hod_evaluation',2)->whereHas("departments", function($q){
              return $q->where("dept_id", 3)->where("status", 3);
              })->first();
              if($product){
                Session::flash('message_title', 'error');
                Session::flash('message', 'Sorry product under final evaluation and can not be deleted. Thank You');
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
           'phyto_approved_by'=>Null,
           'phyto_finalapproved_by'=>Null,
           'phyto_datecompleted'=>Null,
           'phyto_finaldateapproved'=>Null,
           'phyto_dateapproved'=>Null,
           'phyto_comment'=>Null,
           'phyto_analysed_by'=>Null,
           'phyto_hod_remarks'=>Null,
          ]);

          Product::where('id',$id)->update($data);

          Session::flash("message", "Report deleted successfully");
            Session::flash("message_title", "success");
          return redirect()->back();
       }

       public function phytoreport_pdf ($id){

        $phytoshowreport = Product::where('id',$id)->with('departments')->whereHas("departments", function($q){
          return $q->where("dept_id", 3)->where("status", 4);
         })->with('organolipticReport')->whereHas("organolipticReport")->with('pchemdataReport')->whereHas("pchemdataReport")
         ->with('pchemconstReport')->whereHas('pchemconstReport');

         if(count($phytoshowreport->get()) < 1){
          Session::flash('message_title', 'error');
          Session::flash('message', 'Sorry report can not be downloaded. Report must be completed by the Hod');
          return redirect()->back();
         }

         $data['report_id'] = $id;
         $p = Product::Find($id);
         $code =   str_replace('/', '_', $p->code);
            $auth = Admin::Find(Auth::guard('admin')->id());
            $date =  str_replace('-', '_', \Carbon\Carbon::now()->format('d_m_y h'));
            $period = str_replace(':', '_', $date);

         $data['phyto_physicochreport'] = PhytoPhysicochemDataReport::where('product_id',$id)->orderBy('roworder')->get();
         $data['phyto_organolepticsreport'] = PhytoOrganolepticsReport::where('product_id',$id)->orderBy('roworder')->get();
         $data['phyto_chemicalconstsreport'] = PhytoChemicalConstituentsReport::where('product_id',$id)->get();


        // Send data to the view using loadView function of PDF facade

        $pdf = \PDF::loadView('admin.phyto.downloads.report',$data);
        $pdf->save(storage_path('pdf\phyto\phytoreport').'_'.$code.'_'.$auth->full_name.'_'.$period.'.pdf');

        return $pdf->download('phytoreport_'.$p->code.'.pdf');

        // return view('admin.micro.downloads.report',$data);


       }
}


