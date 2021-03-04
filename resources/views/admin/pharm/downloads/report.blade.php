<!DOCTYPE html>
<html>
<head>
<style>
.font{
      font-size: 13.1px;
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

.watermarked1{
    background-image: url('{{ asset('admin/img/logo.jpg')}}');
    background-size: 60% 50%;
    background-position: center;
    background-repeat: no-repeat;
}
.watermarked2{
    background-image: url('{{ asset('admin/img/logo.jpg')}}');
    background-size: 68% 50%;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
</head>

<body >

<div class="{{$completed_report->pharm_testconducted == 1 ?'watermarked2':'watermarked1'}}">
    <div style=" background-color: #ffffffeb;">
<table>
    <tr style="border: #fff">
        <td style="width:45%;border: #fff"></td>
        <td style="width:50%; border: #fff" >
            <img src="{{asset('admin/img/logo.jpg')}}" width="22%">
        </td>
        <td style="width:10%; border: #fff"></td>

    </tr>

</table>
<table style="">
    <tr style="border:#fff; padding:4%">
        <td style="width:30.5%;border: #fff" ></td>
        <td style="border: #fff" >
        <span class="font" style="font-size: 16px;"> Centre for Plant Medicine Research </span>
        </td>
        <td style="width:30%;border: #fff"></td>

    </tr>
</table>
<table style="margin-top:-2.0%; padding:1%">
    <tr style="border: #fff">
        <td style="width:31%;border: #fff"></td>
        <td style="width:59%; border: #fff" >
        <span style="font-size: 13px;">Pharmacology & Toxicology Department</span>
        </td>
        <td style="width:10%; border: #fff"></td>

    </tr>
</table>

<table style="margin-bottom: 3%;margin-top:1%">
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
    <td class="font">{{ $completed_report->departmentById(2)->pivot->updated_at->format('jS \\, F Y') }}</td>
    <td class="font">{{ Carbon\Carbon::parse($completed_report->pharm_dateanalysed)->format('jS \\, F Y')}}</td>
    <td class="font">{{\App\PharmTestConducted::find($completed_report->pharm_testconducted)->name}}</td>
  </tr>
 
</table>

@if ($completed_report->pharm_testconducted == 1)

<table style="margin-bottom:5%">
    
    <tr>
        <th class="font" style="border: #fff"><span style="font-size:15px">RESULTS: </span><br>
          <span style="font-size:13px">Table showing Result of Acute Toxicity on {{$completed_report->code}} in  {{$pharm_finalreports->pharm_animal_model}}</span>  
         </th>
    </tr>
    <tr>
        <th></th>
        <th></th>
    </tr>

    <tbody>   
      <tr>
          <td class="font"><strong>Animal Model</strong></td>
          <td class="font">
              {{$pharm_finalreports->pharm_animal_model}}
          </td>
      </tr>
      <tr>
          <td class="font"><strong>No. of Animals</strong></td>
          <td class="font">
              {{$pharm_finalreports->num_of_animals}}
          </td>
      </tr>
      <tr>
          <td class="font"><strong>Sex</strong></td> 
          <td  class="font">
              {{$pharm_finalreports->animal_sex}}
          </td>
      </tr>
      <tr>
          <td class="font"><strong>No. of Groups</strong></td> 
          <td  class="font">
              {{$pharm_finalreports->no_group}}
          </td>
      </tr>
      <tr>
          <td class="font"><strong>Route of Administration</strong></td> 
          <td  class="font">
              {{$pharm_finalreports->method_of_admin}}
          </td>
      </tr>
      <tr>
          <td class="font"><strong>Formulation</strong></td> 
          <td  class="font">{{$pharm_finalreports->formulation}}</td>
      </tr>
      <tr>
          <td class="font"><strong>Preparation</strong></td> 
      <td  class="font">{{$pharm_finalreports->preparation}}</td>
      </tr>
      <tr>
          <td class="font"><strong>Dose Administered (mg/kg)</strong></td> 
          <td  class="font">
              {{$pharm_finalreports->dosage}}
          </td>
      </tr>
      <tr>
          <td class="font"><strong>Period of Observation</strong></td> 
          <td  class="font">
              {{$pharm_finalreports->no_days}}
          </td>
      </tr>
      <tr>
          <td class="font"><strong>No. of Death Recorded</strong></td> 
          <td  class="font">
              {{$pharm_finalreports->no_death}}
          </td>
      </tr>
      <tr>
          <td class="font"><strong>Estimated Median Lethal Dose (LD<sub>50</sub>)</strong></td> 
          <td  class="font">{{$pharm_finalreports->estimated_dose}}</td>
      </tr>
      <tr>
          <td class="font"><strong>Physical Sign of Toxicity</strong></td> 
          <td  class="font">
              {{$pharm_finalreports->signs_toxicity}}
          </td>
      </tr>
      <tr>
    
      </tr>
  </tbody>                        
</table>

 <p style="font-size: 15px"><span style="font-size:16px">  <span style="font-size:15px">REMARKS:  </span><br></span>{{$completed_report->pharm_comment}}   </p>

 @endif


 @if ($completed_report->pharm_testconducted == 2)
 <p style="font-size:16px; text-align: justify ">{{$completed_report->pharm_standard}}</p>

 <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"><strong> RESULTS: </strong></h4>
 <p style="font-size: 15px; text-align: justify">
     {{$completed_report->pharm_result}}   
 </p> 
 
 <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"> <strong>REMARKS: </strong></h4>

 <p style="font-size: 15px; text-align: justify ">
     {{$completed_report->pharm_comment}}   
 </p> 
@endif


  <table style="margin-top:1%">
  
  <tr>
    <td class="font" style="border: #fff" >
      <?php
      $pharm_approved_by = (\App\Product::find($completed_report->id)? \App\Product::find($completed_report->id)->pharm_approved_by:'');
      $hod_user_type = (\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->user_type_id:'');

      ?>
      <span>Analysed by</span><br>
      @if (\App\Product::find($completed_report->id)->pharm_hod_evaluation ==2)
      <img src="{{asset(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->sign_url:'')}}" class="" width="15%"><br>
      @endif

      ------------------------------<br> 
  
    <span>{{ucfirst(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->full_name:'')}}</span><br>
     <span>{{ucfirst(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->position:'')}}</span>
      </td>
    <td class="font" style="width: 150%;border: #fff"> </td>
    
    <td class="font" style="border: #fff">
      <?php
      $pharm_finalapproved_by = (\App\Product::find($completed_report->id)? \App\Product::find($completed_report->id)->pharm_finalapproved_by:'');
      $hod_user_type = (\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->user_type_id:'');

      ?>
      <span>Approved by</span><br>
    @if (\App\Product::find($completed_report->id)->pharm_finalapproved_by !== Null)
      <img src="{{asset(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->sign_url:'')}}" class="" width="15%"><br>
      @endif

      ------------------------------<br> 
  
  <span>{{ucfirst(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->full_name:'')}}</span><br>
  <span>{{ucfirst(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->position:'')}}</span>

    </td>

  </tr>
 
</table>
</div>
</div>
</body>
</html>
