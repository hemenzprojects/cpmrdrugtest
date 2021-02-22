@extends('admin.layout.main')

@section('content')
<?php 
$product = \App\Product::find($report_id);
?>

<div class="card-body">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="widget">
                <div class="widget-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="state">
                            <h6>Report(s) Withheld</h6>
                            @foreach ($hod_withhelds->groupBy('micro_hod_evaluation') as $result_evaluation) 
                           <h2>{{count($result_evaluation)}}</h2>
                        
                            @endforeach
                        </div>
                        <div class="icon">
                            <i class="ik ik-alert-circle"></i>
                        </div>
                    </div>
                    <small class="text-small mt-10 d-block">Total number of product withheld</small>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="widget">
                <div class="widget-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="state">
                            <h6> Approved Report(s)</h6>
                            @foreach ($hod_approvals->groupBy('micro_hod_evaluation') as $result_approved) 
                            <h2>{{count($result_approved)}}</h2>
                            @endforeach
                        </div>
                        <div class="icon">
                            <i class="ik ik-thumbs-up"></i>
                        </div>
                    </div>
                    <small class="text-small mt-10 d-block">Total number of report in Approved</small>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="widget">
                <div class="widget-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="state">
                            <h6>Completed Report(s) </h6>
                            @foreach ($completeds->groupBy('micro_hod_evaluation') as $result_completed) 
                            <h2>{{count($result_completed)}}</h2>
                            @endforeach
                        </div>
                        <div class="icon">
                            <i class="ik ik-calendar"></i>
                        </div>
                    </div>
                    <small class="text-small mt-10 d-block">Total number of report completed</small>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                </div>
            </div>
        </div>
    </div>

  </div>
