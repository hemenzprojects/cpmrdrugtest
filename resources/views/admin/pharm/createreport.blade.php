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
                                {{$pharmreports->productType->code}}|{{$pharmreports->id}}|{{$pharmreports->created_at->format('y')}} 
                            </td>
                        </tr>
                        <tr>
                        <td class="font"><strong>Date Recievied:</strong></td>
                            <td class="font">
                                @foreach (\App\ProductDept::where('product_id',$pharmreports->id)->where('dept_id',2)->get() as $item)
                                {{$item->updated_at->format('d/m/Y')}}
                                @endforeach
                            </td>
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
        @if ($pharmreports->pharm_testconducted ==1)
        <div class="card">
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
                        @foreach ($pharmreports->animalExperiment->unique('toxicity')->where('toxicity', '!=', 18) as $item)     
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
          
            <div class="" style="padding: 2%">
            
                <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"> <strong>REMARKS: </strong></h4>
                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation ==1)
                <textarea  style="font-size: 14.8px" class="form-control" rows="8" name="pharm_remmarks" >{{$pharmreports->pharm_comment}}
                </textarea> 
                @endif

                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation <1)
                <textarea style="font-size: 14.8px" class="form-control" rows="8" name="pharm_remmarks">LD/50 is estimated to be greater than 5000 mg/kg which is greater or equal to the level 5 on the Hodge and Sterner Scale (1) and also 93 times more than the recommended dose (two tablespoonful thrice daily equivalent to 53.63 mg/kg), as indicated by the manufacturer. Thus, {{$pharmreports->productType->code}}|{{$pharmreports->id}}|{{$pharmreports->created_at->format('y')}}  may not be toxic and is within the accepted margin of safety (Hodge and Stoermer Scale) at the recommended dose.
                </textarea>
                @endif
            </div>
       
        </div>
        @endif
      
       @if ($pharmreports->pharm_testconducted ==2)

       <div class="card" style="padding: 2%">
        @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation >0)
            <textarea style="font-size: 16px" class="form-control" rows="6" name="pharm_standard" >{{$pharmreports->pharm_standard}}
            </textarea> 
         @endif

         @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation <1)
         <textarea name="pharm_standard" class="form-control" style="font-size: 16px" cols="30" rows="6">{{\App\PharmStandards::find($pharmreports->productType->pharm_standard_id)? \App\PharmStandards::find($pharmreports->productType->pharm_standard_id)->default:'' }} </textarea>
         @endif

           <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> RESULTS: </strong></h4>

            @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation >0)
            <textarea style="font-size: 16px" class="form-control" rows="6" name="pharm_result" >{{$pharmreports->pharm_result}}
            </textarea> 
            @endif
            @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation <1)
            <textarea style="font-size: 16px" class="form-control" rows="6" name="pharm_result">Experimental rats in groups 1 and 2 that received 0.1ml intradermal injection of the balm dissolved in glycerol at 1% and 5% w/v respectively, showed @foreach ($pharmreports->animalExperiment->unique('toxicity')->where('toxicity', '!=', 2) as $item) {{$item->animalToxicity->name}}, @endforeach at the site of injection. This indicates that even at a high level of 5% w/v the balm did not appear to cause erythemia to the skin of the animal. A similar observation was made for the topical application.
            </textarea>
            @endif

        </div>
    
       <div class="card" style="padding: 2%">
        
            <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"> <strong>REMARKS: </strong></h4>
            @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation >0)
            <textarea  style="font-size: 16px" class="form-control" rows="4" name="pharm_remmarks" >{{$pharmreports->pharm_comment}}
            </textarea> 
            @endif
            @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation <1)
            <textarea style="font-size: 16px" class="form-control" rows="4" name="pharm_remmarks" > {{$pharmreports->productType->code}}|{{$pharmreports->id}}|{{$pharmreports->created_at->format('y')}} appears to be safe / not safe when applied to the skin.
        
            </textarea> 
            @endif
        
        </div>  
       @endif
    

       <div class="row" style="margin: 35px">
                <div class="col-sm-4 invoice-col">
                <?php
                $pharm_analysed_by = (\App\Product::find($pharmreports->id)? \App\Product::find($pharmreports->id)->pharm_analysed_by:'');
                $user_type         = (\App\Admin::find($pharm_analysed_by)? \App\Admin::find($pharm_analysed_by)->user_type_id:'');
                ?>
                <p>Analyzed By</p><br>
                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation >null)
                <img src="{{asset(\App\Admin::find($pharm_analysed_by)? \App\Admin::find($pharm_analysed_by)->sign_url:'')}}" class="" width="42%"><br>
                @endif
                -----------------------------<br>
            
                <span>{{ucfirst(\App\Admin::find($pharm_analysed_by)? \App\Admin::find($pharm_analysed_by)->full_name:'')}}</span>
                <p>{{ucfirst(\App\UserType::find($user_type )? \App\UserType::find($user_type )->name:'')}}</p>

            </div> 
            <div class="col-sm-4 invoice-col">
            
            </div>
            <div class="col-sm-4 invoice-col">
                <?php
                $pharm_appoved_by = (\App\Product::find($pharmreports->id)? \App\Product::find($pharmreports->id)->pharm_appoved_by:'');
                $hod_user_type = (\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->user_type_id:'');

                ?>
                <p>Supervisor</p><br>
                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation ==2)
                <img src="{{asset(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->sign_url:'')}}" class="" width="42%"><br>
                @endif

                ------------------------------<br> 
            
            <span>{{ucfirst(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->full_name:'')}}</span>
            <p>{{ucfirst(\App\UserType::find($hod_user_type)? \App\UserType::find($hod_user_type)->name:'')}}</p>

            </div>
      </div>

        <div class="row" style="margin-top: 110px">
            <div class="col-9">
                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation <2)
                <button onclick="return confirm('NB: report will be submitted to the head of department. Click Ok to confirm report submission')" type="submit" class="btn btn-success pull-right" id="pharm_submit_report" >
                <i class="fa fa-credit-card"></i> 
                Submit for Approval
                </button>
                @endif
                @if (\App\Product::find($pharmreports->id)->pharm_hod_evaluation ==2)
                <button type="button" onclick="myFunction()" class="btn btn-primary pull-right" id="pharm_complete_report" style="margin-right: 5px;">
                <i class="fa fa-view"></i> Print Report</button>
                @endif
                {{-- <input type="hidden" id="report_url" value="{{url('admin/pharm/completedreport/show',['id' => $pharmreports->id])}}"> --}}
            
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