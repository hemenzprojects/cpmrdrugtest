<div class="modal fade" id="demoModapreview" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:950px;  margin-left: -110px; ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center"> 
                    <img src="{{asset('admin/img/logo.jpg')}}" class="" width="10%">
                    <h4 class="font2" style="font-size:18px">CENTRE FOR PLANT MEDICINE RESEARCH </h4>
                    <p class="card-subtitle">MICROBIOLOGY DEPARTMENT</p>
                </div>
            <table class="table table-striped table-bordered nowrap dataTable" >
            <tr>
                <th class="font2">Product Code</th>
                <th class="font2">Dosage Form</th>
                <th class="font2">Date Received</th>
                <th class="font2">Date Analysed</th>
            </tr>
            <tr>
            <td class="font2">{{$product->code}}</td>
            <td class="font2">{{$product->productType->name}}</td>
            <td class="font2">
              {!! $product->micro_date_received !!}                                       
            </td>
            <td class="font2">{!! $product->micro_analysed_date !!}</td>
            </tr>

            </table>
             
            <div  style="margin-top:30px">
               
                @if (($show_microbial_loadanalyses) && count($show_microbial_loadanalyses)>0)

                @if (count($show_microbial_efficacyanalyses) > 0)
                <h6>A) Microbial Load Analysis</h6>
                @else
               <h6> Microbial Load Analysis </h6>
                @endif
                <table class="table table-striped table-bordered nowrap dataTable"  >
                 
                    <tr>
                        <th class="font">Test </th>
                        @if ($product->productType->state ==2)
                        <th class="font">Result (CFU/ml)</th>
                        @endif
                        @if ($product->productType->state ==1)
                        <th class="font">Result (CFU/g)</th>
                        @endif
                        <th class="font">Acceptance Criterion BP
                          (@foreach ($show_microbial_loadanalyses->groupBy('id')->first()  as $item)
                          {{Carbon\Carbon::parse($item->date)->format('Y')}}
                          <input type="hidden" name="date_template" value="{{$item->date}}">
                         @endforeach)
                        </th class="font">
                        <th class="font">Compliance</th>
                    </tr>
                
                    @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
                  <tr>
                    <td style="font-style: italic;" class="font" >
                        <?php
                        //  if ($i<2) {
                        // $test_conducted= explode(' ',$show_microbial_loadanalyses[$i]->test_conducted);
                
                        // echo '<sup>';  print_r($test_conducted[0]);echo '</sup>';  print_r($test_conducted[1]);  print_r($test_conducted[2]); echo '<sup>'; print_r($test_conducted[3]);  echo '</sup>'; print_r($test_conducted[4]); print_r($test_conducted[5]);
                        //  }else {
                        //     $test_conducted =  $show_microbial_loadanalyses[$i]->test_conducted;
                        //     print_r($test_conducted); 
                        //  }   
                       ?>
                             <p>{!! $show_microbial_loadanalyses[$i]->test_conducted !!}</p>

                           <input type="hidden" id="rstotal_{{$i}}" value="{{$show_microbial_loadanalyses[$i]->rs_total}}">
                
                    </td>
                  
                
                    <td class="font">
                        @if ($i<2)
                        <p id="manycount{{$i}}" style="font-size: 12px">
                            <?php 
                            if ($i<2) {
                              $results= explode(' ',$show_microbial_loadanalyses[$i]->result);
                              $rs_part1 =$results[0];
                              $rs_part2 = explode('^',$results[2]);
                         
                              print_r($rs_part1);  print_r(' x '); print_r($rs_part2[0]);  echo '<sup>';  print_r($rs_part2[1]);
                               
                            }
                          ?>
                        @else
                            <span>{{$show_microbial_loadanalyses[$i]->result}}</span>
                        @endif
                    </td>
                    <td class="font">
                        <?php 
                        if ($i<2) {
                          $acceptance_criterion= explode(' ',$show_microbial_loadanalyses[$i]->acceptance_criterion);
                          $rs_part1 =$acceptance_criterion[0];
                          $rs_part2 = explode('^',$acceptance_criterion[2]);
                     
                          print_r($rs_part1);  print_r(' x '); print_r($rs_part2[0]);  echo '<sup>';  print_r($rs_part2[1]);
                           
                        }else {
                          $acceptance_criterion =  $show_microbial_loadanalyses[$i]->acceptance_criterion;
                          print_r($acceptance_criterion); 
                        }
                      ?>
                        {{-- {{($item->acceptance_criterion)}} --}}
                    </td>
                
                    <td class="font">
                        {!! $show_microbial_loadanalyses[$i]->micro_compliance_report !!}
                    </td>                        
                  </tr>
                  @endfor
                </table>
                
              </table>
              <table style="border:#e8efec2b">
               <tr style="border:#e8efec2b">
               <td style="border:#e8efec2b; padding:3px">
                 @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
              
                @if ($i<1)
               <p style="font-style: italic; margin:5px; font-size:12px"> 
                   {!! $show_microbial_loadanalyses[0]->definition !!} 
               </p>
             @endif
             @endfor
               </td>
               <td style="border:#e8efec2b; padding:3px">
                 @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
              
                 @if ($i<1)
                <p style="font-style: italic; margin:5px; font-size:12px"> 
                    {!! $show_microbial_loadanalyses[1]->definition !!} 
                </p>
              @endif
              @endfor
               </td>
               <td style="border:#e8efec2b; padding:3px">
                 
               @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
                 @if ($i < 1)
                   @if ($show_microbial_loadanalyses[0]->rs_total == 9900000000 || $show_microbial_loadanalyses[1]->rs_total == 9900000000)
                   <p style="font-style: italic; margin:5px; font-size:12px">
                    <sup>3</sup>  TNTC = Too Numerous To Count
                  </p>
                   @endif 
                 @endif
               @endfor
               </td>
             </tr>
             </table>
                
                <div style="margin-top: 20px">
                    <span style="font-size:15px"> 
                        <strong> General Comment:</strong>
                        {{$product->micro_la_comment}}
                    </span>
                </div>
                
                @endif

            </div>
         

            <div style="margin-top:30px">
            
    @if (($show_microbial_efficacyanalyses) && count($show_microbial_efficacyanalyses)>0)

      @if (count($show_microbial_loadanalyses) > 0)
      <div class="card-heade" style="margin: 2%">
      <h6>B) Efficacy Analysis</h6>
      </div>
      @else
      <div class="card-heade" style="margin: 2%">
      <h6> Efficacy Analysis</h6>
      </div> 
      @endif
    <table class="table table-striped table-bordered nowrap dataTable">
    <tr>
        <th class="font">Pathogen</th>
        <th class="font">Product Inhibition Zone (mm)</th>
        <th class="font">Ciprofloxacin Inhibition Zone (mm)</th>
        <th class="font">Fluconazole Inhibition Zone (mm)</th>
    </tr>

    @foreach($show_microbial_efficacyanalyses as $efficacyanalyses)

    <tr>
    <td class="font " style="font-style: italic;">{{$efficacyanalyses->pathogen}}</td>
    <input type="hidden" class="form-control" id="pi_zone" value="76899233403932{{$efficacyanalyses->efficacy_analyses_id}}">
    <td class="font">
    {{$efficacyanalyses->pi_zone}}
    </td>
    <td class="font">{{$efficacyanalyses->ci_zone}}</td>
    <td class="font">{{$efficacyanalyses->fi_zone}}</td>
    </tr>

    @endforeach
</table>

  @for ($i = 0; $i < count($show_microbial_efficacyanalyses); $i++)

  @if ($i<1)
  {!! $show_microbial_efficacyanalyses[0]->ref !!}
  @endif
  @endfor

<div style="margin-top: 20px">
    <span style="font-size: 15px" >
        <span><strong>General Comment:</strong> </span>
        {{$product->micro_ea_comment}}
      </span>
    
</div>
  @endif

  </div>


          <div style="margin-top: 50px">          
                @include('admin.micro.temp.signaturetemplate')
        </div>  
          </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>