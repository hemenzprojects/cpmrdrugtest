@include('admin.layout.general.head')
<style>
    .table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #d3d3d3;
    }
   
</style>

<div class="container">
        <div class="text-center" style="padding: 10px"> 
          <a href="{{ old('redirect_to', URL::previous())}}"> 
            <img style="margin:10px" src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
        </a>

        <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
        <p class="card-subtitle">Pharmacology & Toxicology Department</p>
       </div>

       <div class="card" style="padding: 20px">
        <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4><hr>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td style="border-top: 1px solid #fff;"> <strong>Name of Product:</strong></td>
                        <td style="border-top: 1px solid #fff;">
                            {{$completed_report->code}} 
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

         @if ($completed_report->pharm_testconducted == 1)

         <div class="" style="">
            <div class=""> 
                <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> RESULTS: </strong></h4>
    
                <p class="font" style="font-size:14px; margin:20px; margin-top:10px"> Table showing Result of Acute Toxicity on {{$completed_report->productType->code}}|{{$completed_report->id}}|{{$completed_report->created_at->format('y')}} |   {{ucfirst($completed_report->name)}} in 
                    {{$pharm_finalreports->pharm_animal_model}}
                </p>
                </div>
                <table class="table">
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
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
              </table> 
                <div class="card" style="padding: 2%">
                    <h4 class="font" style="font-size:18px; margin:10px; margin-top:1px"><strong> REMARKS: </strong></h4>

                    <p style="font-size: 16px; text-align: justify ">
                    {{$completed_report->pharm_comment}}   
                    </p>       
                </div>      
          </div>   
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

        <div class="row" style="margin: 15px">
            <div class="col-sm-4 invoice-col">
            <?php
                $pharm_approved_by = (\App\Product::find($completed_report->id)? \App\Product::find($completed_report->id)->pharm_approved_by:'');
                $hod_user_type = (\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->user_type_id:'');

                ?>
                <p>Analysed by</p><br>
                @if (\App\Product::find($completed_report->id)->pharm_hod_evaluation ==2)
                <img src="{{asset(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->sign_url:'')}}" class="" width="42%"><br>
                @endif

                ------------------------------<br> 
            
            <span>{{ucfirst(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->full_name:'')}}</span>
            <p>{{ucfirst(\App\Admin::find($pharm_approved_by)? \App\Admin::find($pharm_approved_by)->position:'')}}</p>
        </div> 
        <div class="col-sm-4 invoice-col">
            
            </div>
            <div class="col-sm-4 invoice-col">
                <?php
                $pharm_finalapproved_by = (\App\Product::find($completed_report->id)? \App\Product::find($completed_report->id)->pharm_finalapproved_by:'');
                $hod_user_type = (\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->user_type_id:'');
    
                ?>
                <p>Approved by</p><br>
            @if (\App\Product::find($completed_report->id)->pharm_finalapproved_by !== Null)
                <img src="{{asset(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->sign_url:'')}}" class="" width="42%"><br>
                @endif
    
                ------------------------------<br> 
            
            <span>{{ucfirst(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->full_name:'')}}</span>
            <p>{{ucfirst(\App\Admin::find($pharm_finalapproved_by)? \App\Admin::find($pharm_finalapproved_by)->position:'')}}</p>
    
            </div>
        </div>
        
         
       <div class="" style="margin-top: 5%;"></div>
       <div class="row" style="margin:0.1px">
        <div class="col-sm-2">
            <h4 class="font" style="font-size:15px;"><strong> REFERENCE: </strong></h4>
        </div>
        <div class="col-sm-9">
            <p> 1- Canadian Centre for Occupational Health and Safety (2019)</p>

        </div>
    </div>
   </div>
</div>

@include('admin.layout.general.scriptsjs')