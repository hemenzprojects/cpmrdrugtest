<div class="card-header"><h3>Microbial <strong>Load</strong> Analysis</h3></div>
<div class="table-responsive ">
    <table class="table table-striped table-bordered nowrap dataTable">
        <thead>
            <tr  class="table-info">
                
                <th>Test Conducted</th>
                <th class="77772" style="display: none">Result (CFU/ml)</th>
                <th class="77771" style="display: none">Result (CFU/g)</th>
                <th>Accepted Criterion BP
               (@foreach($show_microbial_loadanalyses as $temp)
                @if($show_microbial_loadanalyses->first() == $temp)
                {{$temp->date_template}})
                @endif
                @endforeach
                </th>
                <th>Compliance Statement</th>
              
            </tr>
        </thead>
        {{-- Load analyses table without many count --}}
        <tbody class="1">
       
          @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)

          <tr>
            <input type="hidden" name="mltest_id[]" value="{{$show_microbial_loadanalyses[$i]->id}}" class="custom-control-input" checked="">
    
            <td class="font">
                <?php
                if ($i<2) {
               $test_conducted= explode(' ',$show_microbial_loadanalyses[$i]->test_conducted);

               echo '<sup>';  print_r($test_conducted[0]);echo '</sup>';  print_r($test_conducted[1]);  print_r($test_conducted[2]); echo '<sup>'; print_r($test_conducted[3]);  echo '</sup>'; print_r($test_conducted[4]); print_r($test_conducted[5]);
                }else {
                   $test_conducted =  $show_microbial_loadanalyses[$i]->test_conducted;
                   print_r($test_conducted); 
                }   
              ?>
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
              <td>
                <select name="mlcompliance[]" class="form-control" required>
                    <option value="{{$show_microbial_loadanalyses[$i]->compliance}}">{!! $show_microbial_loadanalyses[$i]->micro_compliance !!}</option>
                    <option value="1">Failed</option>
                    <option value="2">Passed</option>
                </select>
              

              </td>
            <input type="hidden"  class="form-control" id="load_analyses{{$i}}" name="loadanalyses" value="{{$show_microbial_loadanalyses[$i]->load_analyses_id}}">
            
         </tr>
        @endfor
    </tbody>
   </table>

   <div class="alert alert-secondary mt-20" style="margin-bottom: 10px">
    <strong><span>General Conclusion</span></strong><br><br>
    <div class="input-group">
        <select name="micro_la_conclution" class="form-control" id="exampleSelectGender">
            <option value="{{$product->micro_la_conclution}}">{!! $product->micro_load_conc !!}</option>
            <option value="1">The sample meets with the requirements as per BP specifications</option>
            <option value="2">The sample doest not meets with the requirements as per BP specifications</option>
        </select>
    </div> 
</div>

</div>
