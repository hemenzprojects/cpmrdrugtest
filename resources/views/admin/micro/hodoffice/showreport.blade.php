@extends('admin.layout.main')

@section('content')
<div class="row">

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
                                     <td class="font">  {{$completedproduct->productType->code}}|{{$completedproduct->id}}|{{$completedproduct->created_at->format('y')}}</td>
                                    <td class="font">  {{$completedproduct->productType->name}}</td>
                                    <input type="hidden" name="micro_product_id" value="{{$completedproduct->id}}">
                                       <td class="font">
                                        @foreach (\App\ProductDept::where('product_id',$completedproduct->id)->where('dept_id',1)->get() as $item)
                                        {{$item->updated_at->format('d/m/Y')}}
                                        @endforeach
                                        </td>
                                    <td class="font"> {{$completedproduct->micro_dateanalysed}}  </td>
                                    
                                </tr>
                               {{-- {{ $dept->pivot}} --}}
                               @endforeach 
                            </tbody>
                        </table>
                    </div>

             
                    <div class="card-header d-block">
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
                                    <th>Accepted Criterion (BP, 2016)</th>
                                  
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
                            </tr>
                            @endfor
                            @endif

                            @if ($check_load->load_analyses_id ==3)
                            @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
                            <tr>
                                <td class="font">
                                    {{$microbial_loadanalyses[$i]->test_conducted}}
                                    <input type="hidden" class="form-control" name="loadanalyses" placeholder="Result" value="{{$microbial_loadanalyses[$i]->test_conducted}}">
                                </td>
                                <td class="font">
                                   {{$microbial_loadanalyses[$i]->result}}
                                </td>
                                <td class="font">
                                    {{$microbial_loadanalyses[$i]->acceptance_criterion}}
                                </td>                                                          
                            </tr>
                            @endfor
                           @endif
                        </tbody>
                       </table>  
                    </div>
                

               

                    @if (($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0)
                      <div class="card-heade" style="margin: 2%">
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
                    @endif

                     <div class="row" style="margin-top: 4%">
                         <div class="col-md-12">
                            <strong><span>General Comment:</span></strong>
                            <p>{{\App\Product::find($report_id)->micro_comment}} </p>
                         </div>
                        <div class="col-md-12">
                            <strong><span>Conclusion:</span></strong>
                            <p>{{\App\Product::find($report_id)->micro_conclution}} </p><br><br>
                        </div>
                   </div>
                    <div class="row invoice-info" style="margin: 15px">


                        <div class="col-sm-4 invoice-col">
                            <?php
                            $micro_analysed_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->micro_analysed_by:'');
                            $user_type         = (\App\Admin::find($micro_analysed_by)? \App\Admin::find($micro_analysed_by)->user_type_id:'');
                          ?>
                            <p>Analyzed By</p><br>
                            @if (\App\Product::find($report_id)->micro_hod_evaluation >null)
                            <img src="{{asset(\App\Admin::find($micro_analysed_by)? \App\Admin::find($micro_analysed_by)->sign_url:'')}}" class="" width="42%"><br>
                            @endif
                            -----------------------------<br>
                          
                            <span>{{ucfirst(\App\Admin::find($micro_analysed_by)? \App\Admin::find($micro_analysed_by)->full_name:'')}}</span>
                            <p>{{ucfirst(\App\UserType::find($user_type )? \App\UserType::find($user_type )->name:'')}}</p>

                        </div> 
                        <div class="col-sm-4 invoice-col">
                           
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <?php
                            $micro_appoved_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->micro_appoved_by:'');
                            $hod_user_type = (\App\Admin::find($micro_appoved_by)? \App\Admin::find($micro_appoved_by)->user_type_id:'');

                            ?>
                            <p>Supervisor</p><br>
                            @if (\App\Product::find($report_id)->micro_hod_evaluation ==2)
                            <img src="{{asset(\App\Admin::find($micro_appoved_by)? \App\Admin::find($micro_appoved_by)->sign_url:'')}}" class="" width="42%"><br>
                            @endif

                            ------------------------------<br> 
                         
                          <span>{{ucfirst(\App\Admin::find($micro_appoved_by)? \App\Admin::find($micro_appoved_by)->full_name:'')}}</span>
                          <p>{{ucfirst(\App\UserType::find($hod_user_type)? \App\UserType::find($hod_user_type)->name:'')}}</p>
             
                        </div>

                    </div>
    
            </div>
            <div class="col-12">
              <div class="row">
                  <div class="col-md-6" style="margin-right: 16%">
                    @if (\App\Product::find($report_id)->micro_hod_evaluation <2)
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="fa fa-credit-card"></i> Approve Report</button>
                    @endif
                    @if (\App\Product::find($report_id)->micro_hod_evaluation ==2) 
                   <a href="{{ old('redirect_to', URL::previous())}}">
                    <div class="alert alert-success" role="alert">
                        Report succesfully completed. Final report of {{\App\Product::find($report_id)->productType->code}}|{{\App\Product::find($report_id)->id}}|{{\App\Product::find($report_id)->productType->created_at->format('y')}}  will be printed by SID 
                    </div>
                   </a>
                   
                   @endif
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                         
    
                             <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterLabel">Please Sign to evaluate report</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <form  id="hodapproveform" sign-user-url="{{route('admin.micro.hod_office.checkhodsign')}}" action="{{route('admin.micro.hod_office.evaluatereport',['id' => $report_id])}}" class="" method="POST">
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
                       @if (\App\Product::find($report_id)->micro_hod_evaluation ==2) 
                      
                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#exampleModalCenter">  Reject Report</button>
                   <a target="_blank" href="{{url('admin/micro/completedreport/show',['id' => $report_id])}}">
                    <button type="button" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.Completed Reports can not be edited after submision, you would be required to see system Administrator for unavoidable complains or changes.  Thank you')" class="btn btn-success pull-right">  Complete Report</button>
                   </a>
                    @endif
                </div>
             </div>
            </div>
        
        </div>

               

</div>

@endsection

