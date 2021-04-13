@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-file-text bg-blue"></i>
                    <div class="d-inline">
                        <h5>Product details</h5>
                        <span>View all details of {{$product->name}}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    @if ($product->overall_status <1)
                    <a class="btn btn-outline-info" href="{{route('admin.sid.product.edit', ['id' => $product->id])}}">
                        <i class="ik ik-list"></i> Edit Product
                    </a>
                    @endif
                    <a class="btn btn-outline-danger" href="{{ old('redirect_to', URL::previous())}}">
                        <i class="ik ik-arrow-left"></i> Previous
                    </a>
                   
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
     
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center"> 
                        <h5>Customer Details</h5>
                        <img src="{{asset('admin/img/profile.jpg')}}" class="rounded-circle" width="120">
                        <h4 class="card-title mt-10"></h4>
                        <p class="card-subtitle"> </p>
                      
                    </div>
                </div>
                <hr class="mb-0"> 
                <div class="card-body"> 
                    @if ($checkperm)
                    <div class="card-body"> 
                        <h6>Name</h6> 
                        <small class="text-muted d-block">{{$product->customer->name}}</small>
                        <h6>Email Address</h6> 
                        <small class="text-muted d-block">{{$product->customer->email}}</small>
                        <h6>Contact</h6>
                        <small class="text-muted d-block">{{$product->customer->tell}}</small>
                        <h6>Company Name</h6>
                        <small class="text-muted d-block">{{$product->customer->company_name}}</small>
                        <h6>Company Address</h6>
                        <small class="text-muted d-block">{{$product->customer->company_address}}</small>
                        <h6>Company Location</h6>
                        <small class="text-muted d-block">{{$product->customer->company_location}}</small>
                        <h6>Company Phone</h6>
                        <small class="text-muted d-block">{{$product->customer->company_phone}}</small>
                       
                        <br>
                       
                    </div>
                    @endif
                    @if (!$checkperm)
                    <div class="alert alert-warning" role="alert">
                        Sorry customer records cant be displayed 
                      </div>
                    @endif
                    <br>
                   
                </div>
            </div>
        </div>
  
      
        <div class="col-lg-8 col-md-7">
            <div class="card">
                <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">Product details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Product Report Status</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Product History</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                        <div class="card-body">
                             <div class="row"> 
                                <div class="col-md-3 col-6"> <strong>Poduct code</strong>
                                    <br>
                                    <p class="text-muted">{{$product->code}}</p>
                                </div>
                            
                             </div>
                             <hr>
                            <div class="row">
                                
                                <div class="col-md-3 col-6"> <strong>Poduct Name</strong>
                                    <br>
                                    <p class="text-muted">{{ucfirst($product->name)}}</p>
                                </div>
                                <div class="col-md-3 col-6"> <strong>Product Type</strong>
                                    <br>
                                    <p class="text-muted">{{ucfirst($product->productType->name)}}</p>
                                </div>
                                
                                <div class="col-md-3 col-6"> <strong>Amount Paid</strong>
                                    <br>
                                    <p class="text-muted">{{$product->price}}</p>
                                </div>
                                <div class="col-md-3 col-6"> <strong>Receipt Number</strong>
                                    <br>
                                    <p class="text-muted">{{$product->receipt_num}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3 col-6"> <strong>Date Manufactured</strong>
                                    <br>
                                    <p class="text-muted">{{$product->mfg_date}}</p>
                                </div>
                                <div class="col-md-3 col-6"> <strong>Expiry Date</strong>
                                    <br>
                                    <p class="text-muted">{{$product->exp_date}}</p>
                                </div>
                              
                                <div class="col-md-3 col-6"> <strong>Created By</strong>
                                    <br>
                                    <p class="text-muted">{{ucfirst($product->created_by)}}</p>
                                </div>
                                <div class="col-md-3 col-6"> <strong>Date Recieved </strong>
                                    <br>
                                    <p class="text-muted">{{\Carbon\Carbon::parse($product->created_at)->format('d-m-y')}}</p>
                                </div>
                            </div>
                            <hr>
                          <div class="row">
                            <div class="col-md-3 col-6"> <strong>Dosage</strong>
                                <br>
                                <p class="text-muted">{{ucfirst($product->dosage)}}</p>
                            </div>
                            <div class="col-md-3 col-6"> <strong>Indication</strong>
                                <br>
                                <p class="text-muted">{{ucfirst($product->indication)}}</p>
                            </div>
                            <div class="col-md-6 col-6"> 

                               
                               @if ($product->single_multiple_lab ==1)
                               <strong>Single Lab</strong> <br>
                               Test to be conducted if various Labs:
                                    @if ($product->micro_grade == Null ||$product->micro_analysed_by != Null)
                                    <li> Microbiology Lab</li>
                                    @endif
                                    @if ($product->pharm_grade == Null ||$product->pharm_analysed_by != Null)
                                    <li> Pharmachology Lab</li>
                                    @endif @if ($product->phyto_grade == Null ||$product->phyto_analysed_by != Null)
                                    <li> Phytochemistry Lab<li>
                                    @endif
                               @endif
                               @if ($product->single_multiple_lab ==2)
                               <strong>Multiple Labs</strong> <br>

                               Test to be conducted if various Labs:
                                    @if ($product->micro_grade == Null ||$product->micro_analysed_by != Null)
                                    <li> Microbiology Lab</li>
                                    @endif
                                    @if ($product->pharm_grade == Null ||$product->pharm_analysed_by != Null)
                                    <li> Pharmachology Lab</li>
                                    @endif @if ($product->phyto_grade == Null  ||$product->phyto_analysed_by != Null)
                                    <li> Phytochemistry Lab<li>
                                    @endif
                               @endif
                            </div>
                          </div>
                            
                          
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="card-body">
                           
                            <hr>
                            
                           
                            @foreach ($product->productDept->where('dept_id',1) as $item)

                            
                            @if($item->status ==1)
                            <h6 class="mt-30">Microbiology <span class="pull-right">10%</span></h6><span>Product is yet to be distributed to department </span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:10%;"> <span class="sr-only">90% Complete</span> </div>
                            </div>
                            @endif
                            @if($item->status ==2)
                            <h6 class="mt-30">Microbiology <span class="pull-right">40%</span></h6><span>Product about to begin report process </span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:40%;"> <span class="sr-only">60% Complete</span> </div>
                            </div>
                            @endif

                            @if(($item->status ===3) && ($product->micro_hod_evaluation === Null))
                            <h6 class="mt-30">Microbiology <span class="pull-right">65%</span></h6><span>Report preparation in progress</span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:65%;"> <span class="sr-only">35% Complete</span> </div>
                            </div>
                            @endif 

                            @if(($item->status ===3) && ($product->micro_hod_evaluation === 0))
                            <h6 class="mt-30">Microbiology <span class="pull-right">70%</span></h6><span>Report preparation in progress</span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:70%;"> <span class="sr-only">30% Complete</span> </div>
                            </div>
                            @endif 

                            @if(($item->status ===3) && ($product->micro_hod_evaluation === 1))
                            <h6 class="mt-30">Microbiology <span class="pull-right">75%</span></h6><span>Report preparation in progress. <strong>Grade</strong> {!! $product->micro_grade_report !!}</span></span></span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:75%;"> <span class="sr-only">25% Complete</span> </div>
                            </div>
                            @endif 

                            @if(($item->status ===3) && ($product->micro_hod_evaluation > 1))
                            <h6 class="mt-30">Microbiology <span class="pull-right">90%</span></h6><span>Product Report Evaluation. <strong>Grade</strong> {!! $product->micro_grade_report !!}</span></span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:90%;"> <span class="sr-only">30% Complete</span> </div>
                            </div>

                            @endif 
                            @if($item->status ==4)
                            <h6 class="mt-30">Microbiology <span class="pull-right">100% </span></h6><span>Product report completed. <strong>Grade</strong> {!! $product->micro_grade_report !!}</span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:100%;"> <span class="sr-only">Completed</span> </div>
                            </div>
                            @endif
                            @endforeach


         
                            @foreach ($product->productDept->where('dept_id',2) as $item)
                           

                            @if($item->status ==1)
                            <h6 class="mt-30">Pharmachology <span class="pull-right">10%</span></h6></h6><span>Product is yet to be distributed to department </span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:10%;"> <span class="sr-only">90% Complete</span> </div>
                            </div>
                            @endif
                            @if($item->status ==2)
                            <h6 class="mt-30">Pharmachology <span class="pull-right">40%</span></h6><span>Product about to begin report process </span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%;"> <span class="sr-only">60% Complete</span> </div>
                            </div>
                            @endif
                            @if($item->status ==3)
                            <h6 class="mt-30">Pharmachology <span class="pull-right">60%</span></h6><span>Product Test in progress</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span class="sr-only">40% Complete</span> </div>
                            </div>
                            @endif

                            @if($item->status ===7)
                            <h6 class="mt-30">Pharmachology <span class="pull-right">75%</span></h6><span>Product under Experimentation. <strong>Grade</strong> {!! $product->pharm_grade_report !!}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:75%;"> <span class="sr-only">25% Complete</span> </div>
                            </div>
                            @endif

                            @if(($item->pharm_hod_evaluation > 1))
                            <h6 class="mt-30">Pharmachology <span class="pull-right">90%</span></h6><span>Report Evaluation. <strong>Grade</strong> {!! $product->pharm_grade_report !!}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:90%;"> <span class="sr-only">10% Complete</span> </div>
                            </div>
                            @endif

                            @if($item->status ==8)
                            <h6 class="mt-30">Pharmachology <span class="pull-right">100%</span></h6><span>Product report completed. <strong>Grade</strong>  {!! $product->pharm_grade_report !!}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:100%;"> <span class="sr-only">Completed</span> </div>
                            </div>
                            @endif
                            @endforeach

                            

                            @foreach ($product->productDept->where('dept_id',3) as $item)
                            

                            @if($item->status ==1)
                            <h6 class="mt-30">Phytochemistry <span class="pull-right">10%</span></h6><span>Product is yet to be distributed to department </span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:10%;"> <span class="sr-only">70% Complete</span> </div>
                            </div>   
                            @endif
                            @if($item->status ==2)
                            <h6 class="mt-30">Phytochemistry <span class="pull-right">40%</span></h6><span> Product about to begin report process</span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%;"> <span class="sr-only">60% Complete</span> </div>
                            </div>   
                            @endif
                            @if(($item->status ===3) && ($product->phyto_hod_evaluation === Null))
                            <h6 class="mt-30">Phytochemistry <span class="pull-right">65%</span></h6><span>Report preparation in progress</span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:65%;"> <span class="sr-only">35% Complete</span> </div>
                            </div>
                            @endif 

                            @if(($item->status ===3) && ($product->phyto_hod_evaluation === 0))
                            <h6 class="mt-30">Phytochemistry <span class="pull-right">70%</span></h6><span>Report preparation in progress</span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:70%;"> <span class="sr-only">30% Complete</span> </div>
                            </div>
                            @endif 

                            @if(($item->status ===3) && ($product->phyto_hod_evaluation === 1))
                            <h6 class="mt-30">Phytochemistry <span class="pull-right">75%</span></h6><span>Product Report Evaluation.  <strong>Grade</strong> {!! $product->phyto_grade_report !!}</span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:75%;"> <span class="sr-only">25% Complete</span> </div>
                            </div>
                            @endif 

                            @if(($item->status ===3) && ($product->phyto_hod_evaluation > 1))
                            <h6 class="mt-30">Phytochemistry <span class="pull-right">90%</span></h6><span>Product Report Evaluation. <strong>Grade</strong> {!! $product->phyto_grade_report !!}</span></span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:90%;"> <span class="sr-only">30% Complete</span> </div>
                            </div>
                            @endif 
                            @if($item->status ==4)
                            <h6 class="mt-30">Phytochemistry <span class="pull-right">100%</span></h6><span>Product report completed. <strong>Grade</strong> {!! $product->phyto_grade_report !!}</span>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;"> <span class="sr-only">Completed</span> </div>
                            </div>   
                            @endif
                            @endforeach
                            
                          
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="dt-responsive">
                                    <table id=""
                                           class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Amount Paid</th>
                                            <th>Micro</th>
                                            <th>Pharm</th>
                                            <th>Phyto</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product_history as $p)
                                            <tr>
                                                <td class="font">
                                               <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                    {{$p->code}}
                                                </span></td>
                                                <td class="font">{{$p->name}}</td>
                                                <td class="font">{{$p->productType->name}}</td>
                                                <td class="font">{{$p->price}}</td>
                                                <td class="font">{!! $p->micro_grade_report !!}</td>
                                                <td class="font">{!! $p->pharm_grade_report !!}</td>
                                                <td class="font">{!! $p->phyto_grade_report !!}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                
                                    </table>
                              </div>
                          </div>
                        </div>
                    </div>
                </div>
                @if ($product->overall_status == 2)
                @if ($product->failed_final_grade)
                <div class="card-body template-demo">
                    <a   href="{{route('admin.sid.product.review', ['id' => $product->id])}}">
                    <button type="button" onclick="return confirm('Note: All levels of lab preparations must be completed or 100%. Before reviewing product, Check product report status.')" class="btn btn-info btn-block">PRODUCT ASSESSMENT</button>
                    </a>
                </div>  
                @endif
                @endif
              
                {{-- <div class="card-body template-demo">
                    <a   href="{{route('admin.sid.product.review', ['id' => $product->id])}}">
                    <button type="button" onclick="return confirm('Note: All levels of lab preparations must be completed or 100%. Before reviewing product, Check product report status.')" class="btn btn-info btn-block">PRODUCT ASSESSMENT</button>
                    </a>
                </div>  --}}
            </div>
        </div>
 

       
        
    </div>
</div>

@endsection