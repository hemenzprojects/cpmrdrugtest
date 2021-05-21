@extends('admin.layout.main')

@section('content')
              
@include('admin.sid.temp.dashboardtemp')


 @if (Auth::guard('admin')->user()->dept_id == 1)
    
    <div class="">
        <div class="">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6> Products at the lab</h6>
                                    <h2> {{count($micro_products)}}
                                    </h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-square"></i>  
                                </div>
                            </div>
                            <small class="text-small mt-10 d-block">Total number of distributed products </small>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>Completed Products</h6>
                                    <h2>{{count($micro_completedproduct)}}</h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-square"></i>  
                                </div>
                            </div>
                            <small class="text-small mt-10 d-block">Total number of product tested in a year</small>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>Pending Products</h6>
                                    <h2>{{count($micro_pendingproduct)}}</h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-square"></i>  
                                </div>
                            </div>
                            <small class="text-small mt-10 d-block">Total number of Pending products in a year</small>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>Failed Products</h6>
                                    <h2>{{count($micro_failedproduct)}}</h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-message-square"></i>
                                </div>
                            </div>
                            <small class="text-small mt-10 d-block">Total number of failed products in a year</small>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
        

{{-- 
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Hello {{Auth::guard('admin')->user()->full_name}} !</strong> You have
        @foreach (App\ProductDept::where('dept_id', Auth::guard('admin')->user()->dept_id)->where('status',1)->get()->groupBy('status') as $item)
           {{count($item)}}
        @endforeach
        pending products to be received from SID.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ik ik-x"></i>
        </button>
    </div> --}}

 @endif


 @if (Auth::guard('admin')->user()->dept_id ==2 && (Auth::guard('admin')->user()->dept_office_id == 1 || Auth::guard('admin')->user()->dept_office_id ==2  ))
    
   @include('admin.pharm.temp.dashboardtemp')
@endif

@if (Auth::guard('admin')->user()->dept_office_id ==3)
    
 <div class="">
     <div class="">
         <div class="row clearfix">
             <div class="col-lg-3 col-md-6 col-sm-12">
                 <div class="widget">
                     <div class="widget-body">
                         <div class="d-flex justify-content-between align-items-center">
                             <div class="state">
                                 <h6>Pending Products </h6>
                                 <h2> {{count($pharm_animalexp_products)}}
                                 </h2>
                             </div>
                             <div class="icon">
                                <i class="ik ik-square"></i> 
                                                        </div>
                         </div>
                         <small class="text-small mt-10 d-block">Total number of products at Animal house</small>
                     </div>
                     <div class="progress progress-sm">
                         <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-12">
                 <div class="widget">
                     <div class="widget-body">
                         <div class="d-flex justify-content-between align-items-center">
                             <div class="state">
                                 <h6>Completed Experiment</h6>
                                 <h2>{{count($pharm_completedexperiments)}}</h2>
                             </div>
                             <div class="icon">
                                <i class="ik ik-square"></i>
                             </div>
                         </div>
                         <small class="text-small mt-10 d-block">Total number of completed experiment </small>
                     </div>
                     <div class="progress progress-sm">
                         <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-12">
                 <div class="widget">
                     <div class="widget-body">
                         <div class="d-flex justify-content-between align-items-center">
                             <div class="state">
                                 <h6>Acute Toxicity Tests</h6>
                                 <h2>{{count($acute_toxicty_total)}}</h2>
                             </div>
                             <div class="icon">
                                <i class="ik ik-square"></i>
                             </div>
                         </div>
                         <small class="text-small mt-10 d-block">Total number of Acute toxicity test in a year</small>
                     </div>
                     <div class="progress progress-sm">
                         <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-12">
                 <div class="widget">
                     <div class="widget-body">
                         <div class="d-flex justify-content-between align-items-center">
                             <div class="state">
                                 <h6>Dermal Toxicity Tests</h6>
                                 <h2>{{count($dermal_toxicty_total)}}</h2>
                             </div>
                             <div class="icon">
                                 <i class="ik ik-message-square"></i>
                             </div>
                         </div>
                         <small class="text-small mt-10 d-block">Total number of dermal toxicity test in a year</small>
                     </div>
                     <div class="progress progress-sm">
                         <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                     </div>
                 </div>
             </div>
         </div>
     
     </div>
 </div>
@endif

@if (Auth::guard('admin')->user()->dept_id ==3)
    
 <div class="">
     <div class="">
         <div class="row clearfix">
             <div class="col-lg-3 col-md-6 col-sm-12">
                 <div class="widget">
                     <div class="widget-body">
                         <div class="d-flex justify-content-between align-items-center">
                             <div class="state">
                                 <h6> Products at the lab</h6>
                                 <h2> {{count($phyto_products)}}
                                 </h2>
                             </div>
                             <div class="icon">
                                <i class="ik ik-square"></i>         
                                                </div>
                         </div>
                         <small class="text-small mt-10 d-block">Total number of distributed products </small>
                     </div>
                     <div class="progress progress-sm">
                         <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-12">
                 <div class="widget">
                     <div class="widget-body">
                         <div class="d-flex justify-content-between align-items-center">
                             <div class="state">
                                 <h6>Completed Products</h6>
                                 <h2>{{count($phyto_completedproduct)}}</h2>
                             </div>
                             <div class="icon">
                                <i class="ik ik-square"></i>  
                             </div>
                         </div>
                         <small class="text-small mt-10 d-block">Total number of product tested in a year</small>
                     </div>
                     <div class="progress progress-sm">
                         <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-12">
                 <div class="widget">
                     <div class="widget-body">
                         <div class="d-flex justify-content-between align-items-center">
                             <div class="state">
                                 <h6>Pending Products</h6>
                                 <h2>{{count($phyto_pendingproduct)}}</h2>
                             </div>
                             <div class="icon">
                                <i class="ik ik-square"></i>  
                             </div>
                         </div>
                         <small class="text-small mt-10 d-block">Total number of Pending products in a year</small>
                     </div>
                     <div class="progress progress-sm">
                         <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                     </div>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6 col-sm-12">
                 <div class="widget">
                     <div class="widget-body">
                         <div class="d-flex justify-content-between align-items-center">
                             <div class="state">
                                 <h6>Failed Products</h6>
                                 <h2>{{count($phyto_failedproduct)}}</h2>
                             </div>
                             <div class="icon">
                                 <i class="ik ik-message-square"></i>
                             </div>
                         </div>
                         <small class="text-small mt-10 d-block">Total number of failed products in a year</small>
                     </div>
                     <div class="progress progress-sm">
                         <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                     </div>
                 </div>
             </div>
         </div>
     
     </div>
 </div>
@endif

@endsection
