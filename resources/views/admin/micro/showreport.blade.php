@extends('admin.layout.main')

@section('content')
        <div class="container-fluid">
            <div class="card" style="padding: 15px">
            <form action="{{url('admin/micro/report/update',['id' => $report_id])}}" method="POST">
                    {{ csrf_field() }} 
                <div class="text-center"> 
                <img src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
                <h5 class="font" style="font-size:16px"> Microbiology Department Centre for Plant Medicine Research </h5>
                <p class="card-subtitle">Microbial Analysis Report on Herbal Product</p>
               </div>
                <form action=""> 
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap dataTable" >
                            <thead>
                                <tr  class="table-warning">
                                    <th>Product Code</th>
                                    <th>Product Form</th>
                                    <th>Date Received</th>
                                    <th>Date Analysed</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($show_productdept as $showproduct)
                                  <tr>
                                      <td class="font"> {{\App\Product::find($showproduct->product_id)->productType->code}}|{{\App\Product::find($showproduct->product_id)->id}}|{{\App\Product::find($showproduct->product_id)->created_at->format('y')}}</td>
                                      <td class="font"> {{\App\Product::find($showproduct->product_id)->productType->name}}</td>
                                      <td class="font">
                                      
                                        @foreach (\App\ProductDept::where('product_id',$report_id)->where('dept_id',1)->get() as $item)
                                        {{$item->updated_at->format('d/m/Y')}}
                                        @endforeach
                                        
                                      </td>
                                      <td class="font">
                                        <input class="form-control" required="required" type="date" placeholder="Date" name="date_analysed" value="{{\App\Product::find($showproduct->product_id)->micro_dateanalysed}}">
                                       </td>
                                       <input type="hidden" name="micro_product_id" value="{{\App\Product::find($showproduct->product_id)->id}}">
                                       <input type="hidden" id="product_typestate" value="7777{{\App\Product::find($showproduct->product_id)->productType->state}}">
                                       <input class="form-control" type="hidden" id="product_status" value="811920012{{$showproduct->status}}">
                                  </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                @foreach ($show_microbial_loadanalyses->groupBy('id')->first() as $load_analyses_state)
                <input type="hidden" class="form-control" id="load_analyses_id" name="load_analyses_id" value="{{($load_analyses_state)->load_analyses_id? ($load_analyses_state)->load_analyses_id:'null'}}">
                @endforeach

                    <div class="card-header"><h3>Microbial <strong>Load</strong> Analysis</h3></div>
                        {{-- this table is for too manny microbial count --}}
                    <div class="table-responsive ">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                                <tr  class="table-info">
                                    
                                    <th>Test Conducted</th>
                                    <th class="77772" style="display: none">Result (CFU/ml)</th>
                                    <th class="77771" style="display: none">Result (CFU/g)</th>
                                    <th>Accepted Criterion (BP, 2016)</th>
                                  
                                </tr>
                            </thead>
                           <tbody class="3" style="display: none">
                           
                            @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
                              <tr>
                                <input type="hidden" name="mlmc_ids[]" value="{{$show_microbial_loadanalyses[$i]->id}}" class="custom-control-input" checked="">
                                <td class="font">
                                    {{$show_microbial_loadanalyses[$i]->test_conducted}}
                                    <input type="hidden" class="form-control" name="mc_test_conducted[]"  value="{{$show_microbial_loadanalyses[$i]->test_conducted}}">
                                </td>
                                <td class="font">
                                    <input type="text" required class="form-control" name="mc_result[]"  placeholder="{{$i>1?'Manny count Result':''}}" value="{{$show_microbial_loadanalyses[$i]->result}}">
                                </td>
                                <td class="font">
                               
                                    <input type="text" required class="form-control" name="mc_acceptance_criterion[]"  placeholder="{{$i>1?'Acceptance Criterion':''}}" value="{{$show_microbial_loadanalyses[$i]->acceptance_criterion}}">
                                </td>
                                
                            <input type="hidden" required class="custom-control-input" id="mannycount_loadanalyses{{$i}}" name="mannycount_loadanalyses" value="{{$show_microbial_loadanalyses[$i]->load_analyses_id}}">
                                
                            </tr>
                            @endfor
                            </tbody>

                            {{-- Load analyses table without many count --}}
                            <tbody class="1">
                           
                              @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)

                              <tr>
                                <input type="hidden" name="mltest_id[]" value="{{$show_microbial_loadanalyses[$i]->id}}" class="custom-control-input" checked="">
                        
                                <td class="font">
                                    {{$show_microbial_loadanalyses[$i]->test_conducted}}
                                    <input type="hidden" class="form-control" name="test_conducted[]"  value="{{$show_microbial_loadanalyses[$i]->test_conducted}}">

               
                                     
                                </td> 
                                <td class="font">
                                    @if ($i<2)
                                    <p class="manycount{{$i}}" id="manycount{{$i}}" style="font-size: 12px">
                                        <?php 
                                        if ($i<2) {
                                          $results= explode(' ',$show_microbial_loadanalyses[$i]->result);
                                          $rs_part1 =$results[0];
                                          $rs_part2 = explode('^',$results[2]);
                                     
                                          print_r($rs_part1);  print_r(' x '); print_r($rs_part2[0]);  echo '<sup>';  print_r($rs_part2[1]);
                                           
                                        }
                                      ?>
                                    <p>
                                    <input type="hidden" id="rstotal{{$i}}" value="{{$show_microbial_loadanalyses[$i]->rs_total}}">
                                    @endif
                                 <input type="text" required class="form-control {{$i<2?'date-inputmask':''}}" id="result_disabled{{$i}}" name="result[]"  placeholder="{{$i>1?'Result':''}}" value="{{$show_microbial_loadanalyses[$i]->result}}">
                              
                                <input type="hidden" class="form-control" id="rs_total{{$i}}" value="{{$show_microbial_loadanalyses[$i]->rs_total}}">

                                </td>
                                <td class="font">
                                    @if ($i<2)
                                    <p class="" style="font-size: 12px"> 
                                        <?php 
                                        if ($i<2) {
                                          $acceptance_criterion= explode(' ',$show_microbial_loadanalyses[$i]->acceptance_criterion);
                                          $rs_part1 =$acceptance_criterion[0];
                                          $rs_part2 = explode('^',$acceptance_criterion[2]);
                                     
                                          print_r($rs_part1);  print_r(' x '); print_r($rs_part2[0]);  echo '<sup>';  print_r($rs_part2[1]);
                                           
                                        }
                                       ?>
                                    </p>
                                <input type="hidden" value="{{$show_microbial_loadanalyses[$i]->ac_total}}">
                                @endif
                                <input type="text" required class="form-control {{$i<2?'date-inputmask':''}}" id="criterion_disabled{{$i}}" name="acceptance_criterion[]"  placeholder="{{$i>1?'Acceptance Criterion':''}}"  value="{{$show_microbial_loadanalyses[$i]->acceptance_criterion}}">
                                <input type="hidden" class="form-control" id="ac_total{{$i}}" value="{{$show_microbial_loadanalyses[$i]->ac_total}}">
                                </td>
                                
                                <input type="hidden"  class="form-control" id="load_analyses{{$i}}" name="loadanalyses" value="{{$show_microbial_loadanalyses[$i]->load_analyses_id}}">
                                
                             </tr>
                            @endfor
                        </tbody>
                       </table>  
                    </div>
                
                    <div class="checkefficacy1 col-sm-3">
                        <label class="custom-control custom-checkbox" >
                            <input type="checkbox" class=" custom-control-input" name="efficacyanalyses_form" id="check_efficacy2" value="243123">
                            <span class="custom-control-label">&nbsp;Microbial Efficacy Analysis Form</span>
                        </label>
                    </div>

                    <div class="243123" style="display: none">
                        <div class="card">
                            <div class="card-header d-block">
                            </div>
                            <div class="card-body p-0 table-border-style">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-warning">
                                            <tr>
                                                <th>#</th>
                                                <th>Pathogen</th>
                                                <th>Product IZone</th>
                                                <th>Ciprofloxacin IZone</th>
                                                <th>Fluconazole IZone</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($MicrobialEfficacyform as $metest)
                                            <tr>
                                                <td class="font">
                                                    
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="metestform_id[]" value="{{$metest->id}}" class="custom-control-input" checked="true">
                        
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label> 
                                                    
                                                </td>
                                                <td class="font">{{$metest->pathogen}}</td>
                                                <input type="hidden" class="form-control" name="pathogen_form[]" value="{{$metest->pathogen}}">

                                                <td class="font">
                                                    <input type="number" class="form-control" required name="pi_zoneform[]" placeholder="PI Zone" value="{{$metest->pi_zone}}">
                                                </td>
                                                <td class="font" class="form-control">                                                    
                                                    <input type="number" class="form-control" name="ci_zoneform[]"  value="{{$metest->ci_zone}}">
                                                </td>
                                                <td class="font">
                                                    <input type="number" class="form-control" name="fi_zoneform[]"  value="{{$metest->fi_zone}}">
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> 
                    @if (($show_microbial_efficacyanalyses) && count($show_microbial_efficacyanalyses)>0) 
                       <div class="table-responsive">  
                            <div class="card-heade" style="margin: 2%">
                            <h6>Microbial Efficacy Analysis</h6>
                            </div>
                            
                             <table class="table table-striped table-bordered nowrap dataTable">
                                <thead class="meatablehead 768992334039322" style="display: none">
                                    <tr class="table-info">
                                        <th>Pathogen</th>
                                        <th>PI Zone</th>
                                        <th>CI Zone</th>
                                        <th>FI Zone</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    @foreach($show_microbial_efficacyanalyses as $efficacyanalyses)
                                    
                                        <tr>
                                            <input type="hidden" name="metest_id[]" value="{{$efficacyanalyses->id}}" class="custom-control-input" checked="">

                                            <td class="font ">{{$efficacyanalyses->pathogen}}</td>
                                            <td class="font">
                                                <input type="text" required class="form-control" required name="pi_zone_update[]" placeholder="PI Zone" value="{{$efficacyanalyses->pi_zone}}">
                                                <input type="hidden" class="form-control" id="pi_zone" value="76899233403932{{$efficacyanalyses->efficacy_analyses_id}}">
                                                <input type="hidden" class="form-control" name="efficacyanalyses_update" value="{{$efficacyanalyses->efficacy_analyses_id}}">

                                            </td>
                                            <td class="font">
                                            <input type="text" class="form-control" required name="ci_zone_update[]"  value="{{$efficacyanalyses->ci_zone}}">
                                            </td>
                                            <td class="font">
                                                <input type="text" class="form-control" required name="fi_zone_update[]" value="{{$efficacyanalyses->fi_zone}}">
                                            </td>
                                        </tr>
                                    
                                    
                                    @endforeach
                               </tbody>
                            </table> 
                       </div>
                       @endif

                      @foreach ($show_productdept as $showproduct)
 
                    <div class="alert alert-secondary mt-20" style="margin-bottom: 10px">
                        <strong><span>General Comment</span></strong><br><br>
                       
                    <textarea class="form-control" required="" id="micro_product_comment" name="micro_comment" placeholder="General Comment" rows="4">{{\App\Product::find($report_id)->micro_comment}} </textarea>
                        <strong><span>Conclusion</span></strong><br><br>
                        <div class="input-group">
                        <input type="text" required class="form-control" id="micro_product_conclution" placeholder="Concution" name="micro_conclution" value="{{\App\Product::find($report_id)->micro_conclution}}">
                        </div> 
                   </div>
                  @endforeach
                    <div class="row invoice-info" style="margin: 15px">
                        <?php
                        $micro_analysed_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->micro_analysed_by:'');
                        $user_type         = (\App\Admin::find($micro_analysed_by)? \App\Admin::find($micro_analysed_by)->user_type_id:'');
                      ?>
                        <div class="col-sm-4 invoice-col">
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

            <div class="row">
                <div class="col-9">
                    @if (\App\Product::find($report_id)->micro_hod_evaluation <2)
                    <button type="submit" class="btn btn-success pull-right" id="submit_report" >
                     <i class="fa fa-credit-card"></i> 
                     Submit for Approval
                    </button>
                    @endif

                    @if (\App\Product::find($report_id)->micro_hod_evaluation ==2)
                    <button type="button" onclick="myFunction()" class="btn btn-primary pull-right" id="complete_report" style="margin-right: 5px;">
                    <i class="fa fa-view"></i>Print report</button>
                    @endif
                    {{-- <input type="hidden" id="report_url" value="{{url('admin/micro/completedreport/show',['id' => $report_id])}}"> --}}
                    
                </div>
                
                <div class="col-3">
                    @if (\App\Product::find($report_id)->micro_hod_evaluation ==1)
                    <button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>
                    @endif
                    @if (\App\Product::find($report_id)->micro_hod_evaluation ==2)
                    <button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>        
                   @endif
    
                </div>
            </div>
        </form>
        </div>
        
@endsection

@section('bottom-scripts')
<script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>   
<script src="{{asset('js/microbialcomments.js')}}"></script>

{{-- <script>
function myFunction() {
  var url = $('input[id="report_url"]').attr("value");
  var r = confirm("Be aware of the following before you complete report : 1.Completed Reports can not be edited after submision, system require you to see HoD for unavoidable complains or changes.  Thank you");
  if (r == true) {
  var  myWindow = window.open(url, "_blank", "width=500, height=500");
  } else {
   
  }
  document.getElementById("demo").innerHTML = txt;
}
</script> --}}

@endsection