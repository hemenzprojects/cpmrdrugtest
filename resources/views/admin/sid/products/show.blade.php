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
                    <a class="btn btn-outline-info" href="{{route('admin.sid.product.edit', ['id' => $product->id])}}">
                        <i class="ik ik-list"></i> Edit Product
                    </a>
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
                        <img src="{{asset('admin/img/profile.jpg')}}" class="rounded-circle" width="150">
                        <h4 class="card-title mt-10">{{$product->customer->name}}</h4>
                        <p class="card-subtitle"> </p>
                      
                    </div>
                </div>
                <hr class="mb-0"> 
                <div class="card-body"> 
                    <small class="text-muted d-block">Email address </small>
                    <h6>{{$product->customer->email}}</h6> 
                    <small class="text-muted d-block pt-10">Phone</small>
                    <h6>{{$product->customer->tell}}</h6>
                    <small class="text-muted d-block pt-10">Alt Phone</small>
                    <h6>{{$product->customer->tell_alt}}</h6> 
                    <small class="text-muted d-block pt-10">Street Address</small>
                    <h6>{{$product->customer->street_address}}</h6>
                    <small class="text-muted d-block pt-10">House Number</small>
                    <h6>{{$product->customer->house_number}}</h6>
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
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Product Status</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Setting</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                        <div class="card-body">
                             <div class="row"> 
                                <div class="col-md-3 col-6"> <strong>Poduct code</strong>
                                    <br>
                                    <p class="text-muted">{{$product->productType->code}}|{{$product->id}}|{{$product->created_at->format('y')}}</p>
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
                            <div class="col-md-12 col-12"> <strong>Indication</strong>
                                <br>
                                <p class="text-muted">{{ucfirst($product->indication)}}</p>
                            </div>
                          
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="card-body">
                           
                            <hr>
                          
                            <h6 class="mt-30">Pharmachology <span class="pull-right">80%</span></h6>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">50% Complete</span> </div>
                            </div>
                            <h6 class="mt-30">Microbiology <span class="pull-right">90%</span></h6>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:90%;"> <span class="sr-only">50% Complete</span> </div>
                            </div>
                            <h6 class="mt-30">phytochemistry <span class="pull-right">50%</span></h6>
                            <div class="progress  progress-sm">
                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;"> <span class="sr-only">50% Complete</span> </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                        <div class="card-body">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection