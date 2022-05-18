<!DOCTYPE html>
<html>
<head>
<style>
.font{
      font-size: 15.1px;
      font-family: "Times New Roman";
    }
.fonthd{
      font-size: 14.1px;
      font-family: "Times New Roman";
    }
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #000;
  text-align: left;
  padding: 6px;
  width: 50%;
}

/* tr:nth-child(even) {
  background-color: #dddddd1c;
  
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
    background-size: 63% 65%;
    background-position: center;
    background-repeat: no-repeat;
}

</style>
</head>

<body class="watermarked1">
    <div>
        <div style="background-color: #ffffffeb; height:70%">
<table>
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:47%;border:0px solid #d3d3d3;"></td>
        <td style="width:50%; border: 0px solid #d3d3d3;" >
            <img src="{{asset('admin/img/logo.jpg')}}" width="30%">
        </td>
    <td style="width:20%; border: 0px solid #d3d3d3;"> <span style="font-size:9px" >SN - {{$completed_report->pharm_serial_number}}</span> </td>

    </tr>

</table>
<table style="margin-top: -1.0%" >
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:25%;border:0px solid #d3d3d3;"></td>
        <td style="width:60%; border: 0px solid #d3d3d3;" >
        <span class="font" style="font-size: 16px;"> <strong>CENTRE FOR PLANT MEDICINE RESEARCH</strong> </span>
        </td>
        <td style="width:10%; border: 0px solid#d3d3d3;"></td>

    </tr>
</table>
<table style="margin-top:-1.2%" >
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:26.5%;border: 0px solid #d3d3d3;"></td>
        <td style="width:60%; border: 0px solid #d3d3d3;" >
        <span class="fonthd">PHARMACOLOGY & TOXICOLOGY DEPARTMENT</span>
        </td>
        <td style="width:10%; border: 0px solid #d3d3d3;"></td>

    </tr>
</table>


<table style="margin-bottom: 1%;">
    <tr>
        <th class="font">Product Code</th>
        <th class="font">Product Form</th>
        <th class="font">Date Received</th>
        <th class="font">Date Analysed</th>
        <th class="font">Test Conducted</th>

    </tr>
  <tr>
    <td class="font">{{$completed_report->code}}</td>
    <td class="font">{{$completed_report->productType->name}}</td>
    <td class="font">{!! $completed_report->pharm_date_received !!}</td>
    <td class="font">{!! $completed_report->pharm_analysed_date !!}</td>
    <td class="font">{{\App\PharmTestConducted::find($completed_report->pharm_testconducted)->name}}</td>
  </tr>
 
</table>

@if ($completed_report->pharm_testconducted == 1 || $completed_report->pharm_testconducted == 3)


<table>
<tr>
    <th class="font" style="border:0px #fff">
        <span style="font-size:15px">RESULTS: </span><br>
    </th>
</tr>
<tbody>
    <tr>
        <td class="font"  style="border:0px;width:100%">
        <span style="font-size:15px">Table Showing Results of {{\App\PharmTestConducted::find(1)->name}} on {{$completed_report->productType->name}} ({{$completed_report->code}}) in {{$pharm_finalreports->pharm_animal_model}}.</span>  
        </td>
    </tr> 
</tbody>
</table>
<table style="margin-bottom:0%">
    <tbody>    
      <tr>
          <td class="font">Animal Model</td>
          <td class="font">
              {{$pharm_finalreports->pharm_animal_model}}
          </td>
      </tr>
      <tr>
          <td class="font">No. of Animals</td>
          <td class="font">
              {{$pharm_finalreports->num_of_animals}}
          </td>
      </tr>
      <tr>
          <td class="font">Sex</td> 
          <td  class="font">
              {{$pharm_finalreports->animal_sex}}
          </td>
      </tr>
      <tr>
          <td class="font">No. of Groups</td> 
          <td  class="font">
              {{$pharm_finalreports->no_group}}
          </td>
      </tr>
      <tr>
          <td class="font">Route of Administration</td> 
          <td  class="font">
              {{$pharm_finalreports->method_of_admin}}
          </td>
      </tr>
      <tr>
          <td class="font">Formulation</td> 
          <td  class="font">{{$pharm_finalreports->formulation}}</td>
      </tr>
      <tr>
          <td class="font">Preparation</td> 
      <td  class="font">{{$pharm_finalreports->preparation}}</td>
      </tr>
      <tr>
          <td class="font">Dose Administered</td> 
          <td  class="font">
              {{$pharm_finalreports->dosage}}
          </td>
      </tr>
      <tr>
          <td class="font">Period of Observation</td> 
          <td  class="font">
              {{$pharm_finalreports->no_days}}
          </td>
      </tr>
      <tr>
          <td class="font">No. of Deaths Recorded</td> 
          <td  class="font">
              {{$pharm_finalreports->no_death}}
          </td>
      </tr>
      <tr>
          <td class="font">Estimated Median Lethal Dose (LD<sub>50</sub>)</td> 
          <td  class="font">{{$pharm_finalreports->estimated_dose}}</td>
      </tr>
      <tr>
          <td class="font">Physical Signs of Toxicity</td> 
          <td  class="font">
              {{$pharm_finalreports->signs_toxicity}}
          </td>
      </tr>
  </tbody>                        
</table>

    <p style="font-size: 15px">
        <span style="font-size:16px">
        <span style="font-size:15px"><strong>REMARKS:  </strong>
        </span><br>
        {!! $completed_report->pharm_acute_comment !!}   

        </span>
    </p>

 @endif

{{-- @if ($completed_report->pharm_testconducted == 3)
<div style="page-break-after:always;"></div> 
@endif --}}

 @if ($completed_report->pharm_testconducted == 2 || $completed_report->pharm_testconducted == 3)
 
 @if ($completed_report->pharm_testconducted == 3)
 <span style="font-size:15.5px"><strong>{{\App\PharmTestConducted::find(2)->name}} </strong></span> <br><br>
 @endif
 <p style="font-size:16px; text-align: justify ">{!! $completed_report->pharm_standard !!}</p>

 <h4 class="font" style="font-size:15px; margin:10px; margin-top:15px"><strong> RESULTS: </strong></h4>
 
 <p style="font-size: 16px; text-align: justify">
     {!! $completed_report->pharm_result !!}   
 </p> 
 
 <h4 class="font" style="font-size:15px; margin:10px; margin-top:15px"> <strong>REMARKS: </strong></h4>

 <p style="font-size: 16px; text-align: justifyl;margin-top:-px">
    {!! $completed_report->pharm_dermal_comment !!}   
</p> 
 
@endif


  <table style="{{$completed_report->pharm_testconducted > 1 ?'margin-top:5%':'margin-top:-2%'}}">
  
  <tr>
    <td class="font" style="border:0px solid" >
      <?php
      $pharm_approved_by = (\App\Product::find($completed_report->id)? \App\Product::find($completed_report->id)->pharm_approved_by:'');
      $hod_user_type = (\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->user_type_id:'');

      ?>
      <span>Analysed by</span><br>
      @if (\App\Product::find($completed_report->id)->pharm_hod_evaluation ==2)
      <img src="{{asset(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->sign_url:'')}}" class="" width="{{$completed_report->pharm_testconducted == 3 ?'80%':'75%'}}"  style="margin-bottom: -14px"><br>
      @endif

      ------------------------------<br> 
  
    <span>{{ucfirst(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->full_name:'')}}</span><br>
     <span>{{ucfirst(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->position:'')}}</span>
      </td>
    <td class="font" style="width: 130%;border: 0px solid"> </td>
    
    <td class="font" style="border:0px solid">
      <?php
      $pharm_finalapproved_by = (\App\Product::find($completed_report->id)? \App\Product::find($completed_report->id)->pharm_finalapproved_by:'');
      $hod_user_type = (\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->user_type_id:'');

      ?>
      <span>Approved by</span><br>
    @if (\App\Product::find($completed_report->id)->pharm_finalapproved_by !== Null)
      <img src="{{asset(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->sign_url:'')}}" class="" width="{{$completed_report->pharm_testconducted == 3 ?'80%':'75%'}}" style="margin-bottom: -14px"><br>
      @endif

      ------------------------------<br> 
  
  <span>{{ucfirst(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->full_name:'')}}</span><br>
  <span>{{ucfirst(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->position:'')}}</span>

    </td>

  </tr>
 
</table>
 
@if ($completed_report->pharm_testconducted == 1)
<div class="col-md-12" style="padding:-6px">
    <p style="font-size: 12px; text-align: justify ">
        <strong> Reference: </strong>  {!! $completed_report->pharm_reference !!}
    </p>  
</div>
@endif

</div>
</div>
</body>
</html>
