@include('admin.layout.general.head')

<div class="row" >

        <div class="container">
            <div class="card" style="padding: 15px">
            <form action="{{url('admin/micro/report/update',['id' => $report_id])}}" method="POST">
                    {{ csrf_field() }} 
                <div class="text-center" > 
                <img style="margin:10px" src="{{asset('admin/img/logo.jpg')}}" class="" width="11%">
                <h5 class="font" style="font-size:16px"> Microbiology Department Centre for Plant Medicine Research </h5>
                <p class="card-subtitle">Microbial Analysis Report on Herbal Product</p>
               </div>
                <form action=""> 
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
                                     <td class="font">  
                                         {{$completedproduct->productType->code}}|{{$completedproduct->id}}|{{$completedproduct->created_at->format('y')}}</td>
                                    <td class="font">  {{$completedproduct->productType->name}}</td>
                                    <input type="hidden" name="micro_product_id" value="{{$completedproduct->id}}">
                                    @foreach($completedproduct->departments->groupBy('id')->first() as $dept)

                                    <td class="font">{{($dept->pivot->updated_at->format('d/m/Y'))}}</td>
                                    @endforeach 

                                    <td class="font"> {{$completedproduct->micro_dateanalysed}}   </td>
                                    
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
                        <strong><span>Conclussion:</span></strong>
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
                            @if (\App\Product::find($report_id)->micro_hod_evaluation >1)
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
         
        </form>
        </div>

               

</div>

