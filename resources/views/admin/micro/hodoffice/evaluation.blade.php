@extends('admin.layout.main')

@section('content')

    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    {{-- <i class="ik ik-edit bg-blue"></i> --}}
                    <div class="d-inline">
                        <h5>Office of the HOD</h5>
                        <span>Below shows evaluated, approved and completed product</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Evaluation</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
        
            @php
            $hod_anex = App\Admin::where('id',Auth::guard('admin')->id())->where('dept_office_id',1)->first()
           @endphp
    
          @if ($hod_anex->user_type_id ==2)

            <div class="card-body">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="state">
                                            <h6>Report(s) Withheld</h6>
                                            @foreach ($withhelds->groupBy('micro_hod_evaluation') as $result_evaluation) 
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
                                            @foreach ($approvals->groupBy('micro_hod_evaluation') as $result_approved) 
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
                                            @foreach ($completeds->groupBy('micro_hod_evaluation') as $result_completed) 
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

            </div>


            <div class="row">
                <div class="col-md-4">

                    <div class="card" style="height: 500px">
                        <div class="card-header" style="border-color: #ffc107;" >
                            @foreach($evaluations->groupBy('product_id') as $evaluation)
                            <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                               {{count($evaluation)}} 
                            </label>
                            @endforeach
                            <h3>Pending Report</h3>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                    <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                                    <li><i class="ik ik-minus minimize-card"></i></li>
                                    <li><i class="ik ik-x close-card"></i></li>
                                </ul>
                            </div>
                        </div>
                           <span class="" style="padding:5px">
                            <input class="form-control" id="listSearch" type="text" placeholder="Type something to search list items">
                            </span>
                       
                          <div class="card-body progress-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                                
                                <ul class="list-group" id="myList">
                                    @foreach($evaluations->sortBy('micro_hod_evaluation') as $evaluation)
                                  <li class="list-group-item" style="padding: 1px;border:1px">
                                    <div class="dd-handle">
                                            
                                        <div class="card-body feeds-widget">
                                        <div class="feed-item">
                                            <a href="{{ route('admin.hod_office.showreport',['id' => $evaluation->id]) }}">
                                                <div class="feeds-left"><i class="ik ik-check-square text-warning"></i></div>
                                                <div class="feeds-body">
                                                    <h4 class="">
                                                          
                                                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                                {{$evaluation->code}}
                                                           </span>
                                                       
                                                          <span href="" class="badge pull-right">
                                                          <p style="font-size: 10px;margin: 2px"></p>
                                                          </span><br>
                                                      
                                                           <span><small class="float-right ">  <strong>Test:</strong> {{count($evaluation->loadAnalyses)}}mla
                                                            @foreach ($evaluation->loadAnalyses->groupBy('id')->first() as $loadnalyses)
                                                            @endforeach
                                                            @if (count($evaluation->efficacyAnalyses)>0)
                                                            & {{count($evaluation->efficacyAnalyses)}}ea
                                                            @endif
                                                            
                                                          </small>
                                                         </span><br>   
                       
                                                    </h4>
                                                
                                                    <span>
                                                        <span>
                                                       
                                                            <small class="float-right font"><strong>Assigned: </strong>
                                                                {{\App\Admin::find($evaluation->micro_analysed_by)? \App\Admin::find($evaluation->micro_analysed_by)->full_name:'null'}}
                                                            </small><br>
                                                            <small class="float-right font"><strong>Approval 1: </strong>
                                                                {{\App\Admin::find($evaluation->micro_approved_by)? \App\Admin::find($evaluation->micro_approved_by)->full_name:'null'}}
                                                            </small><br>
                                                            <small class="float-right font"><strong>Approval 2: </strong>
                                                                {{\App\Admin::find($evaluation->micro_finalappoved_by)? \App\Admin::find($evaluation->micro_finalappoved_by)->full_name:'null'}}
                                                            </small><br>
                                                            </span>
                                                    </span>
                                                
                                                      <span>
                                                      <small class="float-right font" style="margin-left: 5px"> 
                                                          <strong>Evaluation: </strong> {!! $evaluation->report_evaluation !!}</small>
                                                      </span>
                                                          @if ($evaluation->micro_grade != null )
                                                          <span>
                                                            <small class="float-right font" style="margin: 0.5px"> <strong>Grade: </strong> {!! $evaluation->micro_grade_report !!}</small>
                                                          </span>  
                                                          @endif 
        
                                                </div>
                                            </a>
                                            <span class="float-right font" style="margin-top:10px">
                                                
                                                 
                                            </span>
                                            <span style="font-size:10px" style="margin-top:10px">
                                                @foreach($evaluation->loadAnalyses as $temp)
                                                @if($evaluation->loadAnalyses->first() == $temp)
                                                {{$temp->created_at->format('d/m/y')}}
                                                @endif
                                                @endforeach
                                            </span>
                                        </div>
                                        </div>
                     
                                    </div>
                                      
                                  </li>
        
                                  @endforeach
                                </ul>
                          </div>
                    </div>

                    <div class="card" style="height: 500px">
                        <div class="card-header" style="border-color: #ffc107;" >
                            @foreach($final_reports->groupBy('product_id') as $evaluation)
                            <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                               {{count($evaluation)}} 
                            </label>
                            @endforeach
                            <h3>Reports to Hod</h3>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                    <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                                    <li><i class="ik ik-minus minimize-card"></i></li>
                                    <li><i class="ik ik-x close-card"></i></li>
                                </ul>
                            </div>
                        </div>
                           <span class="" style="padding:5px">
                            <input class="form-control" id="listSearch2" type="text" placeholder="Type something to search list items">
                            </span>
                       
                          <div class="card-body progress-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                                
                                <ul class="list-group" id="myList2">
                                    @foreach($final_reports->sortBy('micro_hod_evaluation') as $evaluation)
                                  <li class="list-group-item" style="padding: 1px;border:1px">
                                    <div class="dd-handle">
                                            
                                        <div class="card-body feeds-widget">
                                        <div class="feed-item">
                                            <a href="{{ route('admin.hod_office.showreport',['id' => $evaluation->id]) }}">
                                                <div class="feeds-left"><i class="ik ik-check-square text-warning"></i></div>
                                                <div class="feeds-body">
                                                    <h4 class="">
                                                          
                                                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                                {{$evaluation->code}}
                                                           </span>
                                                       
                                                          <span href="" class="badge pull-right">
                                                          <p style="font-size: 10px;margin: 2px"></p>
                                                          </span><br>
                                                      
                                                           <span><small class="float-right ">  <strong>Test:</strong> {{count($evaluation->loadAnalyses)}}mla
                                                            @foreach ($evaluation->loadAnalyses->groupBy('id')->first() as $loadnalyses)
                                                            @endforeach
                                                            @if (count($evaluation->efficacyAnalyses)>0)
                                                            & {{count($evaluation->efficacyAnalyses)}}ea
                                                            @endif
                                                            
                                                          </small>
                                                         </span><br>   
                       
                                                    </h4>
                                                
                                                     <span>
                                                    <small class="float-right font"><strong>Assigned: </strong>
                                                        {{\App\Admin::find($evaluation->micro_analysed_by)? \App\Admin::find($evaluation->micro_analysed_by)->full_name:'null'}}
                                                    </small><br>
                                                    <small class="float-right font"><strong>Approval 1: </strong>
                                                        {{\App\Admin::find($evaluation->micro_approved_by)? \App\Admin::find($evaluation->micro_approved_by)->full_name:'null'}}
                                                    </small><br>
                                                    <small class="float-right font"><strong>Approval 2: </strong>
                                                        {{\App\Admin::find($evaluation->micro_finalapproved_by)? \App\Admin::find($evaluation->micro_finalapproved_by)->full_name:'null'}}
                                                    </small><br>
                                                    </span>
                                                
                                                      <span>
                                                      <small class="float-right font" style="margin-left: 5px"> 
                                                          <strong>Evaluation: </strong> {!! $evaluation->final_hod_micro_evaluation !!}</small>
                                                      </span>
                                                          @if ($evaluation->micro_grade != null )
                                                          <span>
                                                            <small class="float-right font" style="margin: 0.5px"> <strong>Grade: </strong> {!! $evaluation->micro_grade_report !!}</small>
                                                          </span>  
                                                          @endif 
        
                                                </div>
                                            </a>
                                            <span class="float-right font" style="margin-top:10px">
                                                
                                                 
                                            </span>
                                            <span style="font-size:10px" style="margin-top:10px">
                                                @foreach($evaluation->loadAnalyses as $temp)
                                                @if($evaluation->loadAnalyses->first() == $temp)
                                                {{$temp->created_at->format('d/m/y')}}
                                                @endif
                                                @endforeach
                                            </span>
                                        </div>
                                        </div>
                     
                                    </div>
                                      
                                  </li>
        
                                  @endforeach
                                </ul>
                          </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        
                          
                    </div>
                </div>
               
            </div>
            
            @endif

            @php
            $hod_anex = App\Admin::where('id',Auth::guard('admin')->id())->where('dept_office_id',1)->first()
           @endphp

          @if ($hod_anex->user_type_id ==1)
          <div class="card-body">
            <div class="row clearfix">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>Report(s) Withheld</h6>
                                    @foreach ($hod_withhelds->groupBy('micro_hod_evaluation') as $result_evaluation) 
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
                                    @foreach ($hod_approvals->groupBy('micro_hod_evaluation') as $result_approved) 
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
                                    @foreach ($completeds->groupBy('micro_hod_evaluation') as $result_completed) 
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
        
        </div>
                <div class="card-header row">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <form action="{{route('admin.micro.hod_office.evaluate')}}" method="post">
                                        {{ csrf_field() }} 
                                    <div class="card-header" style="border-color: #ffc107;" >
                                        @foreach($final_reports->groupBy('product_id') as $evaluation)
                                        <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                                           {{count($evaluation)}} 
                                        </label>
                                        @endforeach
                                        <h3>Pending Reports</h3>
                                        <div class="card-header-right">
                                            <ul class="list-unstyled card-option">
                                                <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                                <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                                                <li><i class="ik ik-minus minimize-card"></i></li>
                                                <li><i class="ik ik-x close-card"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                       <span class="" style="padding:5px">
                                        <input class="form-control" id="listSearch3" type="text" placeholder="Type something to search list items">
                                        </span>
                                   
                                      <div class="card-body progress-task" style=" overflow-x: hidden;overflow-y: auto; height:800px; margin-bottom: 30px">
                                        
                                            <ul class="list-group" id="myList3">
                                                @foreach($final_reports->sortBy('micro_process_status') as $evaluation)
                                              <li class="list-group-item" style="padding: 1px;border:1px">
                                                <div class="dd-handle">
                                                        
                                                    <div class="card-body feeds-widget">
                                                    <div class="feed-item">
                                                        <a href="{{url('admin/micro/hod_office/evaluate_one',['id' => $evaluation->id])}}">
                                                            <div class="feeds-left">
                                                                <div class="">
                                                                    <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" name="evaluated_product[]" class="custom-control-input" value="{{$evaluation->id}}">
                                                                        <span class="custom-control-label"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="feeds-body">
                                                                <h4 class="">
                                                                      
                                                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                                            {{$evaluation->code}}
                                                                       </span>
                                                                   
                                                                      <span href="" class="badge pull-right">
                                                                      <p style="font-size: 10px;margin: 2px"></p>
                                                                      </span><br>
                                                                  
                                                                       <span><small class="float-right ">  <strong>Test:</strong> {{count($evaluation->loadAnalyses)}}mla
                                                                        @foreach ($evaluation->loadAnalyses->groupBy('id')->first() as $loadnalyses)
                                                                        @endforeach
                                                                        @if (count($evaluation->efficacyAnalyses)>0)
                                                                        & {{count($evaluation->efficacyAnalyses)}}ea
                                                                        @endif
                                                                        
                                                                      </small>
                                                                     </span><br>   
                                   
                                                                </h4>
                                                            
                                                                <span>
                                                                   
                                                                      <span>
                                                                        <small class="float-right font"><strong>Assigned: </strong>
                                                                            {{\App\Admin::find($evaluation->micro_analysed_by)? \App\Admin::find($evaluation->micro_analysed_by)->full_name:'null'}}
                                                                        </small><br>
                                                                        <small class="float-right font"><strong>Approval 1: </strong>
                                                                            {{\App\Admin::find($evaluation->micro_approved_by)? \App\Admin::find($evaluation->micro_approved_by)->full_name:'null'}}
                                                                        </small><br>
                                                                        <small class="float-right font"><strong>Approval 2: </strong>
                                                                            {{\App\Admin::find($evaluation->micro_finalapproved_by)? \App\Admin::find($evaluation->micro_finalapproved_by)->full_name:'null'}}
                                                                        </small><br>
                                                                        </span>
                                                            
                                                                  <span>
                                                                  <small class="float-right font" style="margin-left: 5px"> 
                                                                      <strong>Evaluation: </strong> {!! $evaluation->final_hod_micro_evaluation !!}</small>
                                                                  </span>
                                                                      @if ($evaluation->micro_grade != null )
                                                                      <span>
                                                                        <small class="float-right font" style="margin: 0.5px"> <strong>Grade: </strong> {!! $evaluation->micro_grade_report !!}</small>
                                                                      </span>  
                                                                      @endif 
                    
                                                            </div>
                                                        </a>
                                                        <span class="float-right font" style="margin-top:10px">
                                                            
                                                             
                                                        </span>
                                                        <span style="font-size:10px" style="margin-top:10px">
                                                            @foreach($evaluation->loadAnalyses as $temp)
                                                            @if($evaluation->loadAnalyses->first() == $temp)
                                                            {{$temp->created_at->format('d/m/y')}}
                                                            @endif
                                                            @endforeach
                                                        </span>
                                                    </div>
                                                    </div>
                                 
                                                </div>
                                                  
                                              </li>
                    
                                              @endforeach
                                            </ul>
                                         
                                      </div>
                                      <span style="padding: 10px;color:#007bff">
                                        <button type="submit" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.completed Reports can not be edited. Thank you')" class="badge badge-success">Complete</button>
                                        <a href="" class="text-dark" style="float: right; "></a>
                                     </span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    
                                      
                                </div>
                            </div>
                           
                            </div>
                
                    </div> 
              </div>
            
         @endif
               
         </div>


    

@endsection