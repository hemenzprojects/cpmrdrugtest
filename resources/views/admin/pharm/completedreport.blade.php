@include('admin.layout.general.head')
<style>
    .table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #d3d3d3;
    }
   
</style>

<div class="container">
        <div class="text-center"> 
          <a href="{{ old('redirect_to', URL::previous())}}"> 
            <img style="margin:10px" src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
        </a>

        <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
        <p class="card-subtitle">Pharmacology & Toxicology Department</p>
       </div>

       <div class="card">
        <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4><hr>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td style="border-top: 1px solid #fff;"> <strong>Name of Product:</strong></td>
                        <td style="border-top: 1px solid #fff;">
                            {{$completed_report->productType->code}}|{{$completed_report->id}}|{{$completed_report->created_at->format('y')}} |   {{ucfirst($completed_report->name)}}
                        </td>
                    </tr>
                    <tr>
                    <td style="border-top: 1px solid #fff;"><strong>Date Recievied:</strong></td>
                        <td style="border-top: 1px solid #fff;">{{\App\ProductDept::where('product_id',$completed_report->id)->where('dept_id',2)->first()->updated_at->format('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #fff;"><strong>Date of Report:</strong></td> 
                        <td style="border-top: 1px solid #fff;">{{$completed_report->pharm_dateanalysed}} </td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #fff;"><strong>Test Conducted</strong></td>
                        <td style="border-top: 1px solid #fff;">{{\App\PharmTestConducted::find($completed_report->pharm_testconducted)->name}}</td>                      
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
  

    

        <h4 class="font" style="font-size:18px; margin:10px; margin-top:10px"><strong> RESULTS: </strong></h4>
  
        <p class="font" style="font-size:14px; margin:10px; margin-top:10px"> Table showing Result of Acute Toxicity on {{$completed_report->productType->code}}|{{$completed_report->id}}|{{$completed_report->created_at->format('y')}} |   {{ucfirst($completed_report->name)}} in 
            @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
            {{$item->pharm_animal_model}}
            @endforeach
        </p>
      
       <table class="table">
        <tbody>
            <tr>
                <td class="font"><strong>Animal Model</strong></td>
                <td class="font">
                    @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                   {{$item->pharm_animal_model}}
                    @endforeach
                </td>
            </tr>
            <tr>
               <td class="font"><strong>No. of Animals</strong></td>
                <td class="font">
                    @foreach ($completed_report->animalExperiment->groupBy('product_id') as $item)
                    {{count($item)}}
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="font"><strong>Sex</strong></td> 
                <td  class="font">
                    @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                   {{ucfirst($item->animal_sex)}}
                    @endforeach
             </td>
            </tr>
            <tr>
                <td class="font"><strong>No. of Groups</strong></td> 
                <td  class="font">
                    @foreach ($completed_report->animalExperiment->where('group',1)->groupBy('group') as $item)
                    2(N = {{count($item)}})
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="font"><strong>Route of Administration</strong></td> 
                <td  class="font">
                    @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                   {{ucfirst($item->animal_method)}}
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="font"><strong>Formulation</strong></td> 
                <td  class="font">{{$completed_report->productType->name}}</td>
            </tr>
            <tr>
                <td class="font"><strong>Preparation</strong></td> 
            <td  class="font">Freeze - dried sample of  {{$completed_report->productType->name}} ( {{$completed_report->productType->code}}|{{$completed_report->id}}|{{$completed_report->created_at->format('y')}} )</td>
            </tr>
            <tr>
                <td class="font"><strong>Dose Administered (Mg/Kg)</strong></td> 
                <td  class="font">
                    @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                   {{$item->dosage}}
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="font"><strong>Period of Observation</strong></td> 
                <td  class="font">
                    @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                    {{$item->total_days}} Days
                     @endforeach
               </td>
            </tr>
            <tr>
                <td class="font"><strong>No. of Death Recorded</strong></td> 
                <td  class="font">
                    @if (count($completed_report->animalExperiment->where('death',1)->groupBy('group')) ==0)
                   
                          Nill
                    @endif
  
                    @foreach ($completed_report->animalExperiment->where('death',1)->groupBy('death') as $item)
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
                    @foreach ($completed_report->animalExperiment->unique('toxicity')->where('toxicity', '!=', 2) as $item)     
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
  
       <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"><strong> RESULTS: </strong></h4>
       <p style="margin: 10px"> {{$completed_report->pharm_comment}}</p>

       <div class="row invoice-info" style="margin: 15px">

        <div class="col-sm-4 invoice-col">
            <p><strong>Analyzed By</strong></p><br>

            -----------------------------<br>
        </div> 
        <div class="col-sm-4 invoice-col">
            
        </div>
        <div class="col-sm-4 invoice-col">
            <p><strong>Approved By</strong></p><br>

            ------------------------------<br> 
        <p></p>                     
        </div>
      </div>
      
         
      <div class="" style="margin-top: 5%;"></div>
       <div class="row" style="margin:0.1px">
        <div class="col-sm-2">
            <h4 class="font" style="font-size:15px;"><strong> REFERENCE: </strong></h4>
        </div>
        <div class="col-sm-9">
            <p> 1. Canadian Centre for Occupational Health and Safety (2019)</p>

        </div>
    </div>
   </div>
</div>

@include('admin.layout.general.scriptsjs')