<div class="row" >
    <div class="container">
   <div class="card" style="">
      <div class="text-center" style="padding: 10px"> 
        <a href="{{ old('redirect_to', URL::previous())}}"> 
          <img style="margin:10px" src="{{asset('admin/img/logo.jpg')}}" class="" width="11%">
      </a>
  
      <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
      <p class="card-subtitle">Pharmacology & Toxicology Department</p>
     </div>
    <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4><hr>
    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <td style="border-top: 1px solid #fff;"> <strong>Name of Product:</strong></td>
                    <td style="border-top: 1px solid #fff;">
                        {{$completed_report->productType->code}}|{{$completed_report->id}}|{{$completed_report->created_at->format('y')}} |   {{ucfirst($completed_report->name)}}
                    </td>
                </tr>
                <tr>
                <td style="border-top: 1px solid #fff;"><strong>Date Recievied:</strong></td>
                    <td style="border-top: 1px solid #fff;">{{\App\ProductDept::where('product_id',$completed_report->id)->where('dept_id',2)->first()->updated_at->format('d/m/Y')}}</td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #fff;"><strong>Date of Report:</strong></td> 
                    <td style="border-top: 1px solid #fff;">{{$completed_report->pharm_dateanalysed}} </td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #fff;"><strong>Test Conducted</strong></td>
                    <td style="border-top: 1px solid #fff;">{{\App\PharmTestConducted::find($completed_report->pharm_testconducted)->name}}</td>                      
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

     @if ($completed_report->pharm_testconducted == 1)

     <div class="" style="">
        <div class=""> 
            <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> RESULTS: </strong></h4>

            <p class="font" style="font-size:14px; margin:20px; margin-top:10px"> Table showing Result of Acute Toxicity on {{$completed_report->productType->code}}|{{$completed_report->id}}|{{$completed_report->created_at->format('y')}} |   {{ucfirst($completed_report->name)}} in 
                @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                {{$item->pharm_animal_model}}
                @endforeach
            </p>
            </div>

            <table class="table">
                <tbody>   
                    <tr>
                        <td class="font"><strong>Animal Model</strong></td>
                        <td class="font">
                            @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                            {{$item->pharm_animal_model}}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="font"><strong>No. of Animals</strong></td>
                        <td class="font">
                            @foreach ($completed_report->animalExperiment->groupBy('product_id') as $item)
                            {{count($item)}}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Sex</strong></td> 
                        <td  class="font">
                            @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                            {{ucfirst($item->animal_sex)}}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="font"><strong>No. of Groups</strong></td> 
                        <td  class="font">
                            @foreach ($completed_report->animalExperiment->where('group',1)->groupBy('group') as $item)
                            2(N = {{count($item)}})
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Route of Administration</strong></td> 
                        <td  class="font">
                            @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                            {{ucfirst($item->animal_method)}}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Formulation</strong></td> 
                        <td  class="font">{{$completed_report->productType->name}}</td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Preparation</strong></td> 
                    <td  class="font">Freeze - dried sample of  {{$completed_report->productType->name}} ( {{$completed_report->productType->code}}|{{$completed_report->id}}|{{$completed_report->created_at->format('y')}} )</td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Dose Administered (Mg/Kg)</strong></td> 
                        <td  class="font">
                            @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                            {{$item->dosage}}
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Period of Observation</strong></td> 
                        <td  class="font">
                            @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                            {{$item->total_days}} Days
                                @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="font"><strong>No. of Death Recorded</strong></td> 
                        <td  class="font">
                            @if (count($completed_report->animalExperiment->where('death',1)->groupBy('group')) ==0)
                            
                                    Nill
                            @endif

                            @foreach ($completed_report->animalExperiment->where('death',1)->groupBy('death') as $item)
                                {{count($item)}}
                            @endforeach  
                        </td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Estimated Median Letha Dose (LD/50)</strong></td> 
                        <td  class="font"> Greater than 5000 mg/kg</td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Phisical Sign of Toxicity</strong></td> 
                        <td  class="font">
                            @foreach ($completed_report->animalExperiment->unique('toxicity')->where('toxicity', '!=', 2) as $item)     
                            {{$item->animalToxicity->name}} ,
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>  
            <div class="" style="padding: 2%">
                <h4 class="font" style="font-size:18px; margin:10px; margin-top:1px"><strong> REMARKS: </strong></h4>

                <p style="font-size: 16px;margin:5pxmargin:5px">
                {{$completed_report->pharm_comment}}   
                </p>       
            </div>      
      </div>   
     @endif
   
     @if ($completed_report->pharm_testconducted == 2)
        <p style="font-size:16px;margin:2%">{{$completed_report->pharm_standard}}</p>

        <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"><strong> RESULTS: </strong></h4>
        <p style="font-size: 15px; margin:2%">
            {{$completed_report->pharm_result}}   
        </p> 
        
        <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"> <strong>REMARKS: </strong></h4>

        <p style="font-size: 15px;margin:2%">
            {{$completed_report->pharm_comment}}   
        </p> 
     @endif

    <div class="row" style="margin: 15px">
        <div class="col-sm-4 invoice-col">
        <?php
        $pharm_analysed_by = (\App\Product::find($completed_report->id)? \App\Product::find($completed_report->id)->pharm_analysed_by:'');
        $user_type         = (\App\Admin::find($pharm_analysed_by)? \App\Admin::find($pharm_analysed_by)->user_type_id:'');
        ?>
        <p>Analyzed By</p><br>
        @if (\App\Product::find($completed_report->id)->pharm_hod_evaluation >null)
        <img src="{{asset(\App\Admin::find($pharm_analysed_by)? \App\Admin::find($pharm_analysed_by)->sign_url:'')}}" class="" width="42%"><br>
        @endif
        -----------------------------<br>
    
        <span>{{ucfirst(\App\Admin::find($pharm_analysed_by)? \App\Admin::find($pharm_analysed_by)->full_name:'')}}</span>
        <p>{{ucfirst(\App\UserType::find($user_type )? \App\UserType::find($user_type )->name:'')}}</p>

    </div> 
    <div class="col-sm-4 invoice-col">
        
        </div>
        <div class="col-sm-4 invoice-col">
            <?php
            $pharm_appoved_by = (\App\Product::find($completed_report->id)? \App\Product::find($completed_report->id)->pharm_appoved_by:'');
            $hod_user_type = (\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->user_type_id:'');

            ?>
            <p>Supervisor</p><br>
            @if (\App\Product::find($completed_report->id)->pharm_hod_evaluation ==2)
            <img src="{{asset(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->sign_url:'')}}" class="" width="42%"><br>
            @endif

            ------------------------------<br> 
        
        <span>{{ucfirst(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->full_name:'')}}</span>
        <p>{{ucfirst(\App\UserType::find($hod_user_type)? \App\UserType::find($hod_user_type)->name:'')}}</p>

        </div>
    </div>
    
     
   <div class="" style="margin-top: 5%;"></div>
   <div class="row" style="margin:0.1px">
    <div class="col-sm-2">
        <h4 class="font" style="font-size:15px;"><strong> REFERENCE: </strong></h4>
    </div>
    <div class="col-sm-9">
        <p> 1. Canadian Centre for Occupational Health and Safety (2019)</p>

    </div>
</div>
</div>
</div>
</div>

