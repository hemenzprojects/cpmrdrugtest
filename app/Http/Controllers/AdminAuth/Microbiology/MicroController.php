<?php

namespace App\Http\Controllers\AdminAuth\Microbiology;

use Illuminate\Http\Request;
use App\Http\Requests\AcceptMircoProductRequest;
use App\Http\Requests\MicroTestCreateRequest;
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
          
          $data['dept1'] = Department::find(1)->products()->with('departments')->orderBy('status')->get();

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
                        
            $data = 
            [ 
            'status' => $status,
            'received_by' => $adminId,
            'delivered_by' => $delivered_by,
            'received_at' => \Carbon\Carbon::now(),
            ];
           
            ProductDept::whereIN('product_id', $deptproduct_id)->where("dept_id", 1)->where("status", '<', 3)->update($data);

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

                $data['microproduct_withtests'] = Product::where('micro_analysed_by',Auth::guard('admin')->id())->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
    
                $data['microproduct_completedtests'] = Product::where('micro_analysed_by',Auth::guard('admin')->id())->with('departments')->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 4);
                })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->limit(100)->get();

                return View('admin.micro.createreport', $data); 
              }

              public function test_create(MicroTestCreateRequest $r){

                
                $input = $r->all();

                if (($r->microbialcount == 3) && ($r->loadanalyses == 1)) {
                  Session::flash('message_title', 'error');
                  Session::flash('message', 'Sytem requires you to re-input data due to multiple checked boxes (Both Microbial Load and Too many Microbial count field were checked please rectify) Thank you');
                  return redirect()->back();
                }
                   
                $test_conducted = [];
                $result = [];
                $acceptance_criterion = [];
                $mlcompliance = [];

                $pathogen = [];
                $pi_zone = [];
                $ci_zone = [];
                $fi_zone = [];
                
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

               }
            

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
              }
    

                if($r->loadanalyses){
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
                          'product_id'=>$r->micro_product_id,
                          'rs_total'=>$rs_total,
                          'result'=>$result[$i],
                          'acceptance_criterion'=>$acceptance_criterion[$i],
                          'compliance'=>$mlcompliance[$i],
                          'ac_total'=>$ac_total,
                          'date_template'=>$r->date_template,
                          'added_by_id' => Auth::guard('admin')->id(),
                          'load_analyses_id'=>$r->loadanalyses,
                          'created_at' => \Carbon\Carbon::now(),
                          'updated_at' => \Carbon\Carbon::now(),
                      ]);
             
                    }else{
                        MicrobialLoadReport::create([
                          'test_conducted'=>$test_conducted[$i],
                          'product_id'=>$r->micro_product_id,
                          'result'=>$result[$i],
                          'acceptance_criterion'=>$acceptance_criterion[$i],
                          'compliance'=>$mlcompliance[$i],
                          'ac_total'=>$ac_total,
                          'date_template'=>$r->date_template,
                          'added_by_id' => Auth::guard('admin')->id(),
                          'load_analyses_id'=>$r->loadanalyses,
                          'created_at' => \Carbon\Carbon::now(),
                          'updated_at' => \Carbon\Carbon::now(),
                          ]);
                        }

                     }

                    }
                  
                  if($r->efficacyanalyses){
                  for ($j=0; $j < count($pi_zone); $j++) { 
                          MicrobialEfficacyReport::create([
                          'efficacy_analyses_id'=>$r->efficacyanalyses,
                          'product_id'=>$r->micro_product_id,
                          'pathogen'=>$pathogen[$j],
                          'pi_zone'=>$pi_zone[$j],
                          'ci_zone'=>$ci_zone[$j], 
                          'fi_zone'=>$fi_zone[$j],
                          'added_by_id' => Auth::guard('admin')->id(),
                          'created_at' => \Carbon\Carbon::now(),
                          'updated_at' => \Carbon\Carbon::now(),
                          ]);
                         
                       }
                   }
                  
                    
                $mp_id = $input['micro_product_id'];

                $productdepts = ProductDept::where('product_id',$mp_id)->where("dept_id", 1)->where("status",2);
                if(count($productdepts->get()) < 1){
                    
                    return redirect()->back();
                }
    
                $productdept = $productdepts->first();
                $productdept->status = 3;
                $productdept->update();

                $products= Product::where('id',$mp_id);
                if(count($products->get()) < 1){
                    return redirect()->back();
                }
                $product = $products->first();
                $product->micro_analysed_by = Auth::guard('admin')->id();
                $product->update();
              
                  Session::flash("message", "Report Successfully Stored, Proceed to complete.");
                  Session::flash("message_title", "success");
                  return redirect()->route('admin.micro.report.create');
            }

              public function report_show(MicrobialLoadReport $microbialReport, $id)
              { 
                $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",3);
                if(count($productdepts->get()) < 1){     
                  return redirect()->route('admin.micro.report.create');
                }

                $data['report_id'] = $id;              
                $data['MicrobialEfficacyform'] = MicrobialEfficacyAnalyses::all();
                $data['show_productdept'] = productDept::where('product_id',$id)->where('status',3)->where('dept_id',1)->get();
          
                $data['show_microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
               
                $data['show_microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();

                 return view('admin.micro.showreport', $data);
          
              }



              public function report_update(request $r, $id)
              {
                $input = $r->all();
              //  dd($input);
               $ml_testconducteds = $r->test_conducted;
               $mc_testconducteds= $r->mc_test_conducted;
               $mlr_ids =  $r->mltest_id;

               $mer_ids =  $r->metest_id;
               $mlmc_ids =  $r->mlmc_ids;
               $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",3);
                if(count($productdepts->get()) < 1){     
                    return redirect()->back();
                }
                $productdept = $productdepts->first();
                $productdept->status = 3;
                $productdept->update();
              
                   if($r->loadanalyses){
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
                        // $products = Product::where('id',$id);
                        // if(count($productdepts->get()) < 1){
                        //   return redirect()->back();
                        // }
                        // $product = $products->first();
                        // $product->micro_la_conclution =$r->micro_comment;
                        // $product->micro_ea_conclution =$r->micro_conclution;
                        // $product->micro_dateanalysed =$r->date_analysed;
                        // $product->update();
                     }
                
                        if($r->efficacyanalyses_form){
                         for ($k=0; $k < count($r->metestform_id); $k++) { 
                         $data1 = ([
                          'efficacy_analyses_id'=>2,
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
                       }

                       if($r->efficacyanalyses_update){
                        $l = 0;
                        $count1 = count($input['metest_id']);
                        while($l < $count1){
                        DB::table('microbial_efficacy_reports')->where('id', $mer_ids[$l])
                              ->update([
                                'efficacy_analyses_id'=>2,
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
                      }

                  $products =Product::where('id', $id)->with("departments")->whereHas("departments", function($q){
                  return $q->where("dept_id", 1)->where("status", 3);
                  })->with("loadAnalyses")->orderBy('id','DESC')->whereHas("loadAnalyses")->with('efficacyAnalyses');
                    if(count($products->get()) < 1){     
                      return redirect()->back();
                    }

                  $product = $products->first();
                  $product->micro_ea_conclution = $r->micro_ea_conclution;
                  $product->micro_la_conclution = $r->micro_la_conclution;
                  $product->micro_grade = $r->micro_grade;
                  $product->micro_hod_evaluation = 0;
                  $product->micro_dateanalysed =$r->date_analysed;
                  $product->micro_analysed_by = Auth::guard('admin')->id();
                  

                  $product->update();
                 
                  Session::flash("message", "Report Successfully completed and updated.");
                  Session::flash("message_title", "success");
                
                  return redirect()->back();

              }
              
              public function report_delete($id){
            
                   $product = Product::where('id',$id)->where('micro_hod_evaluation','=',2)->whereHas("departments", function($q){
                    return $q->where("dept_id", 1)->where("status", 3);
                    })->first();
                    if($product){
                      Session::flash('message_title', 'error');
                      Session::flash('message', 'Sorry product can not be deleted.');     
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
                  'micro_hod_evaluation'=>Null,
                  'micro_dateanalysed'=>Null,
                  'micro_la_conclution'=>Null,
                  'micro_ea_conclution'=>Null,
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
                 })->with("loadAnalyses")->orderBy('id','DESC')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
          
                $data['microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
                $data['check_load'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->first();

                $data['microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();
               
                 return view('admin.micro.completedreport',$data);
  
              }

              //***********************HoD Office */
  

             public function hodoffice_evaluation(){
              
               $data['evaluations'] = Product::where('micro_hod_evaluation','!=',Null)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

              $data['completeds'] = Product::with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 4);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

              $data['withhelds'] = Product::where('micro_hod_evaluation',1)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

              $data['approvals'] = Product::where('micro_hod_evaluation',2)->with('departments')->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
              })->with('loadAnalyses')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();

              return view('admin.micro.hodoffice.evaluation',$data);

              }

             public function evaluate(Request $r){
                 $input = $r->all(); 
          
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

              $products = Product::whereIn('id',$r->evaluated_product)->where("micro_hod_evaluation", 2)->with('departments')->whereHas("departments", function($q){
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

              $productdepts->update(['status' => 4]);
              }

              Session::flash("message", "Report Evaluation completed.");
              Session::flash("message_title", "success");
            
              return redirect()->back();
             }
            
              public function evaluate_one_index($id){
              
             $productdepts = ProductDept::where('product_id',$id)->where("dept_id", 1)->where("status",3);
              if(count($productdepts->get()) < 1){     
                return redirect()->route('admin.micro.hod_office.approval');
              }  

              $data['report_id'] = $id; 
        
              $data['micro_withcompletedproducts'] = Product::where('id',$id)->with("departments")->whereHas("departments", function($q){
                return $q->where("dept_id", 1)->where("status", 3);
               })->with("loadAnalyses")->orderBy('id','DESC')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
        
              $data['microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
              $data['check_load'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->first();

              $data['microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();
           
              return view('admin.micro.hodoffice.showreport',$data);
             }

            public function evaluate_one_edit(Request $r, $id){

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
              

              $p= Product::find($id);
              $p->update([
                'micro_hod_evaluation'=> $r->evaluate,
                'micro_appoved_by'=>$r->adminid,
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

            public function hod_complete_report($id){

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
              $data['check_load'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->first();

              $data['microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();
              

               return view('admin.micro.completedreport',$data);

              }
           
            public function checkhodsign(Request $request){
             
              $userEmail = $request->get('email');
              $adminPassword = $request->get('password');

              $checkmailonly = Admin::where('dept_id',1)->where('email', '=', $userEmail)->first();
              $admin = Admin::where('dept_id',1)->where('dept_office_id',1)->where('email', '=', $userEmail)->first();

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

            public function hodoffice_config(){
   
              $data['microbial_efficacys'] = MicrobialEfficacyAnalyses::all();
              $data['microbial_loadanalyses'] = MicrobialLoadAnalyses::all();

              return view('admin.micro.hodoffice.config',$data);
            }

            public function microbialanalysis_create(request $r){
              $data = $r->validate([
                'test_conducted' => 'required', 
                'result' => 'required', 
                'acceptance_criterion' => 'required',          
              ]);

               $data = ([
                'test' => $r->test,
                'result' => $r->result,
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
               'ci_zone' => $r->pi_zone,
               'fi_zone' => $r->pi_zone,
               'added_by_id' => Auth::guard('admin')->id(),
              ]);

              MicrobialEfficacyAnalyses::create($data);
              return redirect()->back();
           }


            public function microbialanalysis_update(request $r){
              $data = $r->validate([
                'date' => 'required',          
              ]);

              
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
          'date' => $r->date,
          'added_by_id' => Auth::guard('admin')->id(),
          'created_at' => \Carbon\Carbon::now(),
          ];
         
          MicrobialLoadAnalyses::whereIN('id', $r->microbial_loadanalyse_id)->update($data);
          MicrobialLoadAnalyses::whereNotin('id',$r->microbial_loadanalyse_id)->update(['action' =>0]);
          Session::flash("message", "Template updated successfully");
          Session::flash("message_title", "success");  
          return redirect()->back();
           }

           public function microbialefficacy_update(request $r){
     
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
          
           MicrobialEfficacyAnalyses::whereIN('id', $r->microbial_efficacy_id)->update($data);
           MicrobialEfficacyAnalyses::whereNotin('id',$r->microbial_efficacy_id)->update(['action' =>0]);
           Session::flash("message", "Template updated successfully");
           Session::flash("message_title", "success");  
           return redirect()->back();
            }


            
           // ********************************* General Report Section *********************************//

           public function completedreport_show($id){
            $productdepts = ProductDept::where('product_id', $id)->where("dept_id",3)->where("status",4);
            if(count($productdepts->get()) < 1){     
             return redirect()->back(); 
             }
            $data['report_id'] = $id; 

            $data['micro_withcompletedproducts'] = Product::where('id',$id)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id", 1)->where("status", '>', 2);
             })->with("loadAnalyses")->orderBy('id','DESC')->whereHas("loadAnalyses")->with('efficacyAnalyses')->get();
      
            $data['microbial_loadanalyses'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->get();
            $data['check_load'] = MicrobialLoadReport::where('product_id',$id)->orderBy('id','ASC')->first();

            $data['microbial_efficacyanalyses'] = MicrobialEfficacyReport::where('product_id',$id)->orderBy('id','ASC')->get();
            

             return view('admin.micro.completedreport',$data);

            }

           public function generalreport_index(){
           
            $data['product_types'] = \App\ProductType::all();

            $data['from_date'] = "2020-01-01";
            $data['to_date'] = now();
            
           $data['pending_products'] = Product::where('micro_hod_evaluation', '<', 2)->orwhere('micro_hod_evaluation',Null)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id",1);
            })->get();
            $data['completed_products'] = Product::where('micro_hod_evaluation', 2)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id",1)->where('status','>',1)->where('status','>',2);
            })->get();

            return view('admin.micro.generalreport.index',$data);
           }

           public function generalyearly_report(Request $r){
          
          $data = $r->all();
           $data['product_types'] = \App\ProductType::all();

             $data['pending_products'] = Product::where('micro_hod_evaluation', '<', 2)->with("departments")
           ->whereHas("departments", function($q)use($data){
              return $q->where("dept_id",1)->whereRaw('YEAR(received_at)= ? ',array($data['year']));
            })->get();
            $data['completed_products'] = Product::where('micro_hod_evaluation', 2)->with("departments")
            ->whereHas("departments", function($q)use($data){
              return $q->where("dept_id",1)->whereRaw('YEAR(received_at)= ? ',array($data['year']));
            })->get();

            return view('admin.micro.generalreport.index',$data);
           }

           public function completedreports_index($id){

            $data['ptype_id'] = $id;
            $data['completed_products'] = Product::where('micro_hod_evaluation', 2)->where('product_type_id',$id)->with("departments")->whereHas("departments", function($q){
              return $q->where("dept_id", 1)->where("status",'>', 2);
            })->get();
            return view('admin.micro.generalreport.completedreports',$data);
           }

           public function yearly_report(Request $r){

            $data = $r->all();
            $data['ptype_id'] = $r->product_type;
             $data['completed_products'] = Product::where('product_type_id',$data['product_type'])->with('departments')->whereRaw('YEAR(created_at)= ? ',array($data['year']))->whereHas("departments", function($q){
              return $q->where("dept_id", 1)->where("status", 4);
            })->get();

            return view('admin.micro.generalreport.completedreports',$data);
           }

           public function monthly_report(Request $r){

            $data = $r->all();
            $data['ptype_id'] = $r->product_type;
             $data['completed_products'] = Product::where('product_type_id',$data['product_type'])->with('departments')->whereRaw('YEAR(created_at)= ? and MONTH  (created_at)=?',array($data['year'],$data['month']))->whereHas("departments", function($q){
              return $q->where("dept_id", 1)->where("status", 4);
            })->get();

            return view('admin.micro.generalreport.completedreports',$data);

           }

           public function daily_report(Request $r){

            return   $data['completed_products'] = Product::where('product_type_id',$r->product_type)->with('departments')->whereRaw('YEAR(created_at)= ? and MONTH  (created_at)=? and DAY (created_at)=?',array($r->year,$r->month,$r->day))->whereHas("departments", function($q){
              return $q->where("dept_id", 1)->where("status", 4);
            })->get();

            return view('admin.micro.generalreport.completedreports',$data);
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

              $data['pending_products'] = Product::where('micro_hod_evaluation', '<', 2)->with("departments")
              ->whereHas("departments", function($q)use($r){
               return $q->where("dept_id",1)->whereDate('received_at', '>=', $r->from_date)->whereDate('received_at','<=',$r->to_date);
              })->get();
              
               $data['completed_products'] = Product::where('micro_hod_evaluation', 2)->with("departments")
              ->whereHas("departments", function($q)use($r){
                return $q->where("dept_id",1)->whereDate('received_at', '>=', $r->from_date)->whereDate('received_at','<=',$r->to_date);
              })->get();

            return view('admin.micro.generalreport.index',$data);
           }
}
