@if (($show_microbial_loadanalyses) && count($show_microbial_loadanalyses)>0) 
<div class="card-header"><h3>Microbial <strong>Load</strong> Analysis</h3></div>
<div class="table-responsive ">
    <table class="table table-striped table-bordered nowrap dataTable">
        <thead>
            <tr  class="table-info">
                
                <th>Test Conducted</th>
                <th class="77772" style="display: none">Result (CFU/ml)</th>
                <th class="77771" style="display: none">Result (CFU/g)</th>
                <th>Accepted Criterion BP
                  (BP @foreach ($show_microbial_loadanalyses->groupBy('id')->first()  as $item)
                  {{Carbon\Carbon::parse($item->date)->format('Y')}}
                  <input type="hidden" name="date_template" value="{{$item->date}}">
                 @endforeach )
                </th>
                <th>Compliance Statement</th>
              
            </tr>
        </thead>
        <tbody class="">
       
          @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)

          <tr>
            <input type="hidden" name="mltest_id[]" value="{{$show_microbial_loadanalyses[$i]->id}}" class="custom-control-input" checked="">
    
            <td class="font" style="font-style: italic; margin:5px">
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
            <input type="hidden"  class="form-control"  name="test_conducted_id" value="{{$show_microbial_loadanalyses[$i]->test_conducted_id}}">

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

         </tr>
        @endfor
        <div class="col-sm-3" style="display: none">
          <label class="custom-control custom-checkbox" >
              <input type="checkbox" class=" custom-control-input" name="test_conducted_update" value="1" checked>
          </label>
      </div>
    </tbody>
   </table>
   <div class="row">
     <div class="col-md-5">
      @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
    
      @if ($i<1)
      <p style="font-style: italic; margin:5px; font-size:12px"> 
          <?php
          if ($i<2) {
         $definition= explode(' ',$show_microbial_loadanalyses[0]->definition);
   
          echo '<sup>';  print_r($definition[0]); echo '</sup>';   print_r($definition[1]);  echo ' ';  print_r($definition[2]); echo ' ';   print_r($definition[3]); echo ' '; print_r($definition[4]); echo ' ';   print_r($definition[5]); echo ' ';  print_r($definition[6]); echo ', ';echo ' ';  
          
   
          $definition= explode(' ',$show_microbial_loadanalyses[1]->definition);
   
              echo '<sup>';  print_r($definition[0]);echo '</sup>';  print_r($definition[1]); echo ' ';  print_r($definition[2]); echo ' ';    print_r($definition[3]); echo ' ';  print_r($definition[4]); echo ' ';   print_r($definition[5]); echo ' ';  print_r($definition[6]);
              }
          ?>
    
      </p>
      @endif
     @endfor
     </div>
     <div class="col-md-6">
      @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
      @if ($show_microbial_loadanalyses[$i]->rs_total == 9900000000)
      <p style="font-style: italic; margin:5px; font-size:12px"><sup>3</sup>  TNTC = Too Numerous To Count</p>
      @endif 
     @endfor
     </div>
   
   </div>
  
 
   @include('admin.micro.temp.mlconclusioninput') 


</div>
@endif