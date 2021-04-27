<?php

namespace App\Http\Controllers\AdminAuth\Microbiology;

use Illuminate\Http\Request;
use App\Http\Requests\AcceptMircoProductRequest;
use App\Http\Requests\MicroTestCreateRequest;
use App\Http\Controllers\Controller;
use App\Department;
use App\ProductDept;
use App\Product;
use App\ProductType;
use App\Admin;
use App\MicrobialLoadReport;
use App\MicrobialEfficacyReport;
use App\MicrobialEfficacyAnalyses;
use App\MicrobialLoadAnalyses;
use App\MicroReportConclusion;
use Carbon\Carbon;
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
          
           
      if(!Admin::find(Auth::guard('admin')->id())->hasPermission(13)) {
        Session::flash('messagetitle', 'warning');
        Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
        return redirect()->route('admin.general.dashboard');

    }   
         $data['product_type_id']= 0;
         $data['product_types'] = ProductType::all();

          $data['dept1'] = Department::find(1)->products()->with('departments')->where('status',1)->orderBy('status')->get();

          return View('admin.micro.receiveproduct', $data); 

    }

      public function productlist_search(Request $r){
        // dd($r->all());
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(13)) {
          Session::flash('messagetitle', 'warning');
          Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
          return redirect()->route('admin.general.dashboard');
  
      } 
       $data['product_type_id'] = $r->product_type_id;
       $data['product_types'] = ProductType::all();

        if ($r->date == Null) {
          $data['dept1'] = Department::find(1)->products()->with('departments')->orderBy('status')
          ->whereHas("departments", function($q)use($r){
           return $q->where("dept_id",1)->where("status",$r->status);
          })->get();
        }
     
        if ($r->date == 1) {

          $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));
  
          $data['dept1'] = Department::find(1)->products()->orderBy('status')->with('departments')
          ->whereHas("departments", function($q)use($r,$week_start){
            return $q->where("dept_id",1)->where('product_depts.created_at','>=',$week_start);
          })->get();

          if ($r->status == 1) {
  
            $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));
  
            $data['dept1'] = Department::find(1)->products()->orderBy('status')->with('departments')
            ->whereHas("departments", function($q)use($r,$week_start){
              return $q->where("dept_id",1)->where("status",$r->status)->where('product_depts.created_at','>=',$week_start);
            })->get();
          }
     
          if ($r->status > 1) {
            $week_start = date('Y-m-d 00:00:00', strtotime('-'.date('w').' days'));
  
            $data['dept1'] = Department::find(1)->products()->orderBy('status')->with('departments')
            ->whereHas("departments", function($q)use($r,$week_start){
              return $q->where("dept_id",1)->where("status",$r->status)->where('product_depts.received_at','>=',$week_start);
            })->get();
          }
     
        }
  
        if ($r->date == 2) {

          $month_start = date('Y-m-01 00:00:00');
  
          $data['dept1'] = Department::find(1)->products()->orderBy('status')->with('departments')->whereHas("departments", function($q)use($r,$month_start){
             return $q->where("dept_id",1)->where('product_depts.created_at','>=',$month_start);
           })->get();

          if ($r->status == 1) {
            $month_start = date('Y-m-01 00:00:00');
  
            $data['dept1'] = Department::find(1)->products()->orderBy('status')->with('departments')->whereHas("departments", function($q)use($r,$month_start){
               return $q->where("dept_id",1)->where("status",$r->status)->where('product_depts.created_at','>=',$month_start);
             })->get();
          }
          if ($r->status > 1) {
            $month_start = date('Y-m-01 00:00:00');
  
            $data['dept1'] = Department::find(1)->products()->orderBy('status')->with('departments')->whereHas("departments", function($q)use($r,$month_start){
               return $q->where("dept_id",1)->where("status",$r->status)->where('product_depts.received_at','>=',$month_start);
             })->get();
          }
      
        }
        elseif ($r->date == Null && $r->status == Null) {
      
        $data['dept1'] = Department::find(1)->products()->with('departments')->orderBy('status')
       ->whereHas("departments", function($q){
        return $q->where("dept_id",1);
       })->get();
       }
       return View('admin.micro.receiveproduct', $data); 
      } 

    public function acceptproduct(AcceptMircoProductRequest $request)
      {    
          //  dd($request->all());
        if(!Admin::find(Auth::guard('admin')->id())->hasPermission(14)) {
          Session::flash('messagetitle', 'warning');
          Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
          return redirect()->route('admin.general.dashboard');
        }       
        
            
              $adminId = Auth::guard('admin')->id();
              $deptproduct_id = $request->deptproduct_id;
              $status = $request->status;
              $delivered_by = $request->adminid;

              if ($status > 2 ) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin.');
              return redirect()->back();
          } 
              if ($deptproduct_id == 0) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required product and submit.');
              return redirect()->back();
          }  

            $productdeptstatus = ProductDept::whereIn('product_id', $deptproduct_id)->where("dept_id", 1)->where("status", '>',2)->first();
            if ($status < (!empty($productdeptstatus->status) ? $productdeptstatus->status: '')) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Sorry Product(s) is/are now in a work process mode..');
              return redirect()->back();
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
            ProductDept::whereIN('product_id',$deptproduct_id)->where("dept_id", 1)->where("status", '<', 3)->update($data);

            Session::flash('message_title', 'success');
            Session::flash('message', 'Product(s) status successfully updated ');
            return redirect()->route('admin.micro.receiveproduct')
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


           //********************* Micro Report Processes ****************** */

              public function report_create(){
                
               
                if(!Admin::find(Auth::guard('admin')->id())->hasPermission(15)) {
                Session::flash('messagetitle', 'warning');
                Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
                return redirect()->route('admin.general.dashboard');
                } 
                 $data['auth'] = Admin::where('id',Auth::guard('admin')->id())->get();
                 $data['auth_id'] = Admin::where('id',Auth::guard('admin')->id())->first();

                $load_analysis_options = json_decode(Admin::findOrFail(Auth::guard("admin")->id())->load_analysis_options);

                $efficacy_analysis_options = json_decode(Admin::findOrFail(Auth::guard("admin")->id())->efficacy_analysis_options);
               

                $data['MicrobialLoadAnalysis'] = MicrobialLoadAnalyses::whereIn("id", $load_analysis_options)->orderBy('location', 'ASC')->get();

                $data['MicrobialEfficacyAnalysis'] = MicrobialEfficacyAnalyses::whereIn("id", $efficacy_analysis_options)->get();

              
                //********************* section for the dept offcie only ***** */

                $data['microproducts'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 2);
                })->with('loadAnalyses')->whereDoesntHave("loadAnalyses")->with('efficacyAnalyses')->whereDoesntHave("efficacyAnalyses")->orderBy('id','DESC')->get();

               $data['microproduct_withloadanalysis'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
    
                 $data['microproduct_withefficacyanalysis'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

                $data['microproduct_withtests'] = $data['microproduct_withloadanalysis']->merge($data['microproduct_withefficacyanalysis']);


                //********************* section for authusers who perform repot ***** */
                $data['microproducts'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 2);
                })->with('loadAnalyses')->whereDoesntHave("loadAnalyses")->with('efficacyAnalyses')->whereDoesntHave("efficacyAnalyses")->orderBy('id','DESC')->get();

               $data['auth_microproduct_withloadanalysis'] = Product::where('micro_analysed_by',Auth::guard('admin')->id())->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
    
                 $data['auth_microproduct_withefficacyanalysis'] = Product::where('micro_analysed_by',Auth::guard('admin')->id())->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

               $data['auth_microproduct_withtests'] = $data['auth_microproduct_withloadanalysis']->merge($data['auth_microproduct_withefficacyanalysis']);


                //***************************************** All completed report  */
                $data['microproduct_withloadanalysis_completedtests'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 4);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->limit(100)->get();

                $data['microproduct_withefficacyanalysis_completedtests'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 4);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->limit(100)->get();

                $data['microproduct_completedtests'] = $data['microproduct_withloadanalysis_completedtests']->merge($data['microproduct_withefficacyanalysis_completedtests']);

                return View('admin.micro.createreport', $data); 
              }

              public function test_create(MicroTestCreateRequest $r){


                if(!Admin::find(Auth::guard('admin')->id())->hasPermission(16)) {
                Session::flash('messagetitle', 'warning');
                Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
                return redirect()->route('admin.general.dashboard');

                } 
                //  $micro_grades = [1,2];
                //  if(!in_array($r->micro_grade, $micro_grades)){
                //   Session::flash('message_title', 'error');
                //   Session::flash('message', 'Sorry! System Error.');
                //     return redirect()->back();
                //  }
               
                $input = $r->all();
                $mp_id = $input['micro_product_id'];
                $products = Product::where('id',$mp_id);
                if(count($products->get()) < 1){
                    return redirect()->back();
                }
                $productdepts = ProductDept::where('product_id',$r->micro_product_id)->where("dept_id", 1)->where("status",3);
                if(count($productdepts->get()) > 0){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Sorry! Product already chosen by another user or you have a (Double Entry) error');
                    return redirect()->back();
                }

                
                $test_conducted = [];
                $result = [];
                $acceptance_criterion = [];
                $mlcompliance = [];
                $definition = [];
                $location = [];

                $pathogen = [];
                $pi_zone = [];
                $ci_zone = [];
                $fi_zone = [];
                $reference = [];
            
                if($r->test_conducted_id){

                  foreach ($r->mltest_id as $key => $value) {
                    if(!isset($r->{'test_conducted_'.$value}) or $r->{'test_conducted_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'test_conducted field is required.');
                      return redirect()->back();
                    }
                    if(!isset($r->{'result_'.$value}) or $r->{'result_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'result_ field is required.');
                      return redirect()->back();
                    }
                    if(!isset($r->{'acceptance_criterion_'.$value}) or $r->{'acceptance_criterion_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'acceptance_criterion field is required.');
                      return redirect()->back();
                    }
                    if(!isset($r->{'mlcompliance_'.$value}) or $r->{'mlcompliance_'.$value}==null){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Compliance field is required.');
                      return redirect()->back();
                    }
                 
                    array_push($test_conducted,$r->{'test_conducted_'.$value});
                    array_push($result,$r->{'result_'.$value});
                    array_push($acceptance_criterion,$r->{'acceptance_criterion_'.$value});
                    array_push($mlcompliance,$r->{'mlcompliance_'.$value});
                    array_push($definition,$r->{'definition_'.$value});
                    array_push($location,$r->{'location_'.$value});

                    if (!in_array(0 & 1, $location)) {
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'The first two fields are required.');
                      return redirect()->back();
                    }
                  }
               
                  
                    for ($i=0; $i < count($result); $i++) { 
                     
                      if ($i<2) {
                   
                      $results= explode(' ',$result[$i]);
                      $rs_part1 =$results[0];
                      $rs_part2 = explode('^',$results[2]);
                  
                      $rs_total = $rs_part1 * pow($rs_part2[0],$rs_part2[1]);

                      $criterial= explode(' ',$acceptance_criterion[$i]);
                      $ac_part1 =$criterial[0];
                      $ac_part2 = explode('^',$criterial[2]);
                     $ac_total = $ac_part1 * pow($ac_part2[0],$ac_part2[1]);

                     
                         MicrobialLoadReport::create([
                          'test_conducted'=>$test_conducted[$i],
                          'load_analyses_id'=>$r->mltest_id[$i],
                          'product_id'=>$r->micro_product_id,
                          'rs_total'=>$rs_total,
                          'result'=>$result[$i],
                          'acceptance_criterion'=>$acceptance_criterion[$i],
                          'compliance'=>$mlcompliance[$i],
                          'ac_total'=>$ac_total,
                          'date_template'=>$r->date_template,
                          'definition'=>$definition[$i],
                          'location'=>$location[$i],
                          'added_by_id' => Auth::guard('admin')->id(),
                          'created_at' => \Carbon\Carbon::now(),
                          'updated_at' => \Carbon\Carbon::now(),
                      ]);
             
                    }else{
                      
                        MicrobialLoadReport::create([
                        'test_conducted'=>$test_conducted[$i],
                        'load_analyses_id'=>$r->mltest_id[$i],
                        'product_id'=>$r->micro_product_id,
                        'rs_total'=>$rs_total,
                        'result'=>$result[$i],
                        'acceptance_criterion'=>$acceptance_criterion[$i],
                        'compliance'=>$mlcompliance[$i],
                        'ac_total'=>$ac_total,
                        'date_template'=>$r->date_template,
                        'definition'=>$definition[$i],
                        'location'=>$location[$i],
                        'added_by_id' => Auth::guard('admin')->id(),
                        'created_at' => \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now(),
                    ]);
                        }

                     }
                    
                     $micro_la_comment = Null;
                   if ($r->ml_general_comment) {
                     $micro_la_comment = $r->micro_la_comment_text;
                   }else {
                     $micro_la_comment = $r->micro_la_comment_option;
                   }
                     $product = $products->first();
                     $product->micro_la_comment = $micro_la_comment;
                     $product->update();

                     if ($r->load_default_conclusion == 1) {
                      $conclustions = MicroReportConclusion::findorFail(1); 
                      $product = $products->first();
                      $product->micro_grade = 2;
                      $product->micro_la_conclusion = $r->load_default_conclusion;
                      $product->micro_general_conclusion = $conclustions->default_conclusion;
                      $product->update();
                    }
                    if($r->load_default_conclusion == 2) {
                      $conclustions = MicroReportConclusion::findorFail(2); 
                      $product = $products->first();
                      $product->micro_grade = 1;
                      $product->micro_la_conclusion = $r->load_default_conclusion;
                      $product->micro_general_conclusion = $conclustions->default_conclusion;
                      $product->update();
                    }
                 }
                  
                  if($r->efficacyanalyses){

                 foreach ($r->metest_id as $key => $value) {
                if(!isset($r->{'pathogen_'.$value}) or $r->{'pathogen_'.$value}==null){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'pathogen field is required.');
                  return redirect()->back();
                }
                if(!isset($r->{'pi_zone_'.$value}) or $r->{'pi_zone_'.$value}==null){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'pi_zone field is required.');
                  return redirect()->back();
                }
                if(!isset($r->{'ci_zone_'.$value}) or $r->{'ci_zone_'.$value}==null){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'ci_zone field is required.');
                  return redirect()->back();
                }
                if(!isset($r->{'fi_zone_'.$value}) or $r->{'fi_zone_'.$value}==null){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'fi_zone field is required.');
                  return redirect()->back();
                }

                array_push($pathogen,$r->{'pathogen_'.$value});
                array_push($pi_zone,$r->{'pi_zone_'.$value});
                array_push($ci_zone,$r->{'ci_zone_'.$value});
                array_push($fi_zone,$r->{'fi_zone_'.$value});
                array_push($reference,$r->{'reference_'.$value});

              }
                  for ($j=0; $j < count($pi_zone); $j++) { 
                          MicrobialEfficacyReport::create([
                          'efficacy_analyses_id'=>$r->metest_id[$j],
                          'product_id'=>$r->micro_product_id,
                          'pathogen'=>$pathogen[$j],
                          'pi_zone'=>$pi_zone[$j],
                          'ci_zone'=>$ci_zone[$j], 
                          'fi_zone'=>$fi_zone[$j],
                          'reference'=>$reference[$j],
                          'added_by_id' => Auth::guard('admin')->id(),
                          'created_at' => \Carbon\Carbon::now(),
                          'updated_at' => \Carbon\Carbon::now(),
                          ]);
                         
                       }

                       $micro_ea_comment = Null;  
                     if ($r->me_general_comment) {
                       $micro_ea_comment = $r->micro_ea_comment_text;
                     }else {
                       $micro_ea_comment= $r->micro_ea_comment_option;
                     }
                       $product = $products->first();
                       $product->micro_ea_comment = $micro_ea_comment;
                       $product->update(); 
                       
                if ($r->efficacy_default_conclusion ==1) {
                  $conclustions = MicroReportConclusion::findorFail(3); 
                  $product = $products->first();
                  $product->micro_grade = 2;
                  $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                  $product->micro_general_conclusion = $conclustions->default_conclusion;
                  $product->update();
                }
                if ($r->efficacy_default_conclusion ==2) {
                  $conclustions = MicroReportConclusion::findorFail(4); 
                  $product->micro_grade = 1;
                  $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                  $product = $products->first();
                  $product->micro_general_conclusion = $conclustions->default_conclusion;
                  $product->update();
                }
               }


                  $productdepts = ProductDept::where('product_id',$mp_id)->where("dept_id", 1)->where("status",2);
                  $productdept = $productdepts->first();
                  $productdept->status = 3;
                  $productdept->update();
            
                  $product = $products->first();
                  $product->micro_dateanalysed =$r->date_analysed;
                  $product->micro_analysed_by = Auth::guard('admin')->id();
                  $product->update();

               if ($r->test_conducted_id && $r->efficacyanalyses){
                 
                if ($r->load_default_conclusion == 1 && $r->efficacy_default_conclusion == 1) {
                  $conclustions = MicroReportConclusion::findorFail(5); 
                  $product = $products->first();
                  $product->micro_grade = 2;
                  $product->micro_la_conclusion = $r->load_default_conclusion;
                  $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                  $product->micro_general_conclusion = $conclustions->default_conclusion;
                  $product->update();
                }
                if ($r->load_default_conclusion == 1 && $r->efficacy_default_conclusion == 2) {
                  $conclustions = MicroReportConclusion::findorFail(6); 
                  $product = $products->first();
                  $product->micro_grade = 2;
                  $product->micro_la_conclusion = $r->load_default_conclusion;
                  $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                  $product->micro_general_conclusion = $conclustions->default_conclusion;
                  $product->update();
                  }
                if ($r->load_default_conclusion == 2 && $r->efficacy_default_conclusion == 1) {
                  $conclustions = MicroReportConclusion::findorFail(7); 
                  $product = $products->first();
                  $product->micro_grade = 1;
                  $product->micro_la_conclusion = $r->load_default_conclusion;
                  $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                  $product->micro_general_conclusion = $conclustions->default_conclusion;
                  $product->update();
                  }
                if ($r->load_default_conclusion == 2 && $r->efficacy_default_conclusion == 2) {
                  $conclustions = MicroReportConclusion::findorFail(8); 
                  $product = $products->first();
                  $product->micro_grade = 1;
                  $product->micro_la_conclusion = $r->load_default_conclusion;
                  $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                  $product->micro_general_conclusion = $conclustions->default_conclusion;
                  $product->update();
                  }
               }
                  Session::flash("message", "Report Successfully Stored, Proceed to complete.");
                  Session::flash("message_title", "success");
                  return redirect()->route('admin.micro.report.create');
            }

              public function report_show(MicrobialLoadReport $microbialReport, $id)
              { 

            
                if(!Admin::find(Auth::guard('admin')->id())->hasPermission(17)) {
                Session::flash('messagetitle', 'warning');
                Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
                return redirect()->route('admin.general.dashboard');

                } 
                $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",3);
                if(count($productdepts->get()) < 1){     
                  return redirect()->route('admin.micro.report.create');
                }

                $data['report_id'] = $id;     
                $efficacy_analysis_options = json_decode(Admin::findOrFail(Auth::guard("admin")->id())->efficacy_analysis_options);         
                $data['MicrobialEfficacyform'] = MicrobialEfficacyAnalyses::whereIn("id", $efficacy_analysis_options)->get();
                
                $data['show_productdept'] = ProductDept::where('product_id',$id)->where('status',3)->where('dept_id',1)->get();
          
                $data['show_microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('location')->get();
               
                $data['show_microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();

                 return view('admin.micro.showreport', $data);
          
              }


              public function report_update(request $r, $id)
              {

                // dd($r->all());
                if(!Admin::find(Auth::guard('admin')->id())->hasPermission(18)) {
                Session::flash('messagetitle', 'warning');
                Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
                return redirect()->route('admin.general.dashboard');

                } 
                $products= Product::where('id',$id);
                if(count($products->get()) < 1){
                  Session::flash('messagetitle', 'warning');
                  Session::flash('message', 'System Error! You do not have access to the resource requested');
                  return redirect()->route('admin.micro.report.create');

                }

                $input = $r->all();
               $ml_testconducteds = $r->test_conducted;
               $mc_testconducteds= $r->mc_test_conducted;
               $mlr_ids =  $r->mltest_id;

               $mer_ids =  $r->metest_id;
               $mlmc_ids =  $r->mlmc_ids;
               $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",3);
                if(count($productdepts->get()) < 1){     
                    return redirect()->back();
                }
              
                   if($r->test_conducted_update){
                
                    for ($i =0; $i < count($r->result); $i++){ 
                          if ($i<2) {
                            $results= explode(' ',$r->result[$i]);
                            $rs_part1 =$results[0];
                            $rs_part2 = explode('^',$results[2]);
                            $rs_total = $rs_part1 * pow($rs_part2[0],$rs_part2[1]);

                            $criterial= explode(' ',$r->acceptance_criterion[$i]);
                            $ac_part1 =$criterial[0];
                            $ac_part2 = explode('^',$criterial[2]);
                            $ac_total = $ac_part1 * pow($ac_part2[0],$ac_part2[1]);
                            
                            \App\MicrobialLoadReport::find($r->mltest_id[$i])->update([
                            'test_conducted'=>$r->test_conducted[$i],
                            'result'=>$r->result[$i],
                            'rs_total'=>$rs_total,
                            'acceptance_criterion'=>$r->acceptance_criterion[$i],
                            'compliance'=>$r->mlcompliance[$i],
                            'ac_total'=>$ac_total,
                            'added_by_id' => Auth::guard('admin')->id(),
                            'updated_at' => \Carbon\Carbon::now(),
                          ]);
                          
                          }
                    
                            else{
                              DB::table('microbial_load_reports')->where('id', $mlr_ids[$i])
                              ->update([
                                'test_conducted'=>$ml_testconducteds[$i],
                                'result'=>$r->result[$i],
                                'rs_total'=>1,
                                'acceptance_criterion'=>$r->acceptance_criterion[$i],
                                'compliance'=>$r->mlcompliance[$i],
                                'ac_total'=>1,
                                'added_by_id' => Auth::guard('admin')->id(),
                                'updated_at' => \Carbon\Carbon::now(),
                              ]);
                              }
                       }
                         
                        if ($r->load_default_conclusion == 1) {
                          $conclustions = MicroReportConclusion::findorFail(1); 
                          $product = $products->first();
                          $product->micro_grade = 2;
                          $product->micro_la_conclusion = $r->load_default_conclusion;
                          $product->micro_general_conclusion = $conclustions->default_conclusion;
                          $product->update();
                        }
                        if($r->load_default_conclusion == 2) {
                          $conclustions = MicroReportConclusion::findorFail(2); 
                          $product = $products->first();
                          $product->micro_grade = 1;
                          $product->micro_la_conclusion = $r->load_default_conclusion;
                          $product->micro_general_conclusion = $conclustions->default_conclusion;
                          $product->update();
                        }
                      
                     }
                
                        if($r->efficacyanalyses_form){


                         for ($k=0; $k < count($r->metestform_id); $k++) { 
                         $data1 = ([
                          'efficacy_analyses_id'=>$r->metestform_id[$k],
                          'product_id'=>$r->micro_product_id,
                          'pathogen'=>$r->pathogen_form[$k],
                          'pi_zone'=>$r->pi_zoneform[$k],
                          'ci_zone'=>$r->ci_zoneform[$k], 
                          'fi_zone'=>$r->fi_zoneform[$k],
                          'added_by_id' => Auth::guard('admin')->id(),
                          'created_at' => \Carbon\Carbon::now(),
                            ]);
                          DB::table('microbial_efficacy_reports')->insert($data1);
                          }

                            $micro_ea_comment = Null;  

                          if ($r->me_general_comment) {
                            $micro_ea_comment = $r->micro_ea_comment_text;
                          }else {
                            $micro_ea_comment= $r->micro_ea_comment_option;
                          }
     
                            $product = $products->first();
                            $product->micro_ea_comment = $micro_ea_comment;
                            $product->update(); 
                            
                       
                          if ($r->efficacy_default_conclusion ==1) {
                            $conclustions = MicroReportConclusion::findorFail(3); 
                            $product = $products->first();
                            $product->micro_grade = 2;
                            $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                            $product->micro_general_conclusion = $conclustions->default_conclusion;
                            $product->update();
                          }
                          if ($r->efficacy_default_conclusion ==1) {
                            $conclustions = MicroReportConclusion::findorFail(4); 
                            $product = $products->first();
                            $product->micro_grade = 2;
                            $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                            $product->micro_general_conclusion = $conclustions->default_conclusion;
                            $product->update();
                          }

                       }

                       if($r->efficacyanalyses_update){
                        $l = 0;
                        $count1 = count($input['metest_id']);
                        while($l < $count1){
                        DB::table('microbial_efficacy_reports')->where('id', $mer_ids[$l])
                              ->update([
                                'efficacy_analyses_id'=> $r->efficacy_analyses_id[$l],
                                'product_id'=>$r->micro_product_id,
                                'pi_zone'=>$r->pi_zone_update[$l],
                                'ci_zone'=>$r->ci_zone_update[$l],
                                'fi_zone'=>$r->fi_zone_update[$l],

                                'added_by_id' => Auth::guard('admin')->id(),
                                'updated_at' => \Carbon\Carbon::now(),
                              ]  
                              );
                          $l++;
                        }

                        
                            
                      if ($r->efficacy_default_conclusion ==1) {
                        $conclustions = MicroReportConclusion::findorFail(3); 
                        $product = $products->first();
                        $product->micro_grade = 2;
                        $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                        $product->micro_general_conclusion = $conclustions->default_conclusion;
                        $product->update();
                      }
                      if ($r->efficacy_default_conclusion ==1) {
                        $conclustions = MicroReportConclusion::findorFail(4); 
                        $product = $products->first();
                        $product->micro_grade = 2;
                        $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                        $product->micro_general_conclusion = $conclustions->default_conclusion;
                        $product->update();
                      }
                    }


                      if ($r->test_conducted_update && $r->efficacyanalyses_update){
                        if ($r->load_default_conclusion == 1 && $r->efficacy_default_conclusion == 1) {
                          $conclustions = MicroReportConclusion::findorFail(5); 
                          $product = $products->first();
                          $product->micro_grade = 2;
                          $product->micro_la_conclusion = $r->load_default_conclusion;
                          $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                          $product->micro_general_conclusion = $conclustions->default_conclusion;
                          $product->update();
                        }
                        if ($r->load_default_conclusion == 1 && $r->efficacy_default_conclusion == 2) {
                          $conclustions = MicroReportConclusion::findorFail(6); 
                          $product = $products->first();
                          $product->micro_grade = 2;
                          $product->micro_la_conclusion = $r->load_default_conclusion;
                          $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                          $product->micro_general_conclusion = $conclustions->default_conclusion;
                          $product->update();
                          }
                        if ($r->load_default_conclusion == 2 && $r->efficacy_default_conclusion == 1) {
                          $conclustions = MicroReportConclusion::findorFail(7); 
                          $product = $products->first();
                          $product->micro_grade = 1;
                          $product->micro_la_conclusion = $r->load_default_conclusion;
                          $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                          $product->micro_general_conclusion = $conclustions->default_conclusion;
                          $product->update();
                          }
                        if ($r->load_default_conclusion == 2 && $r->efficacy_default_conclusion == 2) {
                          $conclustions = MicroReportConclusion::findorFail(8); 
                          $product = $products->first();
                          $product->micro_grade = 1;
                          $product->micro_la_conclusion = $r->load_default_conclusion;
                          $product->micro_ea_conclusion = $r->efficacy_default_conclusion;
                          $product->micro_general_conclusion = $conclustions->default_conclusion;
                          $product->update();
                          }
                       }

                   if ($r->efficacyanalyses_update || $r->test_conducted_update) {
                        $micro_la_comment = Null;
                        $micro_ea_comment = Null;

                      if ($r->ml_general_comment) {
                        $micro_la_comment = $r->micro_la_comment_text;
                      }else {
                        $micro_la_comment = $r->micro_la_comment_option;
                      }
                      if ($r->me_general_comment) {
                        $micro_ea_comment = $r->micro_ea_comment_text;
                      }else {
                        $micro_ea_comment = $r->micro_ea_comment_option;
                      }

                    $products =Product::where('id', $id)->with("departments")->whereHas("departments", function($q){
                      return $q->where("dept_id", 1)->where("status", 3);
                      });
                       
                      $product = $products->first();
                      $product->micro_ea_comment = $micro_ea_comment;
                      $product->micro_la_comment = $micro_la_comment;
                      $product->micro_hod_remarks = $r->micro_hod_remarks;
                      $product->micro_dateanalysed =$r->date_analysed;
                      $product->micro_dateapproved =\Carbon\Carbon::now();
                      $product->micro_analysed_by = Auth::guard('admin')->id();
  
                      $product->update();
    
                   }
                 
                    if ($r->complete_report) {
                    $products =Product::where('id', $id)->with("departments")->whereHas("departments", function($q){
                      return $q->where("dept_id", 1)->where("status", 3);
                    });
                    $product = $products->first();
                    $product->micro_hod_evaluation = 0;
                    $product->update();
                    
                    Session::flash("message", "Report has been submitted to the Head of Department");
                    Session::flash("message_title", "success");
                  }
                 
                  Session::flash("message", "Report Successfully saved and updated.");
                  Session::flash("message_title", "success");
                
                  return redirect()->back();

              }
              
              public function report_delete($id){
                 
                if(!Admin::find(Auth::guard('admin')->id())->hasPermission(18)) {
                Session::flash('messagetitle', 'warning');
                Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
                return redirect()->route('admin.general.dashboard');
                } 

                $product = Product::where('id',$id)->where('micro_hod_evaluation',0)->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
                })->first();
                if($product){
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Sorry product under evaluation and can not be deleted. Thank You');     
                  return redirect()->back();
                }
                    
                 $product = Product::where('id',$id)->where('micro_hod_evaluation',2)->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                  })->first();
                  if($product){
                    Session::flash('message_title', 'error');
                    Session::flash('message', 'Sorry product under final evaluation and can not be deleted. Thank You');     
                    return redirect()->back();
                  }
                 MicrobialLoadReport::where('product_id',$id)->delete();
                 MicrobialEfficacyReport::where('product_id',$id)->delete();
                 $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",3);
                 if(count($productdepts->get()) < 1){
                     
                     return redirect()->back();
                 }
                 $productdept = $productdepts->first();
                 $productdept->status = 2;
                 $productdept->update();
                 
                 $data = ([
                  'micro_finalapproved_by'=>Null,
                  'micro_hod_evaluation'=>Null,
                  'micro_dateanalysed'=>Null,
                  'micro_la_comment'=>Null,
                  'micro_ea_comment'=>Null,
                  'micro_grade'=>Null,
                  'micro_analysed_by'=>Null,
                 ]);
                 Product::where('id',$id)->update($data);

                     return redirect()->back();
              }

               public function printreport($id){

                $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",'>',2);
                if(count($productdepts->get()) < 1){  
                     
                  return redirect()->route('admin.micro.report.create');
                }  

                $data['report_id'] = $id; 
          
                $data['micro_withcompletedproducts'] = Product::where('id',$id)->with("departments")->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", '>',2);
                 })->get();
                 
          
                $data['microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
                $data['check_load'] = MicrobialLoadReport::where('product_id',$id)->orderBy('location')->get();

                $data['microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();

               
                //  $pdf = \PDF::loadView('admin.micro.completedreport', $data);
                //  $pdf->download('admin.micro.completedreport');

                 return view('admin.micro.completedreport',$data);
  
              }

              //***********************HoD Office */
  

             public function hodoffice_evaluation(){

                      
              if(!Admin::find(Auth::guard('admin')->id())->hasPermission(19)) {
              Session::flash('messagetitle', 'warning');
              Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
              return redirect()->route('admin.general.dashboard');

              } 
               //******************************* withhelds  */
              $data['microproduct_withloadanalysis_withhelds'] = Product::where('micro_hod_evaluation',1)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

              $data['microproduct_withefficacyanalysis_withhelds'] = Product::where('micro_hod_evaluation',1)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

              $data['withhelds'] = $data['microproduct_withloadanalysis_withhelds']->merge($data['microproduct_withefficacyanalysis_withhelds']);

             //******************************* approvals */
              $data['microproduct_withloadanalysis_approvals'] = Product::where('micro_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

              $data['microproduct_withefficacyanalysis_approvals'] = Product::where('micro_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

              $data['approvals'] = $data['microproduct_withloadanalysis_approvals']->merge($data['microproduct_withefficacyanalysis_approvals']);
            
              //*******************************completeds */
              $data['completeds'] = Product::with('departments')->whereHas("departments", function($q){
              return $q->where("dept_id", 1)->where("status", 4);
              })->get();

              
              //*******************************Product withheld under evaluations */
               $data['microproduct_withloadanalysis_evaluations'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','<',1)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

              $data['microproduct_withefficacyanalysis_evaluations'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','<',1)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

              $data['evaluations'] = $data['microproduct_withloadanalysis_evaluations']->merge($data['microproduct_withefficacyanalysis_evaluations']);

              //******************************* final_reports */
              $data['microproduct_withloadanalysis_final_reports'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','>',0)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

              $data['microproduct_withefficacyanalysis_final_reports'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','>',0)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

              $data['final_reports'] = $data['microproduct_withloadanalysis_final_reports']->merge($data['microproduct_withefficacyanalysis_final_reports']);

              //*******************************hod_withhelds*/

              $data['microproduct_withloadanalysis_hod_withhelds'] = Product::where('micro_hod_evaluation',2)->where('micro_process_status',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

              $data['microproduct_withefficacyanalysis_hod_withhelds'] = Product::where('micro_hod_evaluation',2)->where('micro_process_status',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();


              $data['hod_withhelds'] = $data['microproduct_withloadanalysis_hod_withhelds']->merge($data['microproduct_withefficacyanalysis_hod_withhelds']);
             
              
              //*******************************hod_approvals */

              $data['microproduct_withloadanalysis_hod_approvals'] = Product::where('micro_hod_evaluation',2)->where('micro_process_status',3)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
              
              $data['microproduct_withefficacyanalysis_hod_approvals'] = Product::where('micro_hod_evaluation',2)->where('micro_process_status',3)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

              $data['hod_approvals'] = $data['microproduct_withloadanalysis_hod_approvals']->merge($data['microproduct_withefficacyanalysis_hod_approvals']);


              return view('admin.micro.hodoffice.evaluation',$data);

              }

              public function hodoffice_showreport(MicrobialLoadReport $microbialReport, $id)
                { 

                if(!Admin::find(Auth::guard('admin')->id())->hasPermission(20)) {
                Session::flash('messagetitle', 'warning');
                Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
                return redirect()->route('admin.general.dashboard');

                } 

                $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",3);
                if(count($productdepts->get()) < 1){     
                  return redirect()->route('admin.micro.report.create');
                }
                 
                
                $data['microproduct_withloadanalysis_evaluations'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','<',1)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
                            
                $data['microproduct_withefficacyanalysis_evaluations'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','<',1)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

                $data['evaluations'] = $data['microproduct_withloadanalysis_evaluations']->merge($data['microproduct_withefficacyanalysis_evaluations']);


                $data['microproduct_withloadanalysis_final_reports'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','>',0)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
                $data['microproduct_withefficacyanalysis_final_reports'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','>',0)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

                $data['final_reports'] = $data['microproduct_withloadanalysis_final_reports']->merge($data['microproduct_withefficacyanalysis_final_reports']);

  
                $data['completeds'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 4);
                })->get();
  
                $data['microproduct_withloadanalysis_withhelds'] = Product::where('micro_hod_evaluation',1)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
                
                $data['microproduct_withefficacyanalysis_withhelds'] = Product::where('micro_hod_evaluation',1)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

                $data['withhelds'] = $data['microproduct_withloadanalysis_withhelds']->merge($data['microproduct_withefficacyanalysis_withhelds']);


                $data['microproduct_withloadanalysis_approvals'] = Product::where('micro_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
                $data['microproduct_withefficacyanalysis_approvals'] = Product::where('micro_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();
                $data['approvals'] = $data['microproduct_withloadanalysis_approvals']->merge($data['microproduct_withefficacyanalysis_approvals']);



                $data['report_id'] = $id;              
                $data['MicrobialEfficacyform'] = MicrobialEfficacyAnalyses::all();
                $data['show_productdept'] = ProductDept::where('product_id',$id)->where('status',3)->where('dept_id',1)->get();
          
                $data['show_microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
               
                $data['show_microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();

                 return view('admin.micro.hodoffice.showreport', $data);
          
              }

             public function evaluate(Request $r){
                    
              if(!Admin::find(Auth::guard('admin')->id())->hasPermission(20)) {
              Session::flash('messagetitle', 'warning');
              Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
              return redirect()->route('admin.general.dashboard');

              } 

              $input = $r->all(); 
          
               if ($r->evaluated_product == null) {
                 Session::flash('message_title', 'error');
                   Session::flash('message', 'Please select required reports for evaluation');
                 return redirect()->back();
               }

              $products = Product::whereIn('id',$r->evaluated_product)->where("micro_hod_evaluation", 2)->where('micro_process_status',3)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              });
               if(count($products->get()) < 1){     
                   Session::flash('message_title', 'error');
                   Session::flash('message', 'Selected product needs to be approved before completion.');
                   return redirect()->back();
               }  
              else{

              $p_ids =  $products->pluck('id')->toArray();
              $productdepts = ProductDept::whereIn('product_id',$p_ids)->where("dept_id", 1)->where("status",3);
              if(count($productdepts->get()) < 1){     
                  return redirect()->back();
              }
              Session::flash("message", "Report Evaluation completed.");
              Session::flash("message_title", "success");
              $productdepts->update(['status' => 4]);
              }
            
              return redirect()->back();
             }

            
              public function evaluate_one_index($id){
              
                     
              if(!Admin::find(Auth::guard('admin')->id())->hasPermission(20)) {
              Session::flash('messagetitle', 'warning');
              Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
              return redirect()->route('admin.general.dashboard');

              } 
              $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",3);
              if(count($productdepts->get()) < 1){     
                return redirect()->route('admin.micro.hod_office.approval');
              }  

               $data['report_id'] = $id; 
  
                $data['microproduct_withloadanalysis_final_reports'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','>',0)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
                
                $data['microproduct_withefficacyanalysis_final_reports'] = Product::where('micro_hod_evaluation','>=',0)->where('micro_process_status','>',0)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

                $data['final_reports'] = $data['microproduct_withloadanalysis_final_reports']->merge($data['microproduct_withefficacyanalysis_final_reports']);

  
                $data['completeds'] = Product::with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 4);
                })->get();
  

                $data['microproduct_withloadanalysis_hod_withhelds'] = Product::where('micro_hod_evaluation',2)->where('micro_process_status',2)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
                $data['microproduct_withefficacyanalysis_hod_withhelds'] = Product::where('micro_hod_evaluation',2)->where('micro_process_status',2)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get();

                $data['hod_withhelds'] = $data['microproduct_withloadanalysis_hod_withhelds']->merge($data['microproduct_withefficacyanalysis_hod_withhelds']);

  
                $data['microproduct_withloadanalysis_hod_approvals'] = Product::where('micro_hod_evaluation',2)->where('micro_process_status',3)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
                $data['microproduct_withefficacyanalysis_hod_approvals'] = Product::where('micro_hod_evaluation',2)->where('micro_process_status',3)->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('efficacyAnalyses')->whereHas("efficacyAnalyses")->get(); 

                $data['hod_approvals'] = $data['microproduct_withloadanalysis_hod_approvals']->merge($data['microproduct_withefficacyanalysis_hod_approvals']);



              $data['micro_withcompletedproducts'] = Product::where('id',$id)->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
               })->with("loadAnalyses")->orderBy('id','DESC')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

               $data['show_productdept'] = ProductDept::where('product_id',$id)->where('status',3)->where('dept_id',1)->get();

              $data['show_microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
               
              $data['show_microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();

              return view('admin.micro.hodoffice.finalreport',$data);
             }


            public function evaluate_one_edit(Request $r, $id){
            //  dd($r->all());
                 
              if(!Admin::find(Auth::guard('admin')->id())->hasPermission(20)) {
              Session::flash('messagetitle', 'warning');
              Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
              return redirect()->route('admin.general.dashboard');

              } 
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
                'micro_hod_evaluation'=> $r->evaluate,
                'micro_approved_by'=>$r->adminid,

              ]);
              if ($r->evaluate ==1) {
                $p->update(['micro_process_status'=> 0, 'micro_appoved_by'=> Null]);
              }
            
             Session::flash("message", "Report Evaluation completed.");
             Session::flash("message_title", "success");  
             return redirect()->back();
            }


            public function hod_finalreport_send($id){
            
                  
              if(!Admin::find(Auth::guard('admin')->id())->hasPermission(20)) {
              Session::flash('messagetitle', 'warning');
              Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
              return redirect()->route('admin.general.dashboard');

              } 

              $completed =ProductDept::where('product_id', $id)->where("dept_id", 1)->where("status", 3)->first();
              $withheld =Product::where('id', $id)->where("micro_process_status",'>',0)->first();
  
              if (!$completed) {
               Session::flash('message_title', 'error');
               Session::flash('message', 'Warning! Product cant be submited for approval');
               return redirect()->route('admin.micro.hod_office.approval');
              }
              if ($withheld) {
                Session::flash('message_title', 'error');
                Session::flash('message', 'Warning! Product withheld and cant be submited for approval');
                return redirect()->back();
               }
  
                $data = [ 
                'micro_process_status' => 1,
                ];
                Product::where('id',$id)->where("micro_process_status", 0)->update($data);
                
                Session::flash("message", "Report successfully submitted for final approval.");
                Session::flash("message_title", "success");  

               return redirect()->route('admin.micro.hod_office.approval');
             }

            public function finalhodevaluate_one_edit(Request $r, $id){

              // dd($r->all());
                   
              if(!Admin::find(Auth::guard('admin')->id())->hasPermission(22)) {
              Session::flash('messagetitle', 'warning');
              Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
              return redirect()->route('admin.general.dashboard');

              } 

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
              
              $evaluate = [];
              if ($r->evaluate ==1) {
                 $evaluate = 2; //*** 2 means withheald */
              }
              if ($r->evaluate ==2) {
                $evaluate = 3; //*** 3 means Approved */
              }  
             
              $p = Product::find($id);
              $p->update([
                'micro_process_status'=> $evaluate,
                'micro_finalapproved_by'=>$r->adminid,
              ]);

              if ($r->evaluate ==1) {
                $p->update(['micro_finalapproved_by'=> Null]);
              }
              
              if ($r->evaluate ==2) {
                if ($p->micro_hod_evaluation == 2 && $p->pharm_hod_evaluation == 2 && $p->phyto_hod_evaluation ==2 ) {
                  $p->update(['overall_status'=> 2]);
                }else {
                  $p->update(['overall_status'=> 1]);
                }
              }
              
             Session::flash("message", "Report Evaluation completed.");
             Session::flash("message_title", "success");  
             return redirect()->back();
            }


            public function hod_complete_report($id){
                   
              if(!Admin::find(Auth::guard('admin')->id())->hasPermission(22)) {
              Session::flash('messagetitle', 'warning');
              Session::flash('message', 'You do not have access to the resource requested. Contact Systems Administrator for assistance.');
              return redirect()->route('admin.general.dashboard');

              } 

              $data['report_id'] = $id; 
          
              $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",3);
              if(count($productdepts->get()) < 1){     
                  return redirect()->back();
              }
              $productdept = $productdepts->first();
              $productdept->status = 4;
              $productdept->update();

              $data['micro_withcompletedproducts'] = Product::where('id',$id)->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 4);
               })->with("loadAnalyses")->orderBy('id','DESC')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
        
              $data['microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
              $data['check_load'] = MicrobialLoadReport::where('product_id',$id)->orderBy('location')->get();

              $data['microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();
              

               return view('admin.micro.completedreport',$data);

              }
           
            public function checkhodsign(Request $request){
             
              $userEmail = $request->get('email');
              $adminPin = $request->get('pin');

              $checkmailonly = Admin::where('dept_id',1)->where('email', '=', $userEmail)->first();
              $admin = Admin::where('dept_id',1)->where('user_type_id','<',4)->where('email', '=', $userEmail)->first();

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
              $adminPIN = $request->get('pin');
  
              $checkallmail = Admin::where('email', '=', $userEmail)->first();
              $admin = Admin::where('dept_id',1)->where('dept_office_id',1)->where('email', '=', $userEmail)->first();
  
              if (!$checkallmail) {
                return response()->json(['status' => false, 'message' => "Sorry there is no such email in the system"]);
              }
          
              if(!$admin){
                return response()->json(['status' => false, 'message' => "Sorry you are not authorized to sign. Contact Department Head "]);
              }

              if(!Hash::check($adminPIN, $admin->pin)){
                return response()->json(['status' => false, 'message' => "Invalid Pin. Please check and sign "]);
              }
              
              return response()->json(['status' => true, 'message' => "success", 'admin' => $admin->id]);
              
            }
  
            public function hodoffice_config(){
   
             $admin_loadselection= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->load_analysis_options);
              $admin_efficacyselection= json_decode(Admin::findOrFail(Auth::guard("admin")->id())->efficacy_analysis_options);

              $data['micro_report_conclusions'] = MicroReportConclusion::all();
              $data['microbial_efficacys'] = MicrobialEfficacyAnalyses::all();
             $data['microbial_efficacyanalyses_admin'] = MicrobialEfficacyAnalyses::whereIn('id',$admin_efficacyselection)->get();


              $data['microbial_loadanalyses'] = MicrobialLoadAnalyses::orderBy('location', 'ASC')->get();
             $data['microbial_loadanalyses_admin'] = MicrobialLoadAnalyses::whereIn('id',$admin_loadselection)->orderBy('location', 'ASC')->get();


              return view('admin.micro.hodoffice.config',$data);
            }

            public function microbialanalysis_create(request $r){
              // dd($r->all());
              $data = $r->validate([
                'test_conducted' => 'required', 
                'result' => 'required', 
                'acceptance_criterion' => 'required',          
              ]);

               $data = ([
                'test_conducted' => $r->test_conducted,
                'definition' => $r->definition,
                'result' => $r->result,
                'location' => $r->location,
                'acceptance_criterion' => $r->acceptance_criterion,
                'added_by_id' => Auth::guard('admin')->id(),
               ]);

               MicrobialLoadAnalyses::create($data);
               return redirect()->back();
            }

            public function microbialefficacy_create(request $r){
              
              // dd($r->all());
              $data = $r->validate([
                'pathogen' => 'required', 
                'pi_zone' => 'required', 
                'ci_zone' => 'required',   
                'fi_zone' => 'required',   
              ]);

              $data = ([
               'pathogen' => $r->pathogen,
               'pi_zone' => $r->pi_zone,
               'ci_zone' => $r->ci_zone,
               'fi_zone' => $r->fi_zone,
               'added_by_id' => Auth::guard('admin')->id(),
              ]);

              MicrobialEfficacyAnalyses::create($data);
              return redirect()->back();
           }


            public function microbialanalysis_update(request $r){
              // return $r;
              // return $r->get("microbial_loadanalyse_id");
              // dd($r->all());
              // $data = $r->validate([
              //   'date' => 'required',          
              // ]);
                
            $date = (\Carbon\Carbon::parse($r->date));
            $action = [1,2];
           if (!in_array($r->action, $action)) {
            Session::flash('message_title', 'error');
            Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin.');
            return redirect()->back();
             } 
          
          if ($r->action ==1) {

            if ($r->microbial_loadanalyse_id == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required parameter and submit.');
              return redirect()->back();
            } 

            $admin = Admin::findOrFail(Auth::guard('admin')->id());
            $admin->load_analysis_options = json_encode($r->get("microbial_loadanalyse_id"));
            $admin->save();
 
            $data = ([ 
              'action' => $r->action,
              'added_by_id' => Auth::guard('admin')->id(),
              'updated_at' => \Carbon\Carbon::now(),
              ]);
    
              MicrobialLoadAnalyses::whereIN('id', $r->microbial_loadanalyse_id)->update($data);
              MicrobialLoadAnalyses::whereNotin('id',$r->microbial_loadanalyse_id)->update(['action' =>0]);
           } 

          if($r->action ==2){
            $l = 0;
            $count1 = count($r->mloadanalyse_id);
            while($l < $count1){
            DB::table('microbial_load_analyses')->where('id', $r->mloadanalyse_id[$l])
                  ->update([
                    'test_conducted'=>$r->name[$l],
                    'result'=>$r->result[$l],
                    'acceptance_criterion'=>$r->acceptance_criterion[$l],
                    'definition'=>$r->definition[$l],
                    'date'=>$date,
                    'location'=>$r->location[$l],
                    'action'=> 1,
                    'added_by_id'=> Auth::guard('admin')->id(),
                    'updated_at' => \Carbon\Carbon::now(),
                  ]  
                  );
              $l++;
            }
          }

         
          Session::flash("message", "Template updated successfully");
          Session::flash("message_title", "success");  
          return redirect()->back();
           }

           public function microbialefficacy_update(request $r){
              // dd($r->all());
              $action = [1,2];
              if (!in_array($r->action, $action)) {
               Session::flash('message_title', 'error');
               Session::flash('message', 'Warning! system is highly secured from any illegal attempt. Please contact system admin.');
               return redirect()->back();
               } 

           if ($r->action ==1) {

            if ($r->microbial_efficacy_id == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required feature and submit.');
              return redirect()->back();
            } 

            $admin = Admin::findOrFail(Auth::guard('admin')->id());
            $admin->efficacy_analysis_options = json_encode($r->get("microbial_efficacy_id"));
            $admin->save();
            $data = 
            [ 
            'action' => $r->action,
            'added_by_id' => Auth::guard('admin')->id(),
            'updated_at' => \Carbon\Carbon::now(),
            ];
            MicrobialEfficacyAnalyses::whereIN('id', $r->microbial_efficacy_id)->update($data);
            MicrobialEfficacyAnalyses::whereNotin('id',$r->microbial_efficacy_id)->update(['action' =>0]);
           } 

          if($r->action ==2){
            $l = 0;
            $count1 = count($r->microbialefficacy_id);
            while($l < $count1){
            DB::table('microbial_efficacy_analyses')->where('id', $r->microbialefficacy_id[$l])
                  ->update([
                    'pathogen' => $r->pathogen[$l],
                    'pi_zone' => $r->pi_zone[$l],
                    'ci_zone' => $r->ci_zone[$l],
                    'fi_zone' => $r->fi_zone[$l],
                    'action'=> 1,
                    'added_by_id'=> Auth::guard('admin')->id(),
                    'updated_at' => \Carbon\Carbon::now(), 'added_by_id' => Auth::guard('admin')->id(),
                  ]  
                  );
              $l++;
            }
          }
          
           Session::flash("message", "Template updated successfully");
           Session::flash("message_title", "success");  
           return redirect()->back();
            }

            public function conclusion_create(Request $r){
              // return $r;
              $r->validate([
                'title' => 'required', 
                'conclusion' => 'required', 
              ]);
             
              $data = ([
                'title' => $r->title, 
                'default_conclusion' => $r->conclusion, 
                'added_by_id'=> Auth::guard('admin')->id(),
              ]);

              MicroReportConclusion::create($data);
              Session::flash("message", "Conclusion Template updated successfully");
              Session::flash("message_title", "success");  
              return redirect()->back();
            }

            public function conclusion_update(Request $r){
              $r->validate([
                'title' => 'required', 
                'conclusion' => 'required', 
              ]);

              $data = ([
                'title' => $r->title, 
                'default_conclusion' => $r->conclusion, 
                'updated_at' => \Carbon\Carbon::now(),
              ]);
              MicroReportConclusion::findOrFail($r->item_id)->update($data);
              Session::flash("message", "Conclusion Template updated successfully");
              Session::flash("message_title", "success");  
              return redirect()->back();
            }
            
           // ********************************* General Report Section *********************************//

           public function completedreport_show($id){
           
            $productdepts = ProductDept::where('product_id', $id)->where("dept_id",3)->where("status",4);
            if(count($productdepts->get()) < 1){     
             return redirect()->back(); 
             }
           return $data['report_id'] = $id; 

            $data['micro_withcompletedproducts'] = Product::where('id',$id)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id", 1)->where("status", '>', 2);
             })->with("loadAnalyses")->orderBy('id','DESC')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
      
            $data['microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
            $data['check_load'] = MicrobialLoadReport::where('product_id',$id)->orderBy('location')->get();

            $data['microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();
            

             return view('admin.micro.completedreport',$data);

            }

           public function generalreport_index(){
           
            $data['from_date'] = "2020-01-01";
            $data['to_date'] = now();

            $data['product_types'] = \App\ProductType::all();
            $data['year'] = \Carbon\Carbon::now('y');


            $data['all_product_lab'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",1)->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
            })->get();

            $data['all_pending_products'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",1)->where("status",1)->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
            })->get();
            
            $data['all_recieved_products'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",1)->where("status",'>',1)->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
            })->get();



            $data['pending_products1'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",1)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
            })->where('micro_process_status','<>',3)->get();
            
            $data['pending_products2'] = Product::whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",1)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
            })->WhereNull("micro_process_status")->get();
  
             $data['pending_products'] = $data['pending_products1']->merge($data['pending_products2']);

            $data['completed_products'] = Product::where('micro_process_status', 3)->with("departments")->whereHas("departments", function($q)use ($data){
              return $q->where("dept_id",1)->where('status','>',2)->whereRaw('YEAR(received_at)= ?', array($data['year']));
             })->get();

            return view('admin.micro.generalreport.index',$data);
           }

           public function generalyearly_report(Request $r){
           $data = $r->all();
           $data['product_types'] = \App\ProductType::all();
           $data['from_date'] = "2020-01-01";
           $data['to_date'] = now();
           $data['year'] = $r->year;


           $data['all_product_lab'] = Product::whereHas("departments", function($q)use ($data){
            return $q->where("dept_id",1)->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
          })->get();

          $data['all_pending_products'] = Product::whereHas("departments", function($q)use ($data){
            return $q->where("dept_id",1)->where("status",1)->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
          })->get();
          
          $data['all_recieved_products'] = Product::whereHas("departments", function($q)use ($data){
            return $q->where("dept_id",1)->where("status",'>',1)->whereRaw('YEAR(product_depts.created_at)= ? ',array($data['year']));
          })->get();


           $data['pending_products1'] = Product::whereHas("departments", function($q)use ($data){
            return $q->where("dept_id",1)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->where('micro_process_status','<>',3)->get();
          
          $data['pending_products2'] = Product::whereHas("departments", function($q)use ($data){
            return $q->where("dept_id",1)->where("status", '>',1)->whereRaw('YEAR(received_at)= ?', array($data['year']));
          })->WhereNull("micro_process_status")->get();

         $data['pending_products'] = $data['pending_products1']->merge($data['pending_products2']);

          $data['completed_products'] = Product::where('micro_process_status', 3)->with("departments")->whereHas("departments", function($q)use ($data){
            return $q->where("dept_id",1)->where('status','>',2)->whereRaw('YEAR(received_at)= ?', array($data['year']));
           })->get();

            return view('admin.micro.generalreport.index',$data);
           }

           public function completedreports_index($id){

            $data['ptype_id'] = $id;
            $data['completed_products'] = Product::where('micro_process_status', 3)->where('product_type_id',$id)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id", 1)->where("status",'>', 2);
            })->get();
            return view('admin.micro.generalreport.completedreports',$data);
           }

           public function pendingreports_index(Request $r, $id){

            $data['ptype_id'] = $id;
            $pending = Product::whereIn('id',$r->pending_product_ids)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id",1);
            })->pluck('id')->toArray();
            
             $data['dept1'] = Department::find(1)->products()->whereIn('product_id',$pending)->with('departments')->orderBy('status')->get();
         
            return view('admin.micro.generalreport.pendingreports',$data);
           }

       
           public function between_months(Request $r){


            $data = $r->all();
           
            if ($r->from_date == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required date to begin begin');
              return redirect()->route('admin.micro.general_report.index');
             }
      
            if ($r->to_date == null) {
              Session::flash('message_title', 'error');
              Session::flash('message', 'Please select required date to end report');
              return redirect()->route('admin.micro.general_report.index');
             }
       
             $data = $r->all();
             $data['product_types'] = \App\ProductType::all();

             $data['all_product_lab'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",1)->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
            })->get();

            $data['all_pending_products'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",1)->where("status",1)->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
            })->get();
            
            $data['all_recieved_products'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",1)->where("status",'>',1)->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
            })->get();



             $data['pending_products1'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",1)->where("status", '>',1)->whereDate('product_depts.received_at', '>=', $r->from_date)->whereDate('product_depts.received_at', '<=', $r->to_date);
            })->where('micro_process_status','<>',3)->get();
            
            $data['pending_products2'] = Product::whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",1)->where("status", '>',1)->whereDate('product_depts.received_at', '>=', $r->from_date)->whereDate('product_depts.received_at', '<=', $r->to_date);
            })->WhereNull("micro_process_status")->get();
  
           $data['pending_products'] = $data['pending_products1']->merge($data['pending_products2']);

            $data['completed_products'] = Product::where('micro_process_status', 3)->with("departments")->whereHas("departments", function($q)use ($r){
              return $q->where("dept_id",1)->where('status','>',2)->whereDate('product_depts.created_at', '>=', $r->from_date)->whereDate('product_depts.created_at', '<=', $r->to_date);
             })->get();

             
            return view('admin.micro.generalreport.index',$data);
           }

           public function microreport_pdf ($id){

            
            $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",'>',2);
            if(count($productdepts->get()) < 1){  
                 
              return redirect()->route('admin.micro.report.create');
            }  

            $data['report_id'] = $id; 
            $p = Product::Find($id);

            $data['micro_withcompletedproducts'] = Product::where('id',$id)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id", 1)->where("status", '>',2);
             })->with("loadAnalyses")->orderBy('id','DESC')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
      
            $data['microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
            $data['check_load'] = MicrobialLoadReport::where('product_id',$id)->orderBy('location')->get();

            $data['microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();

           
            // Send data to the view using loadView function of PDF facade

            $pdf = \PDF::loadView('admin.micro.downloads.report',$data);

            $pdf->save(storage_path().'_filename.pdf');

            return $pdf->download('microreport_'.$p->code.'.pdf',$id);

            // return view('admin.micro.downloads.report',$data);


           }
}
