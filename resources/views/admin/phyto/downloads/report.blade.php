<!DOCTYPE html>
<html>
<head>
<style>
.font{
      font-size: 14px;
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
  padding: 8px;
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
    background-size: 60% 40%;
    background-position: center;
    background-repeat: no-repeat;
}
.watermarked2{
    background-image: url('{{ asset('admin/img/logo.jpg')}}');
    background-size: 63% 50%;
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

<div class="{{count($phyto_organolepticsreport) > 4 || count($phyto_physicochreport) > 4? 'watermarked2': 'watermarked1' }}">
    <div style=" background-color: #ffffffe7;">
<table>
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:42%;border:0px solid #d3d3d3;"></td>
        <td style="width:50%; border: 0px solid #d3d3d3;" >
            <img src="{{asset('admin/img/logo.jpg')}}" width="30%">
        </td>
        <td style="width:10%; border: 0px solid #d3d3d3;"></td>

    </tr>

</table>
<table style="margin-top: -0.1%" >
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:25%;border:0px solid #d3d3d3;"></td>
        <td style="width:60%; border: 0px solid #d3d3d3;" >
        <span class="font" style="font-size: 15px;"> <strong>CENTRE FOR PLANT MEDICINE RESEARCH</strong> </span>
        </td>
        <td style="width:10%; border: 0px solid #d3d3d3;"></td>

    </tr>
</table>
<table style="margin-top:-1.0%" >
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:34%;border: 0px solid #d3d3d3;"></td>
        <td style="width:60%; border: 0px solid #d3d3d3;" >
        <span class="font" style="font-size: 15px;">PHYTOCHEMISTRY DEPARTMENT</span>
        </td>
        <td style="width:10%; border: 0px solid #d3d3d3;"></td>

    </tr>
</table>

<table>
    <tr>
        <th class="font">Product Code</th>
        <th class="font">Dosage Form</th>
        <th class="font">Date Received</th>
        <th class="font">Date Analysed</th>
    </tr>
  <tr>
    <td class="font">{{$product->code}}</td>
    <td class="font">{{$product->productType->name}}</td>
    <td class="font">{{ $product->departmentById(3)->pivot->updated_at->format('jS \\, F Y') }}</td>
    <td class="font">{{ Carbon\Carbon::parse($product->phyto_dateanalysed)->format('jS \\, F Y')}}</td>
  </tr>
 
</table>

<table style="margin-top:2%">
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:40%; border: 0px solid #d3d3d3;" >
        <span class="font" style="font-size: 15px;"><strong>TECHNICAL INFORMATION </strong></span>
        </td>
    </tr>
</table>
<table >
    <thead>
        <tr>
            <th class="font" style="border: 0px solid #d3d3d3;font-size:14px">(A) {{\App\PhytoTestConducted::find(1)->name}}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($phyto_organolepticsreport as $organo_item)
        <tr>
            <td class="font" style="width: 50%">{{$organo_item->name}}</td>
            <td class="font" style="width: 50%">{{$organo_item->feature}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<table style="margin-top: 1.5%">
    <thead style="margin: 12%">
        <tr>
            <th class="font" style="border: 0px solid #d3d3d3;font-size:14px">(B) {{\App\PhytoTestConducted::find(2)->name}}</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < count($phyto_physicochreport); $i++)
        <tr>
            <td class="font" style="width: 50%">{{$phyto_physicochreport[$i]->name}}</td>
            <td class="font" style="width: 50%">
                @if ($phyto_physicochreport[$i]->location == 1)
                <span>{{$phyto_physicochreport[$i]->result}}  &deg; {{$phyto_physicochreport[$i]->unit}}  </span>        
               @else
               {{$phyto_physicochreport[$i]->result}}  {{$phyto_physicochreport[$i]->unit}}
               @endif

            </td>
        </tr>
        @endfor
    </tbody>
</table>
  
    <table style="margin-top: 1.5%">
        <thead>
            <tr>
                <th class="font" style="border: 0px solid #d3d3d3; font-size:14px">(C) {{\App\PhytoTestConducted::find(3)->name}}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font">
              
                    @foreach ($phyto_chemicalconstsreport as $key => $value)
                    @if( count( $phyto_chemicalconstsreport  ) != $key + 1 )
                    {{App\PhytoChemicalConstituents::find($value->name)->name}},
                    @else
                    {{App\PhytoChemicalConstituents::find($value->name)->name}}.
                    @endif
                    @endforeach
                </td>

                
            </tr>
        </tbody>
    </table>
    
<table style="margin-top:2%">
    <tr style="border: 0px solid #d3d3d3;">
        <td style="width:40%; border: 0px solid #d3d3d3;" >
        <span style="font-size: 15px;"><strong>REMARKS</strong></span><br>
        <span class="font">
            {{$product->phyto_comment}}
          </span>
        </td>
    </tr>
</table>
 
<table style="margin-top:5%"> 
      

  <tr>
    <td class="font" style="border: #fff" >
        <?php
        $phyto_approved_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_approved_by:'');
        $user_type         = (\App\Admin::find($phyto_approved_by)? \App\Admin::find($phyto_approved_by)->user_type_id:'');
        ?>
        <span>Analyzed By</span><br>
        @if (\App\Product::find($report_id)->phyto_hod_evaluation === 0 || \App\Product::find($report_id)->phyto_hod_evaluation === 2)
        <img src="{{asset(\App\Admin::find($phyto_approved_by)? \App\Admin::find($phyto_approved_by)->sign_url:'')}}" class="" width="21%"><br>
        @endif
        -----------------------------<br>
      
        <span>{{ucfirst(\App\Admin::find($phyto_approved_by)? \App\Admin::find($phyto_approved_by)->full_name:'')}}</span><br>
        <span>{{ucfirst(\App\Admin::find($phyto_approved_by)? \App\Admin::find($phyto_approved_by)->position:'')}}</span>

    </td>
    <td class="font" style="width: 130%;border: #fff"> </td>
    
    <td class="font" style="border: #fff">
        <?php
        $phyto_finalapproved_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_finalapproved_by:'');
        $hod_user_type = (\App\Admin::find($phyto_finalapproved_by)? \App\Admin::find($phyto_finalapproved_by)->user_type_id:'');

        ?>
        <span>Supervisor</span><br>
        @if (\App\Product::find($report_id)->phyto_hod_evaluation ==2)

        <img src="{{asset(\App\Admin::find($phyto_finalapproved_by)? \App\Admin::find($phyto_finalapproved_by)->sign_url:'')}}" class="" width="21%"><br>
        @endif

        ------------------------------<br> 

      <span>{{ucfirst(\App\Admin::find($phyto_finalapproved_by)? \App\Admin::find($phyto_finalapproved_by)->full_name:'')}}</span><br>
      <span>{{ucfirst(\App\Admin::find($phyto_finalapproved_by)? \App\Admin::find($phyto_finalapproved_by)->position:'')}}</span>

    </td>

  </tr>
 
</table>
</div>
</div>

</span>
</body>
</html>
