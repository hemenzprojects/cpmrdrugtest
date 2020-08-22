<?php

namespace App\Http\Controllers\AdminAuth\Microbiology;

use Illuminate\Http\Request;
use App\Http\Requests\AcceptMircoProductRequest;
use App\Http\Controllers\Controller;
use App\Department;
use App\ProductDept;
use App\Product;
use App\Admin;
use App\MicrobialLoadReport;
use App\MicrobialEfficacyReport;
use App\MicrobialEfficacyAnalyses;
use App\MicrobialLoadAnalyses;
use \Session;
use \Hash;
use \Auth;
use \DB;


class MicroController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    //********************* Micro Receive Product ****************** */

    public function receiveproduct_index(){
          
          $data['dept1'] = Department::find(1)->products()->get();

          return View('admin.micro.receiveproduct', $data); 

    }

    public function acceptproduct(AcceptMircoProductRequest $request)
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

            $productdeptstatus = ProductDept::whereIn('id', $deptproduct_id)->where("dept_id", 1)->where("status",  3)->first();
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
      
            ProductDept::whereIN('product_id', $deptproduct_id)->where("dept_id", 1)->update($data);
            
            Session::flash('message_title', 'success');
            Session::flash('message', 'Product(s) status successfully updated ');
            return redirect()->route('admin.micro.receiveproduct')
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

           //********************* Micro Report Processes ****************** */

              public function report_create(){
               
                $data['MicrobialLoadAnalysis'] = MicrobialLoadAnalyses::all();
                $data['MicrobialEfficacyAnalysis'] = MicrobialEfficacyAnalyses::all();

                $data['microproducts'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 2);
                })->with('loadAnalyses')->whereDoesntHave("loadAnalyses")->with('efficacyAnalyses')->whereDoesntHave("efficacyAnalyses")->orderBy('id','DESC')->get();

                $data['microproduct_withtests'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
    
                return View('admin.micro.createreport', $data); 
              }

              public function test_create(Request $r){
                // return $r->all();
                if($r->loadanalyses){
                  for ($i=0; $i < count($r->result); $i++) { 
                    if ($i<2) {
                      $results= explode(' ',$r->result[$i]);
                      $part1 =$results[0];
                      $part2 = explode('^',$results[2]);
                      $total = $part1 * pow($part2[0],$part2[1]);

                      $criterial= explode(' ',$r->acceptance_criterion[$i]);
                      $res =$criterial[0];
                      $res2 = explode('^',$criterial[2]);
                      $cri_total = $res * pow($res2[0],$res2[1]);

                      \App\MicrobialLoadReport::create(['test_conducted'=>$r->test_conducted[$i],'product_id'=>$r->micro_product_id,'rs_total'=>$total,'result'=>$r->result[$i],'acceptance_criterion'=>$r->acceptance_criterion[$i],'ac_total'=>$cri_total,
                      'added_by_id' => Auth::guard('admin')->id(),'load_analyses_id'=>$r->loadanalyses]);
                    }else{
                      \App\MicrobialLoadReport::create(['test_conducted'=>$r->test_conducted[$i],'product_id'=>$r->micro_product_id,'result'=>$r->result[$i],'acceptance_criterion'=>$r->acceptance_criterion[$i],
                      'added_by_id' => Auth::guard('admin')->id(),'load_analyses_id'=>$r->loadanalyses]);

                    }
                  }
                }

                if($r->efficacyanalyses){
                  for ($j=0; $j < count($r->pi_zone); $j++) { 
                    \App\MicrobialEfficacyReport::create(['efficacy_analyses_id'=>$r->efficacyanalyses,
                    'product_id'=>$r->micro_product_id,'pathogen '=>$r->pathogen[$j],'pi_zone'=>$r->pi_zone[$j],
                    'ci_zone'=>$r->ci_zone[$j],'fi_zone'=>$r->fi_zone[$j],'added_by_id' => Auth::guard('admin')->id()]);
                  }
                }
                   Session::flash("message", "Report Successfully Stored, Proceed to complete.");
                  Session::flash("message_title", "success");
                  return redirect()->route('admin.micro.report.create');
                // die();
          
                //   $data = []
                //   for ($i=0; $i <count($input['mltest_id']); $i++) { 
                //       $data[] = [
                //       'test_conducted' => $input['test_conducted'][$i],
                //       'result' => $input['result'][$i],
                //       'acceptance_criterion' => $input['acceptance_criterion'][$i],
                //       'added_by_id' => Auth::guard('admin')->id(),
                //       'load_analyses_id' => $input['loadanalyses'],
                //       'product_id' => $input['micro_product_id'],
                //        'created_at' => \Carbon\Carbon::now(),
                //        'updated_at' => \Carbon\Carbon::now(),
                //       ];
                //   }
                //   $inserted = DB::table('microbial_load_reports')->insert($data);
                //   Session::flash("message", "Report Successfully Stored, Proceed to complete.");
                //   Session::flash("message_title", "success");
                //   return redirect()->route('admin.micro.report.create');
            
              }

              public function report_show(MicrobialEfficacyReport $microbialReport)
              {   
                   return 'jjrjdjwnjfk';
                //  $id = $microbialReport->id;
                  
                //  $data['microproduct_withtests'] = Product::where('id',$id)->with("dept")->whereHas("dept", function($q){
                //   return $q->where("dept_id", 1)->where("status_id", 3);
                //  })->with("testConducteds")->whereHas("testConducteds")->get();
          
                //  return view('admin.microbiology.showreport', $data);
          
              }

}