<div class="row">
    <div class="container">
        <div class="text-center" style="padding: 10px"> 
          <a href="{{ old('redirect_to', URL::previous())}}"> 
            <img style="margin:10px" src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
        </a>

        <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
        <p class="card-subtitle">Phytochemistry Department</p>
       </div>
  <div class="card">
            
       <div class="" style="margin-top: 10px">
        <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td class="font"> <strong>Name of Product:</strong></td>
                        <td class="font">
                            {{$phytoshowreport->productType->code}}|{{$phytoshowreport->id}}|{{$phytoshowreport->created_at->format('y')}}
                        </td>
                    </tr>
                    <tr>
                    <td class="font"><strong>Date Recievied:</strong></td>
                        <td class="font">{{$phytoshowreport->name}}</td>
                    </tr>
                    <tr>
                        <td class="font"><strong>Date of Report:</strong></td> 
                        <td class="font">{{$phytoshowreport->phyto_dateanalysed}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

   <div class="" style="margin-top: 10px">
      <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> TECHNICAL INFORMATION</strong></h4>

      <div class="col-md-7">

        <div class="col-lg-10 col-md-10" style="margin: 5px"><h5>A. {{\App\PhytoTestConducted::find(1)->name}}</h5></div> 
        <div class="table-responsive">
            <table class="table">

            <tbody>
              @foreach ($phytoshowreport->organolipticReport as $item)
              <tr>
                <th scope="row">{{$item->name}} :</th>
                <td class="font">{{$item->feature}}</td>
              </tr>
              @endforeach
            </tbody>
 
        </table>
    </div>

    <div class="col-lg-10 col-md-10" style="margin: 5px"><h5>B. {{\App\PhytoTestConducted::find(2)->name}}</h5></div>
    <div class="table-responsive"> 
        <table class="table">
            <tbody>
                @foreach ($phytoshowreport->phytochemdataReport as $item)
                <tr>
                  <th scope="row">{{$item->name}} : </th> 
                  <td class="font"> = {{$item->result}}</td>
                </tr>
                @endforeach
              </tbody>
        </table>
    </div>
    
    <div class="col-lg-10 col-md-10" style="margin: 5px"><h5>C. {{\App\PhytoTestConducted::find(3)->name}}</h5></div>
    
         <h6 class="" style="margin: 3%"> 
          @foreach ($phytoshowreport->phytochemconstReport as $pchemconst_item)
          @foreach (\App\PhytoChemicalConstituents::where('id', $pchemconst_item->name)->get() as $item)
          {{$item->name}},
          @endforeach
         @endforeach
         </h6>
            
    </div>

   </div>

   <div class="" style="margin-top: 10px">
    <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> REMARKS</strong></h4>
   <h6 style="margin:15px">{{$phytoshowreport->phyto_comment}}</h6>
   </div>


   <div class="row invoice-info" style="margin: 15px;margin-top: 20px">
    <?php
    $phyto_analysed_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_analysed_by:'');
    $user_type         = (\App\Admin::find($phyto_analysed_by)? \App\Admin::find($phyto_analysed_by)->user_type_id:'');
    ?>
    <div class="col-sm-4 invoice-col">
        <p>Analyzed By</p><br>
        @if (\App\Product::find($report_id)->phyto_hod_evaluation >null)
        <img src="{{asset(\App\Admin::find($phyto_analysed_by)? \App\Admin::find($phyto_analysed_by)->sign_url:'')}}" class="" width="42%"><br>
        @endif
        -----------------------------<br>
      
        <span>{{ucfirst(\App\Admin::find($phyto_analysed_by)? \App\Admin::find($phyto_analysed_by)->full_name:'')}}</span>
        <p>{{ucfirst(\App\UserType::find($user_type )? \App\UserType::find($user_type )->name:'')}}</p>

    </div> 
    <div class="col-sm-4 invoice-col">
         
    </div>
    <div class="col-sm-4 invoice-col">
        <?php
        $phyto_appoved_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_appoved_by:'');
        $hod_user_type = (\App\Admin::find($phyto_appoved_by)? \App\Admin::find($phyto_appoved_by)->user_type_id:'');

        ?>
        <p>Supervisor</p><br>

        @if (\App\Product::find($report_id)->phyto_hod_evaluation ==2)

        <img src="{{asset(\App\Admin::find($phyto_appoved_by)? \App\Admin::find($phyto_appoved_by)->sign_url:'')}}" class="" width="42%"><br>
        @endif

        ------------------------------<br> 

      <span>{{ucfirst(\App\Admin::find($phyto_appoved_by)? \App\Admin::find($phyto_appoved_by)->full_name:'')}}</span>
      <p>{{ucfirst(\App\UserType::find($hod_user_type)? \App\UserType::find($hod_user_type)->name:'')}}</p>

    </div>

</div>
  </div>
 
</div>
</div>

@include('admin.layout.general.scriptsjs')

