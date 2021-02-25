<!DOCTYPE html>
<html>
<head>
<style>
.font{
      font-size: 12px;
    }
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
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

.watermarked{
    background-image: url('{{ asset('admin/img/logo.jpg')}}');
    background-size: 70% 50%;
    background-position: center;
    background-repeat: no-repeat;
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
<div class="watermarked" >
    <div style=" background-color: #ffffffeb;">
<table>
    <tr style="border: #fff">
        <td style="width:50%;border: #fff"></td>
        <td style="width:50%; border: #fff" >
            <img src="{{asset('admin/img/logo.jpg')}}" width="20%">
        </td>
        <td style="width:10%; border: #fff"></td>

    </tr>

</table>
<table style="margin-top: -0.1%" >
    <tr style="border: #fff">
        <td style="width:16%;border: #fff"></td>
        <td style="width:60%; border: #fff" >
        <span style="font-size: 15px;"> Microbiology Department. Centre for Plant Medicine Research </span>
        </td>
        <td style="width:10%; border: #fff"></td>

    </tr>
</table>
<table style="margin-top:-2.0%" >
    <tr style="border: #fff">
        <td style="width:30%;border: #fff"></td>
        <td style="width:60%; border: #fff" >
        <span style="font-size: 13px;">Microbial Analysis Report on Herbal Product</span>
        </td>
        <td style="width:10%; border: #fff"></td>

    </tr>
</table>

<table >
    <tr>
        <th class="font">Product Code</th>
        <th class="font">Form</th>
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

@if ($check_load->load_analyses_id ==1)

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
           (@foreach($microbial_loadanalyses as $temp)
            @if($microbial_loadanalyses->first() == $temp)
            {{$temp->date_template}}
            @endif
            @endforeach)
        </th class="font">
        <th class="font">Compliance</th>
    </tr>

    @for ($i = 0; $i < count($microbial_loadanalyses); $i++)
  <tr>
    <td style="" class="font">
        <?php
         if ($i<2) {
        $test_conducted= explode(' ',$microbial_loadanalyses[$i]->test_conducted);

        echo '<sup>';  print_r($test_conducted[0]);echo '</sup>';  print_r($test_conducted[1]);  print_r($test_conducted[2]); echo '<sup>'; print_r($test_conducted[3]);  echo '</sup>'; print_r($test_conducted[4]); print_r($test_conducted[5]);
         }else {
            $test_conducted =  $microbial_loadanalyses[$i]->test_conducted;
            print_r($test_conducted); 
         }   
       ?>
    </td>
    <td class="font">
     
    <span class="manycount{{$i}}" id="manycount{{$i}}" style="font-size: 13.4px">
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


@for ($i = 0; $i < count($microbial_loadanalyses); $i++)
 
@if ($i<1)
<p style="font-style: italic; margin:5px"> 
    <?php
    if ($i<2) {
$definition= explode(' ',$microbial_loadanalyses[0]->definition);

    echo '<sup>';  print_r($definition[0]); echo '</sup>';   print_r($definition[1]);  echo ' ';  print_r($definition[2]); echo ' ';   print_r($definition[3]); echo ' '; print_r($definition[4]); echo ' ';   print_r($definition[5]); echo ' ';  print_r($definition[6]); echo ', ';echo ' ';  
    

    $definition= explode(' ',$microbial_loadanalyses[1]->definition);

        echo '<sup>';  print_r($definition[0]);echo '</sup>';  print_r($definition[1]); echo ' ';  print_r($definition[2]); echo ' ';    print_r($definition[3]); echo ' ';  print_r($definition[4]); echo ' ';   print_r($definition[5]); echo ' ';  print_r($definition[6]);
        }
    ?>

</p>
@endif
@endfor
@endif

 <p style="font-size: 15px"><span style="font-size:16px"> General Conclusion:</span> {!! $product->micro_load_conc !!}</p>


 @if (($microbial_efficacyanalyses) && count($microbial_efficacyanalyses)>0)

 <table style="margin-bottom:15px">
    <tr>
  <th class="font" style="border: #fff">(B) Microbial Efficacy Analysis</th>
    </tr>
    <tr>
        <th class="font">Pathogen</th>
        <th class="font">PI Zone</th>
        <th class="font">CI Zone</th>
        <th class="font">FI Zone</th>
    </tr>

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
</table>

@for ($i = 0; $i < count($microbial_efficacyanalyses); $i++)
 
@if ($i<1)
{!! $microbial_efficacyanalyses[0]->ref !!}
@endif
@endfor
<p style="font-size: 15px"><span style="font-size:16px"> General Conclusion:</span> {!! $product->micro_efficacy_conc !!}</p>

@endif

    {{-- @if ($check_load->load_analyses_id ==1)
    <table style="margin-top:10%">

    </table>
    @endif --}}

  <table style="margin-top:1%">
  
  <tr>
    <td class="font" style="border: #fff" >
        <?php
        $micro_analysed_by = ($product? $product->micro_analysed_by:'');
        $user_type         = (\App\Admin::find($micro_analysed_by)? \App\Admin::find($micro_analysed_by)->user_type_id:'');
      ?>
        <span>Analyzed By</span><br>
        @if ($product->micro_hod_evaluation >1)
        <img src="{{asset(\App\Admin::find($micro_analysed_by)? \App\Admin::find($micro_analysed_by)->sign_url:'')}}" class="" width="15%"><br>
        @endif
        -----------------------------<br>
      
        <span>{{ucfirst(\App\Admin::find($micro_analysed_by)? \App\Admin::find($micro_analysed_by)->full_name:'')}}</span>
        <span>{{ucfirst(\App\Admin::find($micro_analysed_by)? \App\Admin::find($micro_analysed_by)->position:'')}}</span>
    </td>
    <td class="font" style="width: 150%;border: #fff"> </td>
    
    <td class="font" style="border: #fff">
        <?php
        $micro_approved_by = ($product? $product->micro_approved_by:'');
        $hod_user_type = (\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->user_type_id:'');

        ?>
        <span>Supervisor</span><br>
        @if ($product->micro_hod_evaluation ==2)
        <img src="{{asset(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->sign_url:'')}}" class="" width="15%"><br>
        @endif

        ------------------------------<br> 
        
        <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->full_name:'')}}</span>
        <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->position:'')}}</span>

    </td>

  </tr>
 
</table>
</div>
</div>
</body>
</html>
