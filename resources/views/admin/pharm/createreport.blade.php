@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
     <div class="card" style="padding: 15px">
          <div class="text-center"> 
            <img src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
            <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
            <p class="card-subtitle">Pharmacology & Toxicology Department</p>
           </div>
     <form action="{{url('admin/pharm/report/create',['id' => $pharmreports->id])}}" method="post">
        {{ csrf_field() }} 
        <div class="card">
            <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="font"> <strong>Name of Product:</strong></td>
                            <td class="font">
                                {{$pharmreports->productType->code}}|{{$pharmreports->id}}|{{$pharmreports->created_at->format('y')}} |   {{ucfirst($pharmreports->name)}}
                            </td>
                        </tr>
                        <tr>
                        <td class="font"><strong>Date Recievied:</strong></td>
                            <td class="font">{{$pharmreports->name}}</td>
                        </tr>
                        <tr>
                            <td class="font"><strong>Date of Report:</strong></td> 
                            <td class="font"><input class="form-control" required type="date" name="date_analysed" value="{{$pharmreports->pharm_dateanalysed}}" style="width:250px"></td>
                        </tr>
                        <tr>
                            <td class="font"><strong>Test Conducted</strong></td>
                            <td class="font">{{\App\PharmTestConducted::find($pharmreports->pharm_testconducted)->name}}</td>
                            <input type="hidden" id="pharm_test_conducted" value="{{\App\PharmTestConducted::find($pharmreports->pharm_testconducted)->id}}">  
                            
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card test1" style="display: none;">
          <div class=""> 
            <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> RESULTS: </strong></h4>

            <p class="font" style="font-size:14px; margin:20px; margin-top:10px"> Table showing Result of Acute Toxicity on {{$pharmreports->productType->code}}|{{$pharmreports->id}}|{{$pharmreports->created_at->format('y')}} |   {{ucfirst($pharmreports->name)}} in 
                @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item)
                {{$item->pharm_animal_model}}
                @endforeach
            </p>
           </div>

           <table class="table">

            <tbody>
            
                
                <tr>
                    <td class="font"><strong>Animal Model</strong></td>
                    <td class="font">
                        @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item)
                       {{$item->pharm_animal_model}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                   <td class="font"><strong>No. of Animals</strong></td>
                    <td class="font">
                        @foreach ($pharmreports->animalExperiment->groupBy('product_id') as $item)
                        {{count($item)}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="font"><strong>Sex</strong></td> 
                    <td  class="font">
                        @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item)
                       {{ucfirst($item->animal_sex)}}
                        @endforeach
                 </td>
                </tr>
                <tr>
                    <td class="font"><strong>No. of Groups</strong></td> 
                    <td  class="font">
                        @foreach ($pharmreports->animalExperiment->where('group',1)->groupBy('group') as $item)
                        2(N = {{count($item)}})
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="font"><strong>Route of Administration</strong></td> 
                    <td  class="font">
                        @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item)
                       {{ucfirst($item->animal_method)}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="font"><strong>Formulation</strong></td> 
                    <td  class="font">{{$pharmreports->productType->name}}</td>
                </tr>
                <tr>
                    <td class="font"><strong>Preparation</strong></td> 
                <td  class="font">Freeze - dried sample of  {{$pharmreports->productType->name}} ( {{$pharmreports->productType->code}}|{{$pharmreports->id}}|{{$pharmreports->created_at->format('y')}} )</td>
                </tr>
                <tr>
                    <td class="font"><strong>Dose Administered (Mg/Kg)</strong></td> 
                    <td  class="font">
                        @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item)
                       {{$item->dosage}}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="font"><strong>Period of Observation</strong></td> 
                    <td  class="font">
                        @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item)
                        {{$item->total_days}} Days
                         @endforeach
                   </td>
                </tr>
                <tr>
                    <td class="font"><strong>No. of Death Recorded</strong></td> 
                    <td  class="font">
                        @if (count($pharmreports->animalExperiment->where('death',1)->groupBy('group')) ==0)
                       
                              Nill
                        @endif

                        @foreach ($pharmreports->animalExperiment->where('death',1)->groupBy('death') as $item)
                         {{count($item)}}
                        @endforeach  
                    </td>
                </tr>
                <tr>
                    <td class="font"><strong>Estimated Median Letha Dose (LD/50)</strong></td> 
                    <td  class="font"> Greater than 5000 mg/kg</td>
                </tr>
                <tr>
                    <td class="font"><strong>Phisical Sign of Toxicity</strong></td> 
                    <td  class="font">
                        @foreach ($pharmreports->animalExperiment->unique('toxicity')->where('toxicity', '!=', 2) as $item)     
                        {{$item->animalToxicity->name}} ,
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>      
       </div>

       <div class="card test2" style="display: none;padding: 2%">
           <p style="font-size: 15px">
            An area of hair on the lateral portion of the @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item) {{$item->pharm_animal_model}} @endforeach , (about 9cm^2) was trimmed and shaved with a razor blade. The rats were divided into 
            @foreach ($pharmreports->animalExperiment->where('group',1)->groupBy('group') as $item)
            3(N = {{count($item)}})
            @endforeach . Group one was injected  @foreach ($pharmreports->animalExperiment->where('group',1)->groupBy('id')->first() as $item) {{ucfirst($item->animal_method)}} @endforeach with 0.l ml of 1% w/v of the ointment dissolved in glycerol, group two with 0.1 ml of 5% w/v of
            the ointment dissolved in  @foreach ($pharmreports->animalExperiment->where('group',2)->groupBy('id')->first() as $item) {{ucfirst($item->animal_method)}} @endforeach and group three as control was treated with only 0.l ml glycerol.
            The ointmet was also applied topically to the shaved area of the first two group of rats and the animals were observed for a period of 48 hours for any signs of ulceration, irritation and/or inflamation as compared to the controll groups    
        </p>    

      </div>
            
       <div class="card" style="padding: 2%">
         
            <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"> <strong>REMARKS: </strong></h4>
            @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation ==1)
            <textarea class="form-control" rows="4" name="pharm_remmarks" >{{$pharmreports->pharm_comment}}
            </textarea> 
            @endif
            @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation <1)
            <textarea class="form-control" rows="4" name="pharm_remmarks" > LD/50 is estimated to be greater than 5000 mg/kg which is greater or equalto the level 5 on the Hodge and Sterner Scale (1) and also 93 times more than the recommended dose (two tablespoonful thrice daily equivalent to 53.63 mg/kg), as indicated by the manufacturer. Thus,{{$pharmreports->productType->code}} {{$pharmreports->productType->code}}|{{$pharmreports->id}}|{{$pharmreports->created_at->format('y')}}  may not be toxic and is within the accepted margin of safety (Hodge and Stermer Scale) at the recomended dose.
            </textarea> 
            @endif
              
       </div>

        <div class="row invoice-info" style="margin: 15px">

            <div class="col-sm-4 invoice-col">
                <p>Analyzed By</p><br>

                -----------------------------<br>
                {{-- {{\App\PharmTestConducted::find($pharmreports->pharm_testconducted)->name}} --}}
            </div> 
            <div class="col-sm-4 invoice-col">
                
            </div>
            <div class="col-sm-4 invoice-col">
                <p>Supervisor</p><br>

                ------------------------------<br> 
            <p></p>                     
            </div>

        </div>

        <div class="row">
            <div class="col-9">
                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation <2)
                <button type="submit" class="btn btn-success pull-right" id="pharm_submit_report" >
                <i class="fa fa-credit-card"></i> 
                Submit for Approval
                </button>
                @endif
                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation ==2)
                <button type="button" onclick="myFunction()" class="btn btn-primary pull-right" id="pharm_complete_report" style="margin-right: 5px;">
                <i class="fa fa-view"></i> Complete Report</button>
                @endif
                <input type="hidden" id="report_url" value="{{url('admin/pharm/completedreport/show',['id' => $pharmreports->id])}}">
            
        </div>
            <div class="col-3">
                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation ==1)
                <button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>
                @endif
                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation ==2)
                <button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>        
               @endif
                {{-- <input type="hidden" id="pharm_hod_evaluation" value="{{\App\Product::find($pharmreports->id)->pharm_hod_evaluation}}"> --}}

            </div>
      </form>
    </div>
    </div>
</div>


@endsection

@section('bottom-scripts')
<script>
function myFunction() {
  var url = $('input[id="report_url"]').attr("value");
  var r = confirm("Be aware of the following before you complete report : 1.Completed Reports can not be edited after submision, system require you to see HoD for unavoidable complains or changes.  Thank you");
  if (r == true) {
  var  myWindow = window.open(url, "_blank", "width=1000, height=700");
  } else {
   
  }
  document.getElementById("demo").innerHTML = txt;
}
</script>

@endsection