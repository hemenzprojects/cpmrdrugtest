@include('admin.layout.general.head')

<?php 
$product = \App\Product::find($report_id); 

?>
<style>


.watermarked{
    background-image: url(http://localhost/druganalysis/public/admin/img/logo.jpg);
    background-size: 50% 40%;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
<div class="row ">

        <div class="container watermarke">
            <div class="card" style="padding: 15px;     background-color: #ffffffe6;">
               <form action="{{url('admin/micro/report/update',['id' => $report_id])}}" method="POST">
                    {{ csrf_field() }} 
                <div class="text-center"> 
                <img src="{{asset('admin/img/logo.jpg')}}" class="" width="12%">
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
                                     <td class="font">  {{$completedproduct->code}}</td>
                                    <td class="font">  {{$completedproduct->productType->name}}</td>
                                    <input type="hidden" name="micro_product_id" value="{{$completedproduct->id}}">
                                     <td class="font"> 
                                        {!! $completedproduct->micro_date_received !!}                                       
                                        
                                    </td>

                                    <td class="font"> {!! $completedproduct->micro_analysed_date !!}</td>
                                    
                                </tr>
                               {{-- {{ $dept->pivot}} --}}
                               @endforeach 
                            </tbody>
                        </table>
                    </div>

                    
                    @if (($microbial_loadanalyses) && count($microbial_loadanalyses)>0)
                    <div class="card-heade" style="margin-top: 5%">
                        <h6>Microbial Load Analysis</h6>
                     </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                                <tr  class="table-warning">
                                    <th>Test </th>
                                    @if ($completedproduct->productType->state ==2)
                                    <th>Result (CFU/ml)</th>
                                    @endif
                                    @if ($completedproduct->productType->state ==1)
                                    <th >Result (CFU/g)</th>
                                    @endif
                                    <th>Accepted Criterion BP 
                                    (@foreach ($microbial_loadanalyses->groupBy('id')->first()  as $item)
                                    {{Carbon\Carbon::parse($item->date)->format('Y')}}
                                    <input type="hidden" name="date_template" value="{{$item->date}}">
                                    @endforeach)
                                    </th>
                                    <th>Compliance</th>
                                  
                                </tr>
                            </thead>
                        <tbody>
                        
                            {{-- @foreach ($microbial_loadanalyses as $item) --}}
                            @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
                            <tr>
                                <td class="font">
                              
                               <p>{!! $microbial_loadanalyses[$i]->test_conducted !!}</p>
                                    <input type="hidden" class="form-control" name="loadanalyses" placeholder="Result" value="{{$microbial_loadanalyses[$i]->test_conducted}}">
                                </td>
                                <td class="font">
                                 
                                <p id="manycount_{{$i}}" style="font-size: 13.4px">
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
                                <td class="font">
                                    {!! $microbial_loadanalyses[$i]->micro_compliance_report !!}
                                </td>                                                           
                            </tr>
                            @endfor

                        </tbody>
                       </table>
                       <div class="row">
                           <div class="col-md=-6">
                            @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
 
                            @if ($i<1)
                            <p style="font-style: italic; margin:5px"> 
                                {!! $microbial_loadanalyses[0]->definition !!}  {!! $microbial_loadanalyses[1]->definition !!}
                            </p>
                            @endif
                         @endfor
                           </div>
                           <div class="col-md=-6">
                               
                            @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
                            @if ($i < 1)
                            @if ($microbial_loadanalyses[0]->rs_total == 9900000000 || $microbial_loadanalyses[1]->rs_total == 9900000000)
                            <p style="font-style: italic; margin:5px; font-size:12px"><sup>3</sup>  TNTC = Too Numerous To Count</p>
                            @endif 
                            @endif
                           @endfor
                           </div>
                       </div>
                  
                       <div class="col-md-12" style="margin-top: 30px">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-heade" style="margin-top: 5%">
                                    <h6>General Conclusion:</h6>
                                 </div>
                            </div>
                            <div class="col-md-9">
                            <p style="font-size: 16px"> {{$product->micro_la_conclution}}</p>

                            </div>

                        </div>
                        
                     </div>
                       @endif  
                    </div>
                

               

                    @if (($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0)
                    <div class="card-heade" style="margin-top: 5%">
                        <h6>Microbial Efficacy Analysis</h6>
                     </div> 
                  
                     
                    <div class="table-responsive">
                        
                        <table class="table table-striped table-bordered nowrap dataTable">
                            <thead class="meatablehead">
                                <tr class="table-warning">
                                    <th class="font">Pathogen</th>
                                    <th class="font">Product Inhibition Zone</th>
                                    <th class="font">Ciprofloxacin Inhibition Zone</th>
                                    <th class="font">Fluconazole Inhibition Zone</th>
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
                    @for ($i = 0; $i < count($microbial_efficacyanalyses); $i++)
 
                    @if ($i<1)
                   {!! $microbial_efficacyanalyses[0]->ref !!}
                    @endif
                    @endfor
                    <div class="col-md-12" style="margin-top: 30px">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-heade" style="margin-top: 5%">
                                    <h6>General Conclusion:</h6>
                                 </div>
                            </div>
                            <div class="col-md-9">
                                <p style="font-size: 16px"> {{$product->micro_la_conclution}}</p>
                            </div>

                        </div>
                    </div>
                   

                    
                    @endif
                   
                    @include('admin.micro.temp.signaturetemplate') 

    
               </div>
            {{-- <div class="col-12">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit to complete report</button>
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-view"></i> View Report</button>
            </div> --}}
        </form>
        </div>
    </div>
               

</div>

@include('admin.layout.general.scriptsjs')

