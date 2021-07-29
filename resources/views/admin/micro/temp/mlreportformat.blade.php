@if (($show_microbial_loadanalyses) && count($show_microbial_loadanalyses)>0) 

@if (count($show_microbial_efficacyanalyses)> 0)
<h5>A) Microbial Load Analysis</h5>
@else
<h5> Microbial Load Analysis </h5>
@endif
<div class="table-responsive ">
    <table class="table table-striped table-bordered nowrap ">
        <thead>
            <tr  class="table-info">
                
                <th>Test </th>
                <th class="77772" style="display: none">Result (CFU/ml)</th>
                <th class="77771" style="display: none">Result (CFU/g)</th>
                <th>Acceptance Criterion
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
    
            <td class="font" style="font-style: italic; margin:5px; width:30%">
              @if ($i<2)
             <p>{!! $show_microbial_loadanalyses[$i]->test_conducted !!}
                  
             <button type="button"  id="summernoteshow{{$i}}">
                 <i class="ik ik-edit-2"></i> 
             </button>
            </p> 
             @endif
             @if ($i ==0 )
             <span style="display: none" class="summernoteshow1">
                 <textarea  name="test_conducted[]" id="tinymce1" cols="30" rows="10">{!! $show_microbial_loadanalyses[$i]->test_conducted !!}</textarea> 
             </span>
             @endif
             @if ($i ==1)
             <span style="display: none" class="summernoteshow2">
                 <textarea name="test_conducted[]" id="tinymce0" cols="30" rows="10">{!! $show_microbial_loadanalyses[$i]->test_conducted !!}</textarea> 
             </span>                                                    @endif
             @if ($i>1)
             <input type="text" required class="form-control" name="test_conducted[]" placeholder="Result" value="{!! $show_microbial_loadanalyses[$i]->test_conducted !!}">
             @endif 
            <td class="font">
              
             
                @if ($i<2)
                <p id="manycount_{{$i}}" style="font-size: 12px">
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
                
             <input type="text" required class="form-control {{$i<2?'date-inputmask':''}}" id="inputmask_{{$i}}" name="result[]"  placeholder="{{$i>1?'Result':''}}" value="{{$show_microbial_loadanalyses[$i]->result}}">
              <div id="error-div{{$i}}" style="margin: 5px; color:red;"></div>

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
     <div class="col-md-6">
      @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
    
      @if ($i<1)
      <p style="font-style: italic; margin:5px; font-size:12px"> 
          <?php
          if ($i<2) {
         $definition= explode(' ',$show_microbial_loadanalyses[0]->definition);
      
          echo '<sup>';  print_r($definition[0]); echo '</sup>';   print_r($definition[1]);  echo ' ';  print_r($definition[2]); echo ' ';   print_r($definition[3]); echo ' '; print_r($definition[4]); echo ' ';   print_r($definition[5]); echo ' ';  print_r($definition[6]); echo ', ';echo ' ';  
          
   
          $definition= explode(' ',$show_microbial_loadanalyses[1]->definition);
              echo '<sup>';  print_r($definition[0]);echo '</sup>';  print_r($definition[1]); echo ' ';  print_r($definition[2]); echo ' ';    print_r($definition[3]); echo ' ';  print_r($definition[4]); echo ' ';   print_r($definition[5]); echo ' ';  print_r($definition[6]); echo ' ';  print_r($definition[7]); 
              }
          ?>
    
      </p>
      @endif
     @endfor
     </div>
     <div class="col-md-6">
      @for ($i = 0; $i < count($show_microbial_loadanalyses); $i++)
      @if ($i < 1)
      @if ($show_microbial_loadanalyses[0]->rs_total == 9900000000 || $show_microbial_loadanalyses[1]->rs_total == 9900000000)
      <p style="font-style: italic; margin:5px; font-size:12px"><sup>3</sup>  TNTC = Too Numerous To Count</p>
      @endif 
      @endif
     @endfor
     </div>
   
   </div>
  
 
   @include('admin.micro.temp.mlconclusioninput') 


</div>
@endif