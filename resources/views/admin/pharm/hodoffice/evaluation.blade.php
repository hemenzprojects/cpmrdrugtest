@extends('admin.layout.main')

@section('content')
@php
$hod_anex = App\Admin::where('id',Auth::guard('admin')->id())->where('dept_office_id',1)->first()
@endphp

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
            
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="padding:1%">
                

                @php
                 $hod_assist = App\Admin::where('id',Auth::guard('admin')->id())->where('dept_office_id',1)->first()
               @endphp
                @if ($hod_assist->user_type_id ==2)

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
                <div class="card">
                    <div class="col-md-4">
                        @include('admin.pharm.temp.hodtaskboard1') 
                        @include('admin.pharm.temp.hodtaskboard2') 

                    </div>
                     <div class="col-md-8">

                     </div>
                </div> 
                @endif
              
              

                @if ($hod_anex->user_type_id ==1)
                <div class="card">
                    <div class="col-md-4">
                        @include('admin.pharm.temp.hodtaskboard2') 
                    </div>
               </div> 
                @endif
                
              

            </div>
        </div>
    </div>
</div>
@endsection              