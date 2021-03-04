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
                    {{-- <div class="row" style="margin:1%">
                        <div class="col-md-4">
                            <div class="form-group row" style="margin-left:8%">
                             
                                    {{ Form::open(array('action'=> "AdminAuth\Pharmacology\PharmController@daily_report",  'method'=>'post','class'=>'form-horizontal')) }}
                                    {{form::token()}}
                                    <div class="input-group">
                                        {{ Form::selectRange('year', date('Y') -2, date('Y'),array('class'=>'form-control','placeholder'=>'')) }}
                                        {{ Form::selectMonth('month',array('class'=>'form-control','placeholder'=>'')) }}
                                        <button type="submit" class="btn btn-primary mr-2">Search</button>   
                                    </div>
                                    <input type="hidden" name="product_type" value="{{$ptype_id}}">

                                    {{ Form::close() }}
                               
                                   
                            </div>
                        </div>
                        
                        
                         <div class="col-md-4">
                            <div class="form-group row" style="margin-left:12%">
                               
                                    {{ Form::open(array('action'=> "AdminAuth\Pharmacology\PharmController@monthly_report",  'method'=>'post','class'=>'form-horizontal')) }}
                                    {{form::token()}}
                                   <div class="input-group">
                                       {{ Form::selectRange('year', date('Y') -2, date('Y'),array('class'=>'form-control','placeholder'=>'')) }}
                                       {{ Form::selectMonth('month',array('class'=>'form-control','placeholder'=>'')) }}
                                       <button type="submit" class="btn btn-primary mr-2">search</button>  
                                   </div>
                                   <input type="hidden" name="product_type" value="{{$ptype_id}}">
                                   {{ Form::close() }}
                          </div>
                                                                     
                            
                        </div>

                        <div class="col-md-4">
                            <div class="form-group row" style="margin-left:16%">

                                {{ Form::open(array('action'=>"AdminAuth\Pharmacology\PharmController@yearly_report", 'method'=>'post','class'=>'form-horizontal')) }}
                                    {{Form::token()}}
                                    <div class="input-group">
                                        {{ Form::selectRange('year',date('Y') -2, date('Y'), array('class'=>'form-control','placeholder'=>'')) }}
                                        <button type="submit" class="btn btn-primary mr-2">Search</button>    
                                    </span>
                                    </div>
                                 <input type="hidden" name="product_type" value="{{$ptype_id}}">
                               {{ Form::close() }} 
                             </div>
                        </div>
                
                    </div> --}}
                </div>
                      
                    <div class="card">
                            <div class="card-header row">
                                <div class="card-header">
                                    <label class="badge badge-warning" style="background-color:#26c281; margin-right:5px;">
                                        {{count($dept2)}}
                                    </label>
                                    <h3>Total {{\App\ProductType::find($ptype_id)->name}} Reports completed</h3>
            
                                 </div>
                                <div class="card-body">
                                    <table id="order-table_labs" class="table table-striped table-bordered nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> Batch</th>
                                                <th>Product</th>
                                                <th>Product Type</th>
                                                <th>Quantity</th>
                                                <th>status</th>
                                                <th style=""></th>
                                                <th>Delivered by</th>
                                                <th>Received by</th>
                                                <th>Actions</th>                        
                                           </tr>
                                        </thead>
                                        <tbody>                                            
                                            @foreach($dept2 as $pharmproduct)
                                            <tr>
                                                    <td>
                                                        <div class="form-check mx-sm-2">
                                                            <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="deptproduct_id[]" value="{{$pharmproduct->id}}" >
                                                                <span class="custom-control-label">&nbsp; </span>
                                                            </label>
                                                        </div>
                                                    </td> 
                                                    <td class="font">B{{$pharmproduct->pivot->updated_at->format('dym')}}</td>
                                                    <td class="font">
                                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                            {{$pharmproduct->code}}
                                                        </span>
                                                        @if ($pharmproduct->isReviewedByDept(2))
                                                        <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;">R</span></sup>
                                                        @endif
                                                    </td>
                                                    
                                                    <td class="font">{{ucfirst($pharmproduct->productType->name)}}</td>
                                                    <td class="font">{{$pharmproduct->pivot->quantity}}</td>
                                                    <td>{!! $pharmproduct->product_status !!}</td>
                                                    <td><p style="display: none">{{$pharmproduct->pivot->status}}</p></td>
                                                    <td class="font">
                                                        {{ucfirst(\App\Admin::find($pharmproduct->pivot->delivered_by)? \App\Admin::find($pharmproduct->pivot->delivered_by)->full_name:'null')}}
                                                    </td>
                                                    <td class="font">
                                                        {{ucfirst(\App\Admin::find($pharmproduct->pivot->received_by)? \App\Admin::find($pharmproduct->pivot->received_by)->full_name:'null')}}
                                                    </td>
                                                    <td>
                                                    <div class="table-actions">
                                                                                            
                                                    <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$pharmproduct->id}}" title="View" href=""><i class="ik ik-eye"></i></a>
                                                    <a title="Edit" href=""><i class="ik ik-edit"></i></a>
                    
                                                    </div>
                                                <div class="modal fade" id="demoModal{{$pharmproduct->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                    
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="demoModalLabel"> Parmmacology Product Details </h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="card-body"> 
                                                                        
                                                                        <h6> Product </h6>
                                                                        <small class="text-muted ">{{$pharmproduct->productType->code}}|{{$pharmproduct->id}}|{{$pharmproduct->created_at->format('y')}}</small>
                                                                        <h6>Product Type </h6>
                                                                        <small class="text-muted ">{{ucfirst($pharmproduct->productType->name)}}</small>
                                                                        <h6>Quantity</h6>
                                                                        <small class="text-muted "> {{$pharmproduct->pivot->quantity}}</small>
                                                                        <h6>Indication</h6>
                                                                        <p class="text-muted"> {{ ucfirst($pharmproduct->indication)}}<br></p>
                    
                                                                        <hr><h5>Distribution Details</h5>
                                                                        @foreach ($pharmproduct->productDept->groupBy('id')->first() as $distribution)
                                                                        <h6>Received By </h6>
                                                                        {{-- {{-- <small class="text-muted ">{{ucfirst($distribution->received_by_admin)}}</small>
                                                                        <h6>Distributed By </h6> --}}
                                                                        <small class="text-muted">{{ucfirst($distribution->distributed_by_admin)}}</small>
                                                                        <h6>Delivered By </h6>
                                                                        <small class="text-muted"> {{ucfirst($distribution->delivered_by_admin)}}</small>
                                                                        
                                                                        @endforeach
                    
                                                                        {{-- <hr><h5>Customer Details</h5>
                                                                        
                                                                        <h6>Name</h6>
                                                                        <small class="text-muted ">{{ucfirst($pharmproduct->customer->name)}}</small>
                                                                        <h6>Tell</h6>
                                                                        <small class="text-muted ">{{ucfirst($pharmproduct->customer->tell)}}</small> --}}
                                                                        
                                                                        <hr><h5>Distribution Periods</h5>
                                                                        <div  style="margin-bottom: 5px">
                                                                        <h6 >product distribution period</h6>
                                                                        <small class="text-muted">
                                                                        Date: {{$pharmproduct->pivot->created_at->format('Y-m-d')}}
                                                                        Time: {{$pharmproduct->pivot->created_at->format('H:i:s')}}
                                                                        </small>
                                                                        </div>
                                                                        <h6> product delivery period</h6>
                                                                        <small class="text-muted ">
                                                                        Date: {{$pharmproduct->pivot->updated_at->format('Y-m-d')}}
                                                                        Time: {{$pharmproduct->pivot->updated_at->format('H:i:s')}}
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