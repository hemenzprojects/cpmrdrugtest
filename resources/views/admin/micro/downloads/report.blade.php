<!DOCTYPE html>
<html>
<head>
<style>
.font{
      font-size: 12px;
      font-family: "Times New Roman";
    }
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 7px;
}

tr:nth-child(even) {
  background-color:#dddddd6b;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 10%;
  margin-bottom: 5px
}
.title {
  display: block;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 5px;
  font-size: 18px;
}
.myDiv {
    text-align: center;
    margin-top: -25px;
}

.watermarked1{
    background-image: url('{{ asset('admin/img/logo.jpg')}}');
    background-size: 60% 50%;
    background-position: center;
    background-repeat: no-repeat;
}
.watermarked2{
    background-image: url('{{ asset('admin/img/logo.jpg')}}');
    background-size: 69% 45%;
    background-position: center;
    background-repeat: no-repeat;
}

.footer{
  margin-top: 0%;
}
.footer1{
  margin-top: 10%;
}
</style>
</head>

<body >
    <?php 
    $product = \App\Product::find($report_id); 
    
    ?>

{{-- <img src="{{asset('admin/img/logo.jpg')}}" alt="Paris" class="center">
<div class="myDiv">
<h5 class="title"> Microbiology Department Centre for Plant Medicine Research </h5>
<p style="font-size: 16px">Microbial Analysis Report on Herbal Product</p>
</div> --}}
<div class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'watermarked2':'watermarked1'}}">
    <div style=" background-color: #ffffffeb;">
<table>
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:58%;border: 0px solid #d3d3d3;"></td>
        <td style="width:50%; border: 0px solid #d3d3d3;" >
            <img src="{{asset('admin/img/logo.jpg')}}" width="20%">
        </td>
        <td style="width:20%; border: 0px solid #d3d3d3;"> <span style="font-size:9px" >SN - {{$product->micro_serial_number}}</span></td>

    </tr>

</table>
<table style="margin-top: -1.20%" >
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:25%; border: 0px solid #d3d3d3;"></td>
        <td style="width:50%; border: 0px solid #d3d3d3;" >
        <span style="font-size: 15px; font-family: Times New Roman" > CENTRE FOR PLANT MEDICINE RESEARCH. </span>
        </td>
        <td style="width:10%; border: 0px solid #d3d3d3;"></td>

    </tr>
</table>
<table style="margin-top:-2.0%" >
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:38%;border: 0px solid #d3d3d3;"></td>
        <td style="width:60%; border: 0px solid #d3d3d3;" >
         <span style="font-size: 15px; font-family: Times New Roman">MICROBIOLOGY DEPARTMENT</span><br>
        </td>
        <td style="width:10%;border: 0px solid #d3d3d3;"></td>

    </tr>
</table>
{{-- <table style="margin-top:-2.0%" >
  <tr style="border: 0px solid #d3d3d3;">
      <td style="width:35%;border: 0px solid #d3d3d3;"></td>
      <td style="width:60%; border: 0px solid #d3d3d3;" >
      <span style="font-size: 13px; font-family: Times New Roman">Microbial Analysis Report on Herbal Product</span>
      </td>
      <td style="width:10%;border: 0px solid #d3d3d3;"></td>

  </tr>
</table> --}}

<table >
    <tr>
        <th class="font">Product Code</th>
        <th class="font">Product Form</th>
        <th class="font">Date Received</th>
        <th class="font">Date Analysed</th>
    </tr>
  <tr>
    <td class="font">{{$product->code}}</td>
    <td class="font">{{$product->productType->name}}</td>
    <td class="font">{{ $product->departmentById(1)->pivot->updated_at->format('jS \\, F Y') }}</td>
    <td class="font">{{ Carbon\Carbon::parse($product->micro_dateanalysed)->format('jS \\, F Y')}}</td>

  </tr>
 
</table>

