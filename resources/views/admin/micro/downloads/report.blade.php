<!DOCTYPE html>
<html>
<head>
<style>
.font{
      font-size: 13px;
      font-family: "Times New Roman";
    }
.font1{
  font-size: 14.5px;
  font-family: "Times New Roman";
}
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #000;
  text-align: left;
  padding: 5px;
}

/* tr:nth-child(even) {
  background-color:#dddddd6b;
} */
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
    background-size: 65% 40%;
    background-position: center;
    background-repeat: no-repeat;
}
.watermarked2{
    background-image: url('{{ asset('admin/img/logo.jpg')}}');
    background-size: 50% 50%;
    background-position: center;
    background-repeat: no-repeat;
}
.space{
  margin-top: 40%;
}
.footer{
  margin-top: 0%;
}
.footer1{
  margin-top: 10%;
}
</style>
</head>

<body class="watermarked1">
    <?php
    $product = \App\Product::find($report_id);

    ?>

{{-- <img src="{{asset('admin/img/logo.jpg')}}" alt="Paris" class="center">
<div class="myDiv">
<h5 class="title"> Microbiology Department Centre for Plant Medicine Research </h5>
<p style="font-size: 16px">Microbial Analysis Report on Herbal Product</p>
</div> --}}
<div >
    <div style=" background-color: #ffffffeb; height:70%">
<table>
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:58%;border: 0px solid #d3d3d3;"></td>
        <td style="width:50%; border: 0px solid #d3d3d3;" >
            <img src="{{asset('admin/img/logo.jpg')}}" width="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'23%':'30%'}}">
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
<table style="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'margin-top:-1.5% ':'margin-top:-1%'}}">
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
        <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">Product Code</th>
        <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">Product Form</th>
        <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">Date Received</th>
        <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">Date Analysed</th>
    </tr>
  <tr>
    <td class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">{{$product->code}}</td>
    <td class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">{{$product->productType->name}}</td>
    <td class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">{!! $product->micro_date_received !!}</td>
    <td class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">{!! $product->micro_analysed_date !!}</td>

  </tr>

</table>

@if (($microbial_loadanalyses) && count($microbial_loadanalyses)>0)
<div>
  <table style="margin: margin-top:4px">
    <tr>
      @if (count($microbial_efficacyanalyses) > 0)
      <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}" style="border: 0px solid #d3d3d3;">A) Microbial Load Analysis</th>
      @else
      <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}" style="border: 0px solid #d3d3d3;"> Microbial Load Analysis</th>
      @endif
  </tr>
  </table>
    <table>

        <tr>
            <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">Test </th>
            @if ($product->productType->state ==2)
            <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">Result (CFU/ml)</th>
            @endif
            @if ($product->productType->state ==1)
            <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">Result (CFU/g)</th>
            @endif
            <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">Acceptance Criterion BP
              (@foreach ($microbial_loadanalyses->groupBy('id')->first()  as $item)
              {{Carbon\Carbon::parse($item->date_template)->format('Y')}}
              @endforeach)
            </th>
            <th class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">Compliance</th>
        </tr>

        @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
      <tr>
        <td style="font-style: italic; " class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}" >
            <?php
            // if ($i<2) {
            // $test_conducted= explode(' ',$microbial_loadanalyses[$i]->test_conducted);

            // echo '<sup>';  print_r($test_conducted[0]);echo '</sup>';  print_r($test_conducted[1]);  print_r($test_conducted[2]); echo '<sup>'; print_r($test_conducted[3]);  echo '</sup>'; print_r($test_conducted[4]); print_r($test_conducted[5]);
            // }else {
            //     $test_conducted =  $microbial_loadanalyses[$i]->test_conducted;
            //     print_r($test_conducted);
            // }

          ?>
           <span> {!! $microbial_loadanalyses[$i]->test_conducted !!}</span>

              <input type="hidden" id="rstotal{{$i}}" value="{{$microbial_loadanalyses[$i]->rs_total}}">

        </td>


        <td class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">

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
        <td class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">
            <?php
            if ($i<2) {
               echo('Not More ');
              $acceptance_criterion= explode(' ',$microbial_loadanalyses[$i]->acceptance_criterion);
              $rs_part1 =$acceptance_criterion[0];
              $rs_part2 = explode('^',$acceptance_criterion[2]);

              print_r($rs_part1);  print_r(' x '); print_r($rs_part2[0]);  echo '<sup>';  print_r($rs_part2[1]); echo '</sup>';
                echo(' (CFU/mL)');
            }else {
              $acceptance_criterion =  $microbial_loadanalyses[$i]->acceptance_criterion;
              print_r($acceptance_criterion);
            }
          ?>
            {{-- {{($item->acceptance_criterion)}} --}}
        </td>

        <td class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">
            {!! $microbial_loadanalyses[$i]->micro_compliance_report !!}
        </td>
      </tr>
      @endfor
    </table>



    <table style="border:0px" >
      <tr style="border:0px ">
      <td style="font-style: italic;font-size:11px;border:0px; width:200px ">
        @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
      @if ($i<1)
      <span>
      {!! $microbial_loadanalyses[0]->definition !!}
      </span>
      @endif
      @endfor
  </td>
  <td style="font-style: italic;font-size:11px;border:0px; width:200px">
    @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
  @if ($i<1)
   <span>
  {!! $microbial_loadanalyses[1]->definition !!}
  </span>
  @endif
  @endfor
