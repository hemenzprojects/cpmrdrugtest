@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    {{-- <i class="ik ik-edit bg-blue"></i> --}}
                    <div class="d-inline">
                        <h5>Office of the HOD</h5>
                        <span>Below shows evaluated, approved and completed products</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                {{-- <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Forms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Group Add-Ons</li>
                    </ol>
                </nav> --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="padding:1%">
                
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="widget">
                            <div class="widget-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="state">
                                        <h6>Report(s) withheld</h6>
                                        @foreach ($withhelds->groupBy('pharm_hod_evaluation') as $result_evaluation) 
                                       <h2>{{count($result_evaluation)}}</h2>
                                     
                                        @endforeach
                                    </div>
                                    <div class="icon">
                                        <i class="ik ik-alert-circle"></i>
                                    </div>
                                </div>
                                <small class="text-small mt-10 d-block">Total number of product withheld</small>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="widget">
                            <div class="widget-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="state">
                                        <h6> Approved Report(s)</h6>
                                        @foreach ($approvals->groupBy('pharm_hod_evaluation') as $result_approved) 
                                        <h2>{{count($result_approved)}}</h2>
                                         @endforeach
                                    </div>
                                    <div class="icon">
                                        <i class="ik ik-thumbs-up"></i>
                                    </div>
                                </div>
                                <small class="text-small mt-10 d-block">Total number of report in Approved</small>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="widget">
                            <div class="widget-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="state">
                                        <h6>Completed Report(s) </h6>
                                        @foreach ($completeds->groupBy('pharm_hod_evaluation') as $result_completed) 
                                        <h2>{{count($result_completed)}}</h2>
                                         @endforeach
                                    </div>
                                    <div class="icon">
                                        <i class="ik ik-calendar"></i>
                                    </div>
                                </div>
                                <small class="text-small mt-10 d-block">Total number of report completed</small>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                 $hod_assist = App\Admin::where('id',Auth::guard('admin')->id())->where('dept_office_id',1)->first()
               @endphp
                @if ($hod_assist->user_type_id ==2)
                <div class="card">
                    <div class="card-body">
                       <div class="dt-responsive">
                           <table id="hod_order-table1" class="table table-striped table-bordered nowrap">
                               <thead>
                               <tr>
                                   <th>#</th>
                                   <th>Product</th>
                                   <th>Test conducted</th>
                                   <th>Assigned</th>
                                   <th>Evaluation</th>
                                   <th>Date Analysed</th>  
                                   <th>Date Submited</th> 
                                   <th>Action</th>
                               </tr>
                               </thead>
                               <tbody>
                                   @foreach ($evaluations as $evaluation)                                      
                                   <tr>
                                   <td class="font">
                                       <div class="">
                                           <label class="custom-control custom-checkbox">
                                           <input type="checkbox" name="pharm_evaluated_product[]" class="custom-control-input" value="{{$evaluation->id}}">
                                               <span class="custom-control-label"></span>
                                           </label>
                                       </div>
                                   </td>
                                   <td class="font">
                                       <a data-toggle="modal"  data-placement="auto" data-target="#exampleModalLong{{$evaluation->id}}" title="View Experiment" href=""></i>  
                                           <span  class="badge  pull-right" style="background-color: #de1024; color:#fff; margin:3px">
                                          {{$evaluation->code}}
                                       </span>
   
                                       </a>
                                      
                                   </td>
                                   <td class="font">
                                       {{\App\PharmTestConducted::find($evaluation->pharm_testconducted)->name}}
                                   </td>
                                   <td class="font">
                                     <strong>Animal Experiment:</strong>  <li style="margin-bottom: 5px"> @foreach ($evaluation->animalExperiment->groupBy('id')->first() as $item)
                                       <span style="color: #023504">{{\App\Admin::find($item->added_by_id)->full_name}}</span>
                                       @endforeach</li>
                                       <strong>Report Analyst:</strong>
                                         <li>
                                        <span style="color: #023504">{{\App\Admin::find($evaluation->pharm_analysed_by)->full_name}}

                                        </span>
                                       </li>
                                       <strong>Aproved By</strong>
                                       <li>
                                           {{ucfirst(\App\Admin::find($evaluation->pharm_appoved_by)? \App\Admin::find($evaluation->pharm_appoved_by)->full_name:'Null')}}
                                       </li>
                                   </td>
                                   
                                   <td class="font">{!! $evaluation->hod_pharm_evaluation !!}</td>
                                   <td class="font">{{$evaluation->pharm_dateanalysed}}</td>
                                   <td class="font">{{$evaluation->updated_at->format('d/m/Y')}}</td>
                                   <td class="font">
                                       <a href="{{url('admin/pharm/hod_office/evaluate_one',['id' => $evaluation->id])}}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>
                                   </td>
                            
                                   </tr>
                                    @endforeach
                           </tbody>
                           </table>
                       </div>
                   </div>


                   <div class="card-body">
                    <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> FINAL REPORT APPROVALS</strong></h4>
                  
                    <div class="dt-responsive">
                        <table id="hod_order-table2"
                               class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Test conducted</th>
                                <th>Assigned</th>
                                <th>Evaluation</th>
                                <th>Date Analysed</th>  
                                <th>Date Submited</th> 
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($final_reports as $approval)                                      
                                <tr>
                                <td class="font">
                                    <div class="">
                                        <label class="custom-control custom-checkbox">
                                        <input type="checkbox" name="pharm_evaluated_product[]" class="custom-control-input" value="{{$approval->id}}">
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="font">
                                    <a data-toggle="modal"  data-placement="auto" data-target="#exampleModalLong{{$approval->id}}" title="View Experiment" href=""></i>  
                                     <span  class="badge  pull-right" style="background-color: #de1024; color:#fff; margin:3px">
                                       {{$approval->code}}
                                    </span>
                                    </a>
                                  
                                </td>
                                <td class="font">
                                    {{\App\PharmTestConducted::find($approval->pharm_testconducted)->name}}
                                </td>
                                <td class="font">
                                   
                                  <strong>Animal Experiment:</strong>  <li style="margin-bottom: 5px"> @foreach ($approval->animalExperiment->groupBy('id')->first() as $item)
                                    <span style="color: #023504">{{\App\Admin::find($item->added_by_id)->full_name}}</span>
                                    @endforeach</li>
                                    <strong>Report Analyst:</strong>
                                    <li>
                                   <span style="color: #023504">{{\App\Admin::find($approval->pharm_analysed_by)->full_name}}

                                   </span>
                                  </li>
                                    <strong>Aproved By</strong>
                                    <li>
                                        {{ucfirst(\App\Admin::find($approval->pharm_appoved_by)? \App\Admin::find($approval->pharm_appoved_by)->full_name:'Null')}}
                                    </li>
                                </td>
                                
                                <td class="font">{!! $approval->final_hod_pharm_evaluation !!}</td>
                                <td class="font">{{$approval->pharm_dateanalysed}}</td>
                                <td class="font">{{$approval->updated_at->format('d/m/Y')}}</td>
                                <td class="font">
                                    <a href="{{url('admin/pharm/hod_office/evaluate_one',['id' => $approval->id])}}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>
 
                                    </td>
                               
                                </tr>
                                 @endforeach
                        </tbody>
                          
                        </table>
 
                        {{-- <div class="row">
                            <div class="col-md-5">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select  name="evaluation" class="form-control" id="exampleSelectGender">
                                        <option value="1">Complete Report(s)</option>                                        
                                        
                                        </select>
                                    </div>
                                </div>
                                @error('status')
                                <small style="" class="form-text text-danger" role="alert">
                                    <strong>{{$message}}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-7">   
                                <button type="submit" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.Completed Reports can not be edited after submision, you would be required to see system Administrator for unavoidable complains or changes.  Thank you')" class="btn btn-primary mb-2">Complete Selected Report(s)</button>
                            </div>
                        </div> --}}
                        </form>
                    </div>
                    </form> 
                </div> 
                @endif
              
              
   
                   
                 
                 
               
                 @php
                      $hod_anex = App\Admin::where('id',Auth::guard('admin')->id())->where('dept_office_id',1)->first()
                 @endphp
              
                @if ($hod_anex->user_type_id ==1)
                <div class="card">
                    
                    <div class="card-body">
                       <form action="{{route('admin.pharm.hod_office.evaluate')}}" method="post">
                           {{ csrf_field() }}
                       <div class="dt-responsive">
                           <table id="hod_order-table3"
                                  class="table table-striped table-bordered nowrap">
                               <thead>
                               <tr>
                                   <th>#</th>
                                   <th>Product</th>
                                   <th>Test conducted</th>
                                   <th>Assigned</th>
                                   <th>Evaluation</th>
                                   <th>Date Analysed</th>  
                                   <th>Date Submited</th> 
                                   <th>Action</th>
                               </tr>
                               </thead>
                               <tbody>
                                   @foreach ($final_reports as $approval)                                      
                                   <tr>
                                   <td class="font">
                                       <div class="">
                                           <label class="custom-control custom-checkbox">
                                           <input type="checkbox" name="pharm_evaluated_product[]" class="custom-control-input" value="{{$approval->id}}">
                                               <span class="custom-control-label"></span>
                                           </label>
                                       </div>
                                   </td>
                                   <td class="font">
                                       <a data-toggle="modal"  data-placement="auto" data-target="#exampleModalLong{{$approval->id}}" title="View Experiment" href=""></i>  
                                           <span  class="badge  pull-right" style="background-color: #de1024; color:#fff; margin:3px">
                                          {{$approval->productType->code}}|{{$approval->id}}|{{$approval->created_at->format('y')}}
                                       </span>
    
                                       </a>
                                       <sup style="font-size: 1px">
                                           {{$approval->productType->code}}{{$approval->id}}{{$approval->created_at->format('y')}}
                                        </sup> 
                                   </td>
                                   <td class="font">
                                       {{\App\PharmTestConducted::find($approval->pharm_testconducted)->name}}
                                   </td>
                                   <td class="font">
                                      
                                     <strong>Animal Experiment:</strong>  <li style="margin-bottom: 5px"> @foreach ($approval->animalExperiment->groupBy('id')->first() as $item)
                                       <span style="color: #023504">{{\App\Admin::find($item->added_by_id)->full_name}}</span>
                                       @endforeach</li>
                                       <strong>Report Analyst:</strong>
                                       <li>
                                      <span style="color: #023504">{{\App\Admin::find($approval->pharm_analysed_by)->full_name}}
   
                                      </span>
                                     </li>
                                       <strong>Aproved By</strong>
                                       <li>
                                           {{ucfirst(\App\Admin::find($approval->pharm_appoved_by)? \App\Admin::find($approval->pharm_appoved_by)->full_name:'Null')}}
                                       </li>
                                   </td>
                                   
                                   <td class="font">{!! $approval->final_hod_pharm_evaluation !!}</td>
                                   <td class="font">{{$approval->pharm_dateanalysed}}</td>
                                   <td class="font">{{$approval->updated_at->format('d/m/Y')}}</td>
                                   <td class="font">
                                       <a href="{{url('admin/pharm/hod_office/finalreport_show',['id' => $approval->id])}}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>
    
                                       </td>
                                  
                                   </tr>
                                    @endforeach
                           </tbody>
                             
                           </table>
    
                           {{-- <div class="row">
                               <div class="col-md-5">
                                   <div class="col-md-6">
                                       <div class="form-group">
                                           <select  name="evaluation" class="form-control" id="exampleSelectGender">
                                           <option value="1">Complete Report(s)</option>                                        
                                           
                                           </select>
                                       </div>
                                   </div>
                                   @error('status')
                                   <small style="" class="form-text text-danger" role="alert">
                                       <strong>{{$message}}</strong>
                                   </small>
                                   @enderror
                               </div>
                               <div class="col-md-7">   
                                   <button type="submit" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.Completed Reports can not be edited after submision, you would be required to see system Administrator for unavoidable complains or changes.  Thank you')" class="btn btn-primary mb-2">Complete Selected Report(s)</button>
                               </div>
                           </div> --}}
                           </form>
                       </div>
                       </form> 
                   </div> 
                @endif
                
              

            </div>
        </div>
    </div>
</div>
@endsection              