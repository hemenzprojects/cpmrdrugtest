@extends('admin.layout.main')

@section('content')
@php
    $product = \App\Product::find($report_id);
@endphp
<div class="container-fluid">
    <div class="card" style="padding: 15px">
         <div class="text-center"> 
           <img src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
           <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
           <p class="card-subtitle">Pharmacology & Toxicology Department</p>
          </div>
          <form action="{{url('admin/pharm/hod_office/editreport',['id' => $pharmreports->id])}}" method="post">
            {{ csrf_field() }} 
                <div class="card">
                    <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="font"> <strong>Product:</strong></td>
                                    <td class="font">
                                        {{$pharmreports->code}} 
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
                                    <td class="font"><strong>Date Analyzed:</strong></td> 
                                    <td class="font">{{Carbon\Carbon::parse($pharmreports['pharm_dateanalysed'])->format('d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td class="font"><strong>Test Conducted</strong></td>
                                    <td class="font">{{\App\PharmTestConducted::find($pharmreports->pharm_testconducted)->name}}</td>
                                    <input type="hidden" id="pharm_test_conducted" name="pharm_testconducted" value="{{\App\PharmTestConducted::find($pharmreports->pharm_testconducted)->id}}">  
                                    
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row test1" style="display: none;">
                    <div class="col-sm-8">
                        <div class="card">
                            <div class=""> 
                            <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"><strong> RESULTS: </strong></h4>
                
                            <p class="font" style="font-size:14px; margin:20px; margin-top:10px"> Table showing Result of Acute Toxicity on {{$pharmreports->productType->code}}|{{$pharmreports->id}}|{{$pharmreports->created_at->format('y')}} |   {{ucfirst($pharmreports->name)}} in 
                                {{$pharm_finalreports->pharm_animal_model}}
                            </p>
                            </div>
                
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="font"><strong>Animal Model</strong></td>
                                        <td class="font">
                                        <input type="text"  class="" name="animal_model" value="{{$pharm_finalreports->pharm_animal_model}}" placeholder="None">
                                        </td>
                                    </tr>
                                    <tr>
                                    <td class="font"><strong>No. of Animals</strong></td>
                                        <td class="font">
                                            <input type="text"  class="" name="num_of_animals" value="{{$pharm_finalreports->num_of_animals}}" placeholder="None">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>Sex</strong></td> 
                                        <td  class="font">
                                            <input type="text"  class="" name="animal_sex" value="{{$pharm_finalreports->animal_sex}}" placeholder="None">

                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>No. of Groups</strong></td> 
                                        <td  class="font">
                                            <input type="text"  class="" name="no_group" value="{{$pharm_finalreports->no_group}}" placeholder="None">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>Route of Administration</strong></td> 
                                        <td  class="font">
                                            <input type="text"  class="" name="method_of_admin" value="{{$pharm_finalreports->method_of_admin}}" placeholder="None">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>Formulation</strong></td> 
                                        <td  class="font"><input type="text"  name="formulation" value="{{$pharm_finalreports->formulation}}" placeholder="None"></td>
                                        
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>Preparation</strong></td> 
                                    <td  class="font">
                                        <textarea name="preparation" id="" cols="30" rows="2"  placeholder="None">{{$pharm_finalreports->preparation}}</textarea>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>Dose Administered (mg/kg)</strong></td> 
                                        <td  class="font">
                                            <input type="text"  name="dosage" value="{{$pharm_finalreports->dosage}}" placeholder="None">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>Period of Observation</strong></td> 
                                        <td  class="font">
                                            <input type="text"  name="no_days" value="{{$pharm_finalreports->no_days}}" placeholder="None">
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>No. of Death Recorded</strong></td> 
                                        <td  class="font">
                                            <input type="text"  name="no_death" value="{{$pharm_finalreports->no_death}}" placeholder="None">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>Estimated Median Lethal Dose (LD<sub>50</sub>)</strong></td> 
                                        <td  class="font">
                                            <input type="text"  name="estimated_dose" value="{{$pharm_finalreports->estimated_dose}}" placeholder="None">
                                    </td>
                                    </tr>
                                    <tr>
                                        <td class="font"><strong>Physical Sign of Toxicity</strong></td> 
                                        <td  class="font">
                                        
                                            <textarea name="signs_toxicity" id="" cols="30"   placeholder="None" rows="3">{{$pharm_finalreports->signs_toxicity}}</textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                          
                                            
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>    
                        <div class="" style="padding: 1%">
                        <h4 class="font" style="font-size:18px; margin:10px; margin-top:1px"><strong> REMARKS: </strong></h4>
                            <p style="font-size: 16px">
                                <textarea class="form-control" name="pharm_comment_acute"  rows="6"> {{$pharmreports->pharm_comment}} </textarea>
            
                            </p>       
                        </div>  
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card-body">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Report submitted from animal house</strong> 
                                
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="font"><strong>Animal Model</strong></td>
                                            <td class="font">
                                                @foreach ($pharmreports->animalExperiment->unique('animal_model') as $item)
                                                {{App\PharmAnimalModel::find($item->animal_model)->name}},
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
                                                @foreach ($pharmreports->animalExperiment->groupBy('group') as $item)
                                                2(N = {{count($item) / 2}})
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font"><strong>Route of Administration</strong></td> 
                                            <td  class="font">
                                                @foreach ($pharmreports->animalExperiment->unique('animal_method') as $item)
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
                                            <td class="font"><strong>Dose Administered (mg/kg)</strong></td> 
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
                                                {{$pharmreports->experimental_deaths}} Deaths <br>
                                                {{$pharmreports->experimental_Lives}} Lives 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font"><strong>Estimated Median Lethal Dose (LD<sub>50</sub>)</strong></td> 
                                            <td  class="font"> Greater than 5000 mg/kg</td>
                                        </tr>
                                        <tr>
                                            <td class="font"><strong>Physical Sign of Toxicity</strong></td> 
                                            <td  class="font">
                                                @foreach ($pharmreports->animalExperiment as $value)
                                                @foreach ($value['toxicity'] as $item)   
                                                    {{$item}}
                                               @endforeach
                                              @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>  
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ik ik-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                

            {{-- This section is for Dermal test --}}

                    <div class="card test2" style="display: none;padding: 2%">
                        <div class="row">
                            <div class="col-sm-8">
                                {{-- <p style="font-size:16px; margin:4px; "></p> --}}
                                <textarea name="pharm_standard" style="font-size: 16px;  text-align: justify ;" class="form-control" rows="9"> {{$pharmreports->pharm_standard}} </textarea>  

                                <h4 class="font" style="font-size:18px; margin:10px; margin-top:15px"><strong> RESULTS: </strong></h4>
                                <p >
                                    <textarea name="pharm_result" style="font-size: 16px; text-align: justify ;" class="form-control" rows="5"> {{$pharmreports->pharm_result}} </textarea>  
                                </p> 
                                
                                <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"> <strong>REMARKS: </strong></h4>
                        
                                <p >
                                    <textarea name="pharm_comment_dermal" id=""  style="font-size: 16px" class="form-control" rows="3"> {{$pharmreports->pharm_comment}} </textarea>
                                    
                                </p>
                            </div>
                            <div class="col-sm-4">
                                <div class="card-body">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Report submitted from animal house</strong> 
                                        
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="font"><strong>Animal Model</strong></td>
                                                    <td class="font">
                                                        @foreach ($pharmreports->animalExperiment->unique('animal_model') as $item)
                                                        {{App\PharmAnimalModel::find($item->animal_model)->name}},
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
                                                        @foreach ($pharmreports->animalExperiment->groupBy('id')->first() as $item)
                                                        {{$item->group}} Group
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font"><strong>Route of Administration</strong></td> 
                                                    <td  class="font">
                                                        @foreach ($pharmreports->animalExperiment->unique('animal_method') as $item)
                                                       {{ucfirst($item->animal_method)}},
                                                        @endforeach
                                                    </td>
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
                                                        {{$pharmreports->experimental_deaths}} Deaths <br>
                                                        {{$pharmreports->experimental_Lives}} Lives 
                                                    </td>
                                                </tr>
                                            
                                                <tr>
                                                    <td class="font"><strong>Phisical Sign of Toxicity</strong></td> 
                                                    <td  class="font">
                                                        @foreach ($pharmreports->animalExperiment as $value)
                                                        @foreach ($value['toxicity'] as $item)   
                                                            {{$item}}
                                                       @endforeach
                                                      @endforeach
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>  
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <i class="ik ik-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>    
                        </div>  
                    </div>


                <div class="card">
            <div class="row"  style="margin:10px; margin-top:1px">
                <div class="col-sm-8">
                    <div class="form-group">
                        <h4 class="font" style="font-size:18px; margin:10px; margin-top:5px"><strong> Final Remarks: </strong></h4>

                    <textarea required name="pharm_hod_remarks" class="form-control" id="exampleTextarea1" rows="4">{{$pharmreports->pharm_hod_remarks}}</textarea>
                    </div>
                </div>
                <div class="col-sm-4">
                    <h4 class="font" style="font-size:18px; margin:10px; margin-top:5px"><strong> Report Grade</strong></h4>
                    <p>{!! $product->pharm_grade_report !!} </p>
                        <select name="pharm_grade" required class="form-control" >
                        <option value="{{$product->pharm_grade}}">{!! $product->pharm_grade_report !!}</option>
                            <option value="1">Failed</option>
                            <option value="2">Passed</option>
                        </select> 
                    <br>
                                
                </div>
            </div>
               @if ($pharmreports->pharm_hod_evaluation < 2 )
               <div class="col-sm-3" style="margin-bottom:2%">
                <button type="submit" class="btn btn-danger pull-right"> <i class="fa fa-credit-card"></i>Save report</button>
            </div>

               @endif
                
                </div>

       </form>


        <div class="row" style="margin: 35px">
            <div class="col-sm-4 invoice-col">
                <?php
                $pharm_appoved_by = ($product? $product->pharm_appoved_by:'');
                $hod_user_type = (\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->user_type_id:'');

                ?>
                <p>Analysed by</p><br>
                @if ($product->pharm_hod_evaluation ==2)
                <img src="{{asset(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->sign_url:'')}}" class="" width="42%"><br>
                @endif

                ------------------------------<br> 
            
            <span>{{ucfirst(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->full_name:'')}}</span>
            <p>{{ucfirst(\App\Admin::find($pharm_appoved_by)? \App\Admin::find($pharm_appoved_by)->position:'')}}</p>

            </div>
         
        <div class="col-sm-4 invoice-col">
            
         </div>
           <div class="col-sm-4 invoice-col">
            <?php
            $pharm_finalappoved_by = ($product? $product->pharm_finalappoved_by:'');
            $hod_user_type = (\App\Admin::find($pharm_finalappoved_by)? \App\Admin::find($pharm_finalappoved_by)->user_type_id:'');

            ?>
            <p>Approved by</p><br>
            @if ($product->pharm_finalappoved_by !== Null)
            <img src="{{asset(\App\Admin::find($pharm_finalappoved_by)? \App\Admin::find($pharm_finalappoved_by)->sign_url:'')}}" class="" width="42%"><br>
            @endif

            ------------------------------<br> 
        
        <span>{{ucfirst(\App\Admin::find($pharm_finalappoved_by)? \App\Admin::find($pharm_finalappoved_by)->full_name:'')}}</span>
        <p>{{ucfirst(\App\Admin::find($pharm_finalappoved_by)? \App\Admin::find($pharm_finalappoved_by)->position:'')}}</p>

        </div> 
        </div>


        <div class="col-12">
          
            <div class="row" style="margin-top: 110px">
                <div class="col-md-4">
                    @if ($product->pharm_hod_evaluation <2)
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="ik ik-clipboard"></i> Evaluate Report</button>
                    @endif
                </div>
                <div class="col-md-8">
                    @if ($product->pharm_hod_evaluation ===1) 
                    <div class="alert alert-danger" role="alert">
                        Report of {{$product->code}}  has been rejected.
                    </div>       
                   @endif
                </div>
                  <div class="col-md-7" style="margin-right: 1%">
                      
                      @if ($product->pharm_hod_evaluation ===2) 
                     <a href="{{ old('redirect_to', URL::previous())}}">
                      <div class="alert alert-success" role="alert">
                          Report succesfully analysed. Final report of {{$product->code}}  will be approved by the Hod. 
                      </div>
                     </a>
                     @endif
                  
                      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document"> 
                        
                               <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalCenterLabel">Please Sign to evaluate report</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                  </div>
                                  <div class="modal-body">
                                      <form  id="pharmhodapproveform" sign-user-url="{{route('admin.pharm.hod_office.checkhodsign')}}" action="{{route('admin.pharm.hod_office.evaluatereport',['id' => $report_id])}}" class="" method="POST">
                                          {{ csrf_field() }}
                                      <input id ="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
      
                                      <div class="input-group input-group-default col-md-6">
                                          <select class="form-control" name="evaluate">
                                              <option value="2">Approve Report</option>
                                              <option value="1">Reject Report</option>
                                          </select>
                                          </div>
                                          <div id="error-div" style="margin: 5px; color:red;"></div>
                                          <input name="adminid" id="adminid"  type="hidden" >
                  
                                          <div class="input-group input-group-default">
                                              @error('email')
                                              <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                                  <strong>{{$message}}</strong>
                                              </small>
                                              @enderror
                                              <span class="input-group-prepend"><label class="input-group-text"><i class="ik ik-shield"></i></label></span>
                                              <input required id="useremail" type="email" class="form-control" name="email" placeholder="Enter your email">
                                          </div>
                  
                                          <div class="input-group input-group-default">
                                              @error('password')
                                              <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                                  <strong>{{$password}}</strong>
                                              </small>
                                              @enderror
                                              <span class="input-group-prepend"><label class="input-group-text"><i class="ik ik-shield"></i></label></span>
                                              <input required id="userpassword" type="password" class="form-control" name="password" placeholder="Sign with password">
                                          </div>                         
                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-primary">Sign Report</button>
                                  </div>
                              </form>
                              </div>
                          </div>
                      </div>
                    </div>
                <div class="col-md-4">  
                     @if ($product->pharm_hod_evaluation ===2 && ($product->pharm_process_status ===5 || $product->pharm_process_status ===7) ) 
                    
                  <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#exampleModalCenter">  Reject Report</button>

                   <a onclick="return confirm('Consider the following before submitting report : 1.All report fields must be appropriately checked 2.submited Reports can be edited only after Hod evaluation. Thank you')" href="{{route('admin.pharm.hod_office.finalreport.send',['id' => $report_id])}}">
                  <button type="button" class="btn btn-success pull-right"> Submit for final approval</button>
                  </a>
                  @endif
              </div>
            </div>
          </div>
       </div>
   
</div>

@endsection