</td>
  <td style="font-style: italic; font-size:11px;border:0px">
@for ($i = 0; $i < count($microbial_loadanalyses); $i++)
@if ($i < 1)
  @if ($microbial_loadanalyses[$i]->rs_total == 9900000000)
  <span ><sup>3</sup> TNTC = Too Numerous To Count</span>
  @endif
@endif
@endfor
    <span><sup>3</sup>  ( ¾ )   = Absent. 4BP= British Pharmacopoeia.</span>
  </td>
</tr>

</table>

<span class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1 '}}">
  <strong> General Comment:</strong>
  {{$product->micro_la_comment}}
</span>
</div>
@if (count($microbial_efficacyanalyses)<1)
    <br>
@endif
@endif



 @if (($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0)

 <table style="margin-top:2%">

    <tr>
      @if (count($microbial_loadanalyses) > 0 )
      <th class="font" style="border: 0px solid #d3d3d3;">B) Microbial Efficacy Analysis</th>
      @else
      <th class="font" style="border: 0px solid #d3d3d3;">  Microbial Efficacy Analysis</th>
      @endif
    </tr>

    <tr>
        <th class="font">Pathogen</th>
        <th class="font">Product Inhibition Zone (mm)</th>
        <th class="font">Ciprofloxacin Inhibition Zone (mm)</th>
        <th class="font">Fluconazole Inhibition Zone (mm)</th>
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

  <span style="font-size: 14px;margin-top:2%" ><strong>General Comment:</strong></span>
  <span style="font-size:14px">{{$product->micro_ea_comment}}</span><br><br>
  @endif

  <span class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'font':'font1'}}">
    <strong>General Conclusion:</strong>
    </span>

    <span style="font-size:15px">  {{$product->micro_general_conclusion}}</span>


<table style="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0 ?'margin-top:1%':'margin-top:4%'}}" >

  <tr class="{{($microbial_efficacyanalyses) && count($microbial_efficacyanalyses) < 1 ?'space':'space1'}}">
    <td class="font " style="border: 0px solid">
        <?php
        $micro_approved_by = ($product? $product->micro_approved_by:'');
        $user_type         = (\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->user_type_id:'');
      ?>
        <span>Analyzed By</span><br>
        @if ($product->micro_hod_evaluation >1)
        <img src="{{asset(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->sign_url:'')}}" class="" width="17%" style="margin-bottom: -16px"><br>
        @endif
        -----------------------------<br>

        <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->full_name:'')}}</span><br>
        <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->position:'')}}</span>
    </td>
    <td class="font" style="width: 53%; border: 0px solid"> </td>

    <td class="font" style=" border: 0px solid">
        <?php
        $micro_finalapproved_by = ($product? $product->micro_finalapproved_by:'');
        $hod_user_type = (\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->user_type_id:'');

        ?>
        <span>Supervisor</span><br>
        @if ($product->micro_process_status ==3)
        <img src="{{asset(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->sign_url:'')}}" class="" width="15%" style="margin-bottom: -16px"><br>
        @endif

        ------------------------------<br>

        <span>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->full_name:'')}}</span><br>
        <span>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->position:'')}}</span>

    </td>

  </tr>

</table>
</div>
</div>
</body>
</html>
