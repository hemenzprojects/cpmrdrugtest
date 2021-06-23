<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:950px;  margin-left: -110px;">
            <div class="modal-header">
                <h5 class="modal-title" id="demoModalLabel">Report Preview of {{$product->code}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="text-center"> 
                    <img src="{{asset('admin/img/logo.jpg')}}" class="" width="10%">
                    <h4 class="font2" style="font-size:18px">CENTRE FOR PLANT MEDICINE RESEARCH </h4>
                    <p class="card-subtitle">PHARMACOLOGY / TOXICOLOGY DEPARTMENT</p>
                </div>
                  <table class="table table-striped table-bordered nowrap dataTable" >
                    <tr>
                        <th class="font">Product Code</th>
                        <th class="font">Product Form</th>
                        <th class="font">Date Received</th>
                        <th class="font">Date Analysed</th>
                        <th class="font">Test Conducted</th>
                
                    </tr>
                  <tr>
                    <td class="font">{{$product->code}}</td>
                    <td class="font">{{$product->productType->name}}</td>
                    <td class="font">{!! $product->pharm_date_received !!}</td>
                    <td class="font">{!! $product->pharm_analysed_date !!}</td>
                    <td class="font">{{\App\PharmTestConducted::find($product->pharm_testconducted)->name}}</td>
                  </tr>
                 
                </table>

                @if ($product->pharm_testconducted == 1 || $product->pharm_testconducted == 3)

<div style="margin-bottom: 10%">
<div>

<table style="margin-top:3%; margin-bottom:10px"> 
<tr>
    <th class="font" style="border:0px #fff">
        <span style="font-size:15px">RESULTS: </span><br>
    </th>
</tr>
<tbody>
    <tr>
        <td class="font"  style="border:0px;width:100%; margin-top:7px;">
        <span style="font-size:15px">Table Showing Results of {{\App\PharmTestConducted::find(1)->name}} on {{$product->productType->name}} ({{$product->code}}) in {{$pharm_finalreports->pharm_animal_model}}.</span>  
        </td>
    </tr> 
</tbody>
</table>
<table class="table table-striped table-bordered nowrap dataTable" >
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
          <td class="font">Physical Sign of Toxicity</td> 
          <td  class="font">
              {{$pharm_finalreports->signs_toxicity}}
          </td>
      </tr>
      <tr>
    <td></td>
    <td></td>
      </tr>
  </tbody>                        
</table>

    <p style="margin-top:3%; margin-bottom:10px">
        <span style="font-size:16px">
        <span style="font-size:15px"><strong>REMARKS:  </strong>
        </span><br>
        {!! $product->pharm_acute_comment !!}   

        </span>
    </p>
</div>
</div>
 @endif

 @if ($product->pharm_testconducted == 3)
 <div style="page-break-after:always;"></div> 
 @endif
 
  @if ($product->pharm_testconducted == 2 || $product->pharm_testconducted == 3)
 <div style="margin-top:5%; margin-bottom:10%">
  @if ($product->pharm_testconducted == 3)
  <span style="font-size:15px"><strong>{{\App\PharmTestConducted::find(2)->name}} </strong></span> <br><br>
  @endif
  <p style="font-size:16px; text-align: justify ">{!! $product->pharm_standard !!}</p>
 
  <h4 class="font" style="font-size:15px; margin:10px; margin-top:15px"><strong> RESULTS: </strong></h4>
  <p style="font-size: 15px; text-align: justify">
      {!! $product->pharm_result !!}   
  </p> 
  
  <h4 class="font" style="font-size:15px; margin:10px; margin-top:15px"> <strong>REMARKS: </strong></h4>
 
  <p style="font-size: 15px; text-align: justify ">
     {!! $product->pharm_dermal_comment !!}   
 </p> 
  </div>
 
 @endif

 @include('admin.pharm.temp.signaturetemp') 

</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>