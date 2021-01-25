@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-file-text bg-blue"></i>
                    <div class="d-inline">
                        <h5>Customer details</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                <a class="btn btn-outline-info" href="{{route('admin.sid.customer.create')}}">
                        <i class="ik ik-list"></i> View all Customers
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
                        <img src="{{asset('admin/img/profile.jpg')}}" class="rounded-circle" width="120">
                        <h4 class="card-title mt-10">{{$customer->name}}</h4>
                    </div>
                </div>
                <hr class="mb-0"> 
                <div class="card-body"> 
                    <h6>Email Address</h6> 
                    <small class="text-muted d-block">{{$customer->email}}</small>
                    <h6>Contact</h6>
                    <small class="text-muted d-block">{{$customer->tell}}</small>
                    <h6>Company Name</h6>
                    <small class="text-muted d-block">{{$customer->company_name}}</small>
                    <h6>Company Address</h6>
                    <small class="text-muted d-block">{{$customer->company_address}}</small>
                    <h6>Company Location</h6>
                    <small class="text-muted d-block">{{$customer->company_location}}</small>
                    <h6>Company Phone</h6>
                    <small class="text-muted d-block">{{$customer->company_phone}}</small>
                    <h6>Date</h6>
                    <small class="text-muted d-block">{{$customer->created_at->format('d/ m / Y')}}</small>
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
                        <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Setting</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="dt-responsive">
                                    <table id="scr-vtr-dynamic"
                                           class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Amount Paid</th>
                                            <th>Quantity</th>
                                            <th>Details</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer->product as $p)
                                            <tr>
                                                <td class="font">{{$p->productType->code}}|{{$p->id}}|{{$p->created_at->format('y')}}</td>
                                                <td class="font">{{$p->name}}</td>
                                                <td class="font">{{$p->productType->name}}</td>
                                                <td class="font">{{$p->price}}</td>
                                                <td class="font">{{$p->quantity}}</td>
                                                <td class="">
                                                    {!! $p->show_tag !!}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                
                                    </table>
                              </div>
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