<div class="row">
    <div class="col-md-4">
        
        <div class="card" >
            <form action="{{route('admin.micro.hod_office.evaluate')}}" method="post">
                {{ csrf_field() }} 
            <div class="card-header" style="border-color: #ffc107;" >
                @foreach($final_reports->groupBy('product_id') as $evaluation)
                <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                   {{count($evaluation)}} 
                </label>
                @endforeach
                <h3>Pending Reports</h3>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                        <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                        <li><i class="ik ik-minus minimize-card"></i></li>
                        <li><i class="ik ik-x close-card"></i></li>
                    </ul>
                </div>
            </div>
               <span class="" style="padding:5px">
                <input class="form-control" id="listSearch" type="text" placeholder="Type something to search list items">
                </span>
               
              <div class="card-body progress-task" style=" overflow-x: hidden;overflow-y: auto; height:800px; margin-bottom: 30px">
               
                    <ul class="list-group" id="myList">
                        @foreach($final_reports->sortBy('micro_process_status') as $evaluation)
                      <li class="list-group-item" style="padding: 1px;border:1px">
                        <div class="dd-handle">
                                
                            <div class="card-body feeds-widget">
                            <div class="feed-item">
                                <a href="{{url('admin/micro/hod_office/evaluate_one',['id' => $evaluation->id])}}">
                                    <div class="feeds-left">
                                        <div class="">
                                            <label class="custom-control custom-checkbox">
                                            <input type="checkbox" name="evaluated_product[]" class="custom-control-input" value="{{$evaluation->id}}">
                                                <span class="custom-control-label"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="feeds-body">
                                        <h4 class="">
                                              
                                                <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                    {{$evaluation->code}}
                                               </span>
                                           
                                              <span href="" class="badge pull-right">
                                              <p style="font-size: 10px;margin: 2px"></p>
                                              </span><br>
                                          
                                               <span><small class="float-right ">  <strong>Test:</strong> {{count($evaluation->loadAnalyses)}}mla
                                                @foreach ($evaluation->loadAnalyses->groupBy('id')->first() as $loadnalyses)
                                                @endforeach
                                                @if (count($evaluation->efficacyAnalyses)>0)
                                                & {{count($evaluation->efficacyAnalyses)}}ea
                                                @endif
                                                
                                              </small>
                                             </span><br>   
           
                                        </h4>
                                    
                                        <span>
                                           
                                        <small class="float-right font"><strong>Assigned: </strong>
                                            {{\App\Admin::find($evaluation->micro_analysed_by)? \App\Admin::find($evaluation->micro_analysed_by)->full_name:'null'}}
                                        </small><br>
                                        </span>
                                    
                                          <span>
                                          <small class="float-right font" style="margin-left: 5px"> 
                                              <strong>Evaluation: </strong> {!! $evaluation->final_hod_micro_evaluation !!}</small>
                                          </span>
                                              @if ($evaluation->micro_grade != null )
                                              <span>
                                                <small class="float-right font" style="margin: 0.5px"> <strong>Grade: </strong> {!! $evaluation->micro_grade_report !!}</small>
                                              </span>  
                                              @endif 

                                    </div>
                                </a>
                                <span class="float-right font" style="margin-top:10px">
                                    
                                     
                                </span>
                                <span style="font-size:10px" style="margin-top:10px">
                                    @foreach($evaluation->loadAnalyses as $temp)
                                    @if($evaluation->loadAnalyses->first() == $temp)
                                    {{$temp->created_at->format('d/m/y')}}
                                    @endif
                                    @endforeach
                                </span>
                            </div>
                            </div>
         
                        </div>
                          
                      </li>

                      @endforeach
                    </ul>
                 
              </div>
              <span style="padding: 10px;color:#007bff">
                <button type="submit" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.completed Reports can not be edited. Thank you')" class="badge badge-success">Complete</button>
                <a href="" class="text-dark" style="float: right; "></a>
            </span>
        </div>
       
       </form>
    </div>
    <div class="col-md-8">
        <div class="container">
            <div class="card" style="padding: 15px">
            
                <div class="text-center"> 
                <img src="{{asset('admin/img/logo.jpg')}}" class="" width="12%">
                <h5 class="font" style="font-size:16px"> Microbiology Department Centre for Plant Medicine Research </h5>
                <p class="card-subtitle">Microbial Analysis Report on Herbal Product</p>
               </div>
               
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                                <tr  class="table-warning">
                                    <th>Product Code</th>
                                    <th>Product Form</th>
                                    <th>Date Received</th>
                                    <th>Date Analysed</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($micro_withcompletedproducts as $completedproduct)
                                <tr>
                                     <td class="font">  {{$completedproduct->code}}</td>
                                    <td class="font">  {{$completedproduct->productType->name}}</td>
                                    <input type="hidden" name="micro_product_id" value="{{$completedproduct->id}}">
                                       <td class="font">
                                        @foreach (\App\ProductDept::where('product_id',$completedproduct->id)->where('dept_id',1)->get() as $item)
                                        {{$item->updated_at->format('d/m/Y')}}
                                        @endforeach
                                        </td>
                                    <td class="font"> {{$completedproduct->micro_dateanalysed}}</td>
                                </tr>
                               {{-- {{ $dept->pivot}} --}}
                               @endforeach 
                            </tbody>
                        </table>
                    </div>

                    <div class="card-heade" style="margin-top: 5%">
                        <h6>Microbial Load Analysis</h6>
                     </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                                <tr  class="table-warning">
                                    <th>Test Conducted</th>
                                    @if ($completedproduct->productType->state ==2)
                                    <th>Result (CFU/ml)</th>
                                    @endif
                                    @if ($completedproduct->productType->state ==1)
                                    <th >Result (CFU/g)</th>
                                    @endif
                                    <th>Accepted Criterion BP 
                                      (  @foreach($microbial_loadanalyses as $temp)
                                        @if($microbial_loadanalyses->first() == $temp)
                                        {{$temp->date_template}}
                                        @endif
                                        @endforeach)
                                    </th>
                                    <th>Compliance</th>

                                  
                                </tr>
                            </thead>
                        <tbody>
                            @if ($check_load->load_analyses_id ==1)
                            {{-- @foreach ($microbial_loadanalyses as $item) --}}
                            @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
                            <tr>
                                <td class="font">
                                    <?php
                                     if ($i<2) {
                                    $test_conducted= explode(' ',$microbial_loadanalyses[$i]->test_conducted);

                                    echo '<sup>';  print_r($test_conducted[0]);echo '</sup>';  print_r($test_conducted[1]);  print_r($test_conducted[2]); echo '<sup>'; print_r($test_conducted[3]);  echo '</sup>'; print_r($test_conducted[4]); print_r($test_conducted[5]);
                                     }else {
                                        $test_conducted =  $microbial_loadanalyses[$i]->test_conducted;
                                        print_r($test_conducted); 
                                     }   
                                   ?>
                                    
                                    {{-- {{$microbial_loadanalyses[$i]->test_conducted}} --}}
                                    <input type="hidden" class="form-control" name="loadanalyses" placeholder="Result" value="{{$microbial_loadanalyses[$i]->test_conducted}}">
                                </td>
                                <td class="font">
                                       
                                <p class="manycount{{$i}}" id="manycount{{$i}}" style="font-size: 13.4px">
                                    <?php 
                                    if ($i<2) {
                                        $results= explode(' ',$microbial_loadanalyses[$i]->result);
                                        $rs_part1 =$results[0];
                                        $rs_part2 = explode('^',$results[2]);
                                    
                                        print_r($rs_part1);  print_r(' x '); print_r($rs_part2[0]);  echo '<sup>';  print_r($rs_part2[1]);
                                        
                                    }
                                    else {
                                $results =  $microbial_loadanalyses[$i]->result;
                                print_r($results); 
                                }
                                    ?>
                                <p>
                                <input type="hidden" id="rstotal{{$i}}" value="{{$microbial_loadanalyses[$i]->rs_total}}">
                                

                                    {{-- <input type="text" required class="form-control {{$i<2?'date-inputmask':''}}" id="result_disabled{{$i}}" name="result[]"  placeholder="{{$i>1?'Result':''}}" value="{{$show_microbial_loadanalyses[$i]->result}}"> --}}

                                </td>
                                <td class="font">
                                    <?php 
                                    if ($i<2) {
                                      $acceptance_criterion= explode(' ',$microbial_loadanalyses[$i]->acceptance_criterion);
                                      $rs_part1 =$acceptance_criterion[0];
                                      $rs_part2 = explode('^',$acceptance_criterion[2]);
                                 
                                      print_r($rs_part1);  print_r(' x '); print_r($rs_part2[0]);  echo '<sup>';  print_r($rs_part2[1]);
                                       
                                    }else {
                                      $acceptance_criterion =  $microbial_loadanalyses[$i]->acceptance_criterion;
                                      print_r($acceptance_criterion); 
                                    }
                                  ?>
                                    {{-- {{($item->acceptance_criterion)}} --}}
                                </td> 
                                <td>
                                    {!! $microbial_loadanalyses[$i]->micro_compliance !!}
                                </td>                                                         
                            </tr>
                            @endfor
                            @endif
                        </tbody>
                       </table> 
                       
                       <div class="col-md-12" style="margin-top: 30px">
                        <strong><h6>General Conclusion:</h6></strong>
                        <p class="text-muted mb-0" style="margin-top: 15px">{!! $product->micro_load_conc !!} </p>
                     </div>
                    </div>

                    @if (($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0)
                      <div class="card-heade" style="margin-top: 5%">
                        <h6>Microbial Efficacy Analysis</h6>
                     </div> 
                  
                     
                    <div class="table-responsive">
                        
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead class="meatablehead">
                                <tr class="table-warning">
                                    <th>Pathogen</th>
                                    <th>PI Zone</th>
                                    <th>CI Zone</th>
                                    <th>FI Zone</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($microbial_efficacyanalyses as $efficacyanalyses)
                            
                                <tr>
                                    <td class="font ">{{$efficacyanalyses->pathogen}}</td>
                                    <input type="hidden" class="form-control" id="pi_zone" value="76899233403932{{$efficacyanalyses->efficacy_analyses_id}}">
                                    <td class="font">
                                       {{$efficacyanalyses->pi_zone}}
                                    </td>
                                    <td class="font">{{$efficacyanalyses->ci_zone}}</td>
                                    <td class="font">{{$efficacyanalyses->fi_zone}}</td>
                                </tr>
                             
                            @endforeach
                           </tbody>
                       </table>  
                    </div>
                    <div class="col-md-12" style="margin-top: 30px">
                        <strong><h6>General Conclusion:</h6></strong>
                        <p class="text-muted mb-0" style="margin-top: 15px">{!! $product->micro_efficacy_conc !!}</p><br>
                    </div>
                    @endif

                     <div class="row" style="margin: 0.5%; margin-top: 7%">
                        
                       
                        <div class="col-md-12">
                            <strong><h6>Report Grade:</h6></strong><p>{!! $product->micro_grade_report !!} </p><br><br>
                        </div>

                   </div>
                   <div class="row invoice-info" style="margin: 15px; margin-top:60px">
                    <?php
                        $micro_appoved_by = ($product? $product->micro_appoved_by:'');
                        $hod_user_type = (\App\Admin::find($micro_appoved_by)? \App\Admin::find($micro_appoved_by)->user_type_id:'');

                        ?>
                    <div class="col-sm-4 invoice-col">
                    
                        <p>Analysed by</p><br>
                        @if ($product->micro_hod_evaluation ==2)
                        <img src="{{asset(\App\Admin::find($micro_appoved_by)? \App\Admin::find($micro_appoved_by)->sign_url:'')}}" class="" width="42%"><br>
                        @endif

                        ------------------------------<br> 

                        <span>{{ucfirst(\App\Admin::find($micro_appoved_by)? \App\Admin::find($micro_appoved_by)->full_name:'')}}</span>
                        <p>{{ucfirst(\App\Admin::find($micro_appoved_by)? \App\Admin::find($micro_appoved_by)->position:'')}}</p>

                    </div> 
                    <div class="col-sm-4 invoice-col">
                         
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <?php
                        $micro_finalappoved_by = ($product? $product->micro_finalappoved_by:'');
                        $hod_user_type = (\App\Admin::find($micro_finalappoved_by)? \App\Admin::find($micro_finalappoved_by)->user_type_id:'');

                        ?>
                        <p>Approved by</p><br>
                        @if ($product->micro_finalappoved_by !== Null)
                        <img src="{{asset(\App\Admin::find($micro_finalappoved_by)? \App\Admin::find($micro_finalappoved_by)->sign_url:'')}}" class="" width="42%"><br>
                        @endif

                        ------------------------------<br> 

                        <span>{{ucfirst(\App\Admin::find($micro_finalappoved_by)? \App\Admin::find($micro_finalappoved_by)->full_name:'')}}</span>
                        <p>{{ucfirst(\App\Admin::find($micro_finalappoved_by)? \App\Admin::find($micro_finalappoved_by)->position:'')}}</p>
         
                    </div>
    
            </div>
            <div class="col-12">
          
                <div class="row" style="margin-top: 110px">
                    <div class="col-md-4">
                        @if ($product->micro_hod_evaluation ===2 && $product->micro_process_status ===1 ) 
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="ik ik-clipboard"></i> Evaluate Report</button>
                        @endif
                    </div>
                    <div class="col-md-8">
                        @if ($product->micro_process_status ===2) 
                        <div class="alert alert-danger" role="alert">
                            Report of {{$product->code}}  has been rejected.
                        </div>       
                       @endif
                    </div>
                      <div class="col-md-7" style="margin-right: 1%">
                          
                      
                          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document"> 
                            
                                   <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalCenterLabel">Please Sign to evaluate report</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                      </div>
                                      <div class="modal-body">
                                          <form  id="microhodfinalapproveform" sign-user-url="{{route('admin.micro.hod_office.finalapproval.checkhodsign')}}" action="{{route('admin.micro.hod_office.finalapproval.evaluatereport',['id' => $report_id])}}" class="" method="POST">
                                              {{ csrf_field() }}
                                          <input id ="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
          
                                          <div class="input-group input-group-default col-md-6">
                                              <select class="form-control" name="evaluate">
                                                  <option value="2">Approve Report</option>
                                                  <option value="1">Reject Report</option>
                                              </select>
                                              </div>
                                              <div id="error-div" style="margin: 5px; color:red;"></div>
                                              <input name="adminid" id="adminid"  type="hidden" >
                      
                                              <div class="input-group input-group-default">
                                                  @error('email')
                                                  <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                                      <strong>{{$message}}</strong>
                                                  </small>
                                                  @enderror
                                                  <span class="input-group-prepend"><label class="input-group-text"><i class="ik ik-shield"></i></label></span>
                                                  <input required id="useremail" type="email" class="form-control" name="email" placeholder="Enter your email">
                                              </div>
                      
                                              <div class="input-group input-group-default">
                                                  @error('password')
                                                  <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                                      <strong>{{$password}}</strong>
                                                  </small>
                                                  @enderror
                                                  <span class="input-group-prepend"><label class="input-group-text"><i class="ik ik-shield"></i></label></span>
                                                  <input required id="userpassword" type="password" class="form-control" name="password" placeholder="Sign with password">
                                              </div>                         
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-primary">Sign Report</button>
                                      </div>
                                  </form>
                                  </div>
                              </div>
                          </div>
                        </div>
                     <div class="col-md-4">  
                        @if ($product->micro_hod_evaluation ===2 && $product->micro_process_status ===3) 
                        
                      <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#exampleModalCenter">  Reject </button>
                      <a onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.Completed Reports can not be edited after submision, you would be required to see system Administrator for unavoidable complains or changes.  Thank you')" target="_blank" href="{{url('admin/pharm/report/hod_office/complete_report',['id' => $report_id])}}">
                      <button type="button" class="btn btn-success pull-right"> Complete </button>
                     </a>
                      @endif
                  </div>
                </div>
            </div>
        
        </div>

    </div>
   
    </div>
</div>
@endsection