@if (($microbial_loadanalyses) && count($microbial_loadanalyses)>0)
<div>
    <table>
        <tr>
            
            <th class="font" style="border: #fff">(A) Microbial Load Analysis</th>
        </tr>
        <tr>
            <th class="font">Test Conducted</th>
            @if ($product->productType->state ==2)
            <th class="font">Result (CFU/ml)</th>
            @endif
            @if ($product->productType->state ==1)
            <th class="font">Result (CFU/g)</th>
            @endif
            <th class="font">Accepted Criterion BP
              (@foreach ($microbial_loadanalyses->groupBy('id')->first()  as $item)
              {{Carbon\Carbon::parse($item->date)->format('Y')}}
              <input type="hidden" name="date_template" value="{{$item->date}}">
            @endforeach)
            </th class="font">
            <th class="font">Compliance</th>
        </tr>

        @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
      <tr>
        <td style="font-style: italic;" class="font" >
            <?php
            if ($i<2) {
            $test_conducted= explode(' ',$microbial_loadanalyses[$i]->test_conducted);

            echo '<sup>';  print_r($test_conducted[0]);echo '</sup>';  print_r($test_conducted[1]);  print_r($test_conducted[2]); echo '<sup>'; print_r($test_conducted[3]);  echo '</sup>'; print_r($test_conducted[4]); print_r($test_conducted[5]);
            }else {
                $test_conducted =  $microbial_loadanalyses[$i]->test_conducted;
                print_r($test_conducted); 
            }   
          ?>
              <input type="hidden" id="rstotal{{$i}}" value="{{$microbial_loadanalyses[$i]->rs_total}}">

        </td>
      

        <td class="font">
          @if ($microbial_loadanalyses[$i]->rs_total <1 || $microbial_loadanalyses[$i]->rs_total == 9900000000)
            <?php 
            if ($i<2) {
              if ($microbial_loadanalyses[$i]->rs_total == 0) {
                print_r(' 0 ');
              }
              if ($microbial_loadanalyses[$i]->rs_total == 9900000000) {
                print_r(' 3 TNTC ');
              }
              
            }
            else {
            $results =  $microbial_loadanalyses[$i]->result;
            print_r($results); 
            }
            ?>
        @endif
        @if ($microbial_loadanalyses[$i]->rs_total >0 && $microbial_loadanalyses[$i]->rs_total < 9900000000)
        <span>
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
        </span> 
        @endif


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
    </table>




    <table style="border:#e8efec2b">
      <tr style="border:#e8efec2b">
      <td style="font-style: italic;font-size:11px;border:#e8efec2b ">
        @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
    
    @if ($i<1)
    <span > 
        <?php
        if ($i<2) {
    $definition= explode(' ',$microbial_loadanalyses[0]->definition);

        echo '<sup>';  print_r($definition[0]); echo '</sup>';   print_r($definition[1]);  echo ' ';  print_r($definition[2]); echo ' ';   print_r($definition[3]); echo ' '; print_r($definition[4]); echo ' ';   print_r($definition[5]); echo ' ';  print_r($definition[6]); echo ', ';echo ' ';  
        

        $definition= explode(' ',$microbial_loadanalyses[1]->definition);

            echo '<sup>';  print_r($definition[0]);echo '</sup>';  print_r($definition[1]); echo ' ';  print_r($definition[2]); echo ' ';    print_r($definition[3]); echo ' ';  print_r($definition[4]); echo ' ';   print_r($definition[5]); echo ' ';  print_r($definition[6]);
            }
        ?>

      </span>
@endif
@endfor
  </td>
  <td style="font-style: italic; font-size:11px;border:#e8efec2b">
    
@for ($i = 0; $i < count($microbial_loadanalyses); $i++)
@if ($microbial_loadanalyses[$i]->rs_total == 9900000000)
<span ><sup>3</sup> TNTC = Too Numerous To Count</span>
@endif 
@endfor

  </td>
</tr>
</table>

<span style="font-size:14px"> 
  <strong> General Conclusion:</strong>
  {{$product->micro_la_conclution}}
</span>
</div>
@endif




 @if (($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0)

 <table>
    <tr>
  <th class="font" style="border: #fff">(B) Microbial Efficacy Analysis</th>
    </tr>
    <tr>
        <th class="font">Pathogen</th>
        <th class="font">Product Inhibition Zone</th>
        <th class="font">Ciprofloxacin Inhibition Zone</th>
        <th class="font">Fluconazole Inhibition Zone</th>
    </tr>

    @foreach($microbial_efficacyanalyses as $efficacyanalyses)

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

  @for ($i = 0; $i < count($microbial_efficacyanalyses); $i++)

  @if ($i<1)
  {!! $microbial_efficacyanalyses[0]->ref !!}
  @endif
  @endfor

  <span style="font-size: 14px" >
    <span style="font-size:14px"><strong>General Conclusion:</strong> </span>
    {{$product->micro_ea_conclution}}</span>

  @endif

<table>
  
  <tr>
    <td class="font" style="border: #fff" >
        <?php
        $micro_approved_by = ($product? $product->micro_approved_by:'');
        $user_type         = (\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->user_type_id:'');
      ?>
        <span>Analyzed By</span><br>
        @if ($product->micro_hod_evaluation >1)
        <img src="{{asset(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->sign_url:'')}}" class="" width="21%"><br>
        @endif
        -----------------------------<br>
      
        <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->full_name:'')}}</span>
        <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->position:'')}}</span>
    </td>
    <td class="font" style="width: 130%;border: #fff"> </td>
    
    <td class="font" style="border: #fff">
        <?php
        $micro_finalapproved_by = ($product? $product->micro_finalapproved_by:'');
        $hod_user_type = (\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->user_type_id:'');

        ?>
        <span>Supervisor</span><br>
        @if ($product->micro_hod_evaluation ==2)
        <img src="{{asset(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->sign_url:'')}}" class="" width="21%"><br>
        @endif

        ------------------------------<br> 
        
        <span>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->full_name:'')}}</span>
        <span>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->position:'')}}</span>

    </td>

  </tr>
 
</table>
</div>
</div>
</body>
</html>
