@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="text-center" style="margin: 2%"> 
                        <h4 class="font" style="font-size:18px">List of Pending {{\App\ProductType::find($ptype_id)->name}}</h4>
                       <p class="card-subtitle"> Below shows generate report on {{\App\ProductType::find($ptype_id)->name}}</p>
                      </div>
                  
                </div>
                      
                    <div class="card">
                            <div class="card-header row">
                                <div class="card-header">
                                    <label class="badge badge-warning" style="background-color:#26c281; margin-right:5px;">
                                        {{count($dept1)}}
                                    </label>
                                    <h3>Total of pending {{\App\ProductType::find($ptype_id)->name}}</h3>
            
                                 </div>
                                <div class="card-body">
                                    <table id="order-table_labs" class="table table-striped table-bordered nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>Batch No</th>
                                                <th>Product</th>
                                                <th>Product Type</th>
                                                <th>Quantity</th>
                                                <th>status</th>
                                                <th style="display: none">status id</th>
                                                <th>Delivered by</th>
                                                <th>Received by</th>
                                                <th>Actions</th>                        
                                           </tr>
                                        </thead>
                                        <tbody>                                            
                                            @foreach($dept1 as $microproduct)
                                            <tr>
                                              
                                                    <td class="font">B{{$microproduct->pivot->updated_at->format('dym')}}
                                                    </td>
                                                    <td class="font">
                                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                            {{$microproduct->code}}
                                                        </span>
                                                        @if ($microproduct->isReviewedByDept(1))
                                                        <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;">R</span></sup>
                                                        @endif
                                                    </td>
                                                    <td class="font">{{ucfirst($microproduct->productType->name)}}</td>
                                                    <td class="font">{{$microproduct->pivot->quantity}}</td>
                                                    {!! $microproduct->product_status !!}
                                                    <td style="display: none">{{$microproduct->pivot->status}}</td>
                                                    <td class="font">
                                                        {{ucfirst(\App\Admin::find($microproduct->pivot->delivered_by)? \App\Admin::find($microproduct->pivot->delivered_by)->full_name:'null')}}
                                                    </td>
                                                    <td class="font">
                                                        {{ucfirst(\App\Admin::find($microproduct->pivot->received_by)? \App\Admin::find($microproduct->pivot->received_by)->full_name:'null')}}
                                                    </td>
                                                                                                                                
                                                    <td>
                                                    <div class="table-actions">
                                                                                            
                                                    <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$microproduct->id}}" title="View" href=""><i class="ik ik-eye"></i></a>
                                                    <a title="Edit" href=""><i class="ik ik-edit"></i></a>
                    
                                                    </div>
                                                <div class="modal fade" id="demoModal{{$microproduct->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="demoModalLabel"> Microbiology Product Details </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body"> 
                                                                        
                                                                        <h6> Product Name </h6>
                                                                        <small class="text-muted ">{{$microproduct->productType->code}}|{{$microproduct->id}}|{{$microproduct->created_at->format('y')}}</small>
                                                                        <h6>Product Type </h6>
                                                                        <small class="text-muted ">{{ucfirst($microproduct->productType->name)}}</small>
                                                                        <h6>Quantity</h6>
                                                                        <small class="text-muted "> {{$microproduct->pivot->quantity}}</small>
                                                                        <h6>Indication</h6>
                                                                        <p class="text-muted"> {{ ucfirst($microproduct->indication)}}<br></p>
                    
                                                                        <h6>Dosage</h6>
                                                                        <p class="text-muted"> {{ ucfirst($microproduct->dosage)}}<br></p>
                    
                                                                        <hr><h5>Distribution Details</h5>
                                                                        <h6>Received By </h6>
                                                                        <small class="text-muted ">
                                                                            {{ucfirst(\App\Admin::find($microproduct->pivot->distributed_by)? \App\Admin::find($microproduct->pivot->distributed_by)->full_name:'null')}}
                                                                        </small>
                     
                                                                        <h6>Delivered By </h6>
                                                                        <small class="text-muted">
                                                                            {{ucfirst(\App\Admin::find($microproduct->pivot->delivered_by)? \App\Admin::find($microproduct->pivot->delivered_by)->full_name:'null')}}
                    
                                                                        </small>
                                                                                                                          
                                                                        {{-- <hr><h5>Customer Details</h5>
                                                                        
                                                                        <h6>Name</h6>
                                                                        <small class="text-muted ">{{ucfirst($microproduct->customer->name)}}</small>
                                                                        <h6>Tell</h6>
                                                                        <small class="text-muted ">{{ucfirst($microproduct->customer->tell)}}</small> --}}
                                                                        
                                                                        <hr><h5>Distribution Periods</h5>
                                                                        <div  style="margin-bottom: 5px">
                                                                        <h6 >product distribution period</h6>
                                                                        <small class="text-muted">
                                                                        Date: {{$microproduct->pivot->created_at->format('Y-m-d')}}
                                                                        Time: {{$microproduct->pivot->created_at->format('H:i:s')}}
                                                                        </small>
                                                                        </div>
                                                                        <h6> product delivery period</h6>
                                                                        <small class="text-muted ">
                                                                        Date: {{$microproduct->pivot->updated_at->format('Y-m-d')}}
                                                                        Time: {{$microproduct->pivot->updated_at->format('H:i:s')}}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> 
                                
                            </div>
                    </div>
                
            </div>
        </div>
</div>
@endsection