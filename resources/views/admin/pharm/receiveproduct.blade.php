@extends('admin.layout.main')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                {{-- <i class="ik ik-edit bg-blue"></i> --}}
                <div class="d-inline">
                    <h5>Product Acceptance Section</h5>
                    <span>Bellow are product sent from SID Drud Analysis with its status</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href=""><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Group Add-Ons</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
{{-- @foreach( $errors->all() as $error)
<li>{{$error}}</li>
@endforeach --}}

<div class="row">
    <div class="col-md-12">
      <div class="card" style="overflow-x: scroll">
             <div class="card-body">
                <form  action="{{route('admin.pharm.productlist.search')}}" class="" method="POST">
                    {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-1">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                               <a data-toggle="modal" data-target="#demoModal">
                                   <div class="page-header">
                                        <div class="col-md-6">
                                            <div class="page-header-title">
                                                    <i class="ik ik-edit bg-blue"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                      
                                    </div>
                                </a>
                            
                            </div>
                        
                        </div>
                    </div>
                    
                        <div class="col-md-3">
                                <div class="form-group">
                                    <select name="product_type_id" class="form-control select2">
                                        <option value="">Select Product Type </option>
                                        @foreach($product_types as $product_type)
                                                                        
                                        <option value="{{$product_type->id}}" {{$product_type->id == old('product_type_id')? "selected":""}}>{{$product_type->name}}</option>
        
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="status" class="form-control select2">
                                    <option value="">Select Product Status </option>
                                    <option value="1">Pending</option>
                                    <option value="2">Received</option>
                                    <option value="3">Inprogress</option>
                                    <option value="4">Completed</option>
        
        
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="date" class="form-control select2">
                                    <option value="">Select Period</option>
                                    <option value="1">Weekly</option>
                                    <option value="2">Monthly</option>
        
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary mr-2">Search List</button>
                        </div>
                    
                </div>
               </form>
                <form  id="acceptpharmproductform" sign-user-url="{{route('admin.pharm.checkuser')}}" action="{{route('admin.pharm.acceptproduct')}}" class="" method="POST">
                    {{ csrf_field() }}
                    
                    <input id ="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
          
                    <table id="order-table_labs" class="table table-striped table-bordered nowrap dataTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Batch No</th>
                            <th>Product</th>
                            <th>Product Type</th>
                            <th>Quantity</th>
                            <th>status</th>
                            <th style="display: none">status id</th>
                            <th>Distributed by</th>
                            <th>Received by</th>
                            <th>Date</th>
                            <th>Actions</th>                      
                       </tr>
                    </thead>
                    <tbody>                                            
                        @if ($product_type_id<1)                                            
                        @foreach($dept2 as $pharmacology)
                       
                        <tr>
                                <td>
                                    <div class="form-check mx-sm-2">
                                        <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input pharmselect"  value="{{$pharmacology->id}}" >
                                            <span class="custom-control-label">&nbsp; </span>
                                        </label>
                                    </div>
                                </td>
                                <td class="font">B{{$pharmacology->pivot->updated_at->format('dym')}}</td>
                                <td class="font">

                                    <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                        {{$pharmacology->code}}
                                    </span>   

                                    @if ($pharmacology->isReviewedByDept(2))
                                    <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;">R</span></sup>
                                    @endif
                                </td>
                               <td class="font">{{ucfirst($pharmacology->productType->name)}}</td>
                                <td class="font">{{$pharmacology->pivot->quantity}}</td>
                                <td>{!! $pharmacology->product_status !!}</td>
                                <td style="display: none">{{$pharmacology->pivot->status}}</td>
                                <td class="font">
                                    {{ucfirst(\App\Admin::find($pharmacology->pivot->delivered_by)? \App\Admin::find($pharmacology->pivot->delivered_by)->full_name:'null')}}
                                </td>
                                <td class="font">
                                    {{ucfirst(\App\Admin::find($pharmacology->pivot->received_by)? \App\Admin::find($pharmacology->pivot->received_by)->full_name:'null')}}
                                </td>
                                <td class="font" style="font-size: 11px"> 
                                    {{($pharmacology->pivot->received_at ? $pharmacology->pivot->received_at : 'Null')}}

                                </td> 
                                <td>
                                <div class="table-actions">
                                                                        
                                <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$pharmacology->id}}" title="View" href=""><i class="ik ik-eye"></i></a>
                                <a title="Edit" href=""><i class="ik ik-edit"></i></a>

                                </div>
                            <div class="modal fade" id="demoModal{{$pharmacology->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">

                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="demoModalLabel">  pharmacology Product Details </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body"> 
                                                    
                                                    <h6> Product Name </h6>
                                                    <small class="text-muted ">{{$pharmacology->code}}</small>
                                                    <h6>Product Type </h6>
                                                    <small class="text-muted ">{{ucfirst($pharmacology->productType->name)}}</small>
                                                    <h6>Quantity</h6>
                                                    <small class="text-muted "> {{$pharmacology->pivot->quantity}}</small>
                                                    <h6>Indication</h6>
                                                    <p class="text-muted"> {{ ucfirst($pharmacology->indication)}}<br></p>

                                                    <hr><h5>Distribution Details</h5>
                                                    @foreach ($pharmacology->productDept->groupBy('id')->first() as $distribution)
                                                    <h6>Received By </h6>
                                                    <small class="text-muted ">{{ucfirst($distribution->received_by_admin)}}</small>
                                                    <h6>Distributed By </h6>
                                                    <small class="text-muted">{{ucfirst($distribution->distributed_by_admin)}}</small>
                                                    <h6>Delivered By </h6>
                                                    <small class="text-muted"> {{ucfirst($distribution->delivered_by_admin)}}</small>
                                                    
                                                    @endforeach

                                                    {{-- <hr><h5>Customer Details</h5>
                                                    
                                                    <h6>Name</h6>
                                                    <small class="text-muted ">{{ucfirst($pharmacology->customer->name)}}</small>
                                                    <h6>Tell</h6>
                                                    <small class="text-muted ">{{ucfirst($pharmacology->customer->tell)}}</small> --}}
                                                    
                                                    <hr><h5>Distribution Periods</h5>
                                                    <div  style="margin-bottom: 5px">
                                                    <h6 >product distribution period</h6>
                                                    <small class="text-muted">
                                                    Date: {{$pharmacology->pivot->received_at}}
                                                    </small>
                                                    </div>
                                                    <h6> product delivery period</h6>
                                                    <small class="text-muted ">
                                                    Date: {{$pharmacology->pivot->updated_at->format('Y-m-d')}}
                                                    Time: {{$pharmacology->pivot->updated_at->format('H:i:s')}}
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
                        @endif

                        @if ($product_type_id>0)
                        @foreach($dept2->where('product_type_id',$product_type_id) as $pharmacology)
                        <tr>
                            <td>
                                <div class="form-check mx-sm-2">
                                    <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input pharmselect"  value="{{$pharmacology->id}}" >
                                        <span class="custom-control-label">&nbsp; </span>
                                    </label>
                                </div>
                            </td>
                            <td class="font">B{{$pharmacology->pivot->updated_at->format('dym')}}</td>
                            <td class="font">

                                <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                    {{$pharmacology->code}}
                                </span>   

                                @if ($pharmacology->isReviewedByDept(2))
                                <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;">R</span></sup>
                                @endif
                            </td>
                           <td class="font">{{ucfirst($pharmacology->productType->name)}}</td>
                            <td class="font">{{$pharmacology->pivot->quantity}}</td>
                            <td>{!! $pharmacology->product_status !!}</td>
                            <td style="display: none">{{$pharmacology->pivot->status}}</td>
                            <td class="font">
                                {{ucfirst(\App\Admin::find($pharmacology->pivot->delivered_by)? \App\Admin::find($pharmacology->pivot->delivered_by)->full_name:'null')}}
                            </td>
                            <td class="font">
                                {{ucfirst(\App\Admin::find($pharmacology->pivot->received_by)? \App\Admin::find($pharmacology->pivot->received_by)->full_name:'null')}}
                            </td>
                            <td class="font" style="font-size: 11px"> 
                                {{($pharmacology->pivot->received_at ? $pharmacology->pivot->received_at : 'Null')}}

                            </td> 
                            <td>
                            <div class="table-actions">
                                                                    
                            <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$pharmacology->id}}" title="View" href=""><i class="ik ik-eye"></i></a>
                            <a title="Edit" href=""><i class="ik ik-edit"></i></a>

                            </div>
                        <div class="modal fade" id="demoModal{{$pharmacology->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel">  pharmacology Product Details </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body"> 
                                                
                                                <h6> Product Name </h6>
                                                <small class="text-muted ">{{$pharmacology->code}}</small>
                                                <h6>Product Type </h6>
                                                <small class="text-muted ">{{ucfirst($pharmacology->productType->name)}}</small>
                                                <h6>Quantity</h6>
                                                <small class="text-muted "> {{$pharmacology->pivot->quantity}}</small>
                                                <h6>Indication</h6>
                                                <p class="text-muted"> {{ ucfirst($pharmacology->indication)}}<br></p>

                                                <hr><h5>Distribution Details</h5>
                                                @foreach ($pharmacology->productDept->groupBy('id')->first() as $distribution)
                                                <h6>Received By </h6>
                                                <small class="text-muted ">{{ucfirst($distribution->received_by_admin)}}</small>
                                                <h6>Distributed By </h6>
                                                <small class="text-muted">{{ucfirst($distribution->distributed_by_admin)}}</small>
                                                <h6>Delivered By </h6>
                                                <small class="text-muted"> {{ucfirst($distribution->delivered_by_admin)}}</small>
                                                
                                                @endforeach

                                                {{-- <hr><h5>Customer Details</h5>
                                                
                                                <h6>Name</h6>
                                                <small class="text-muted ">{{ucfirst($pharmacology->customer->name)}}</small>
                                                <h6>Tell</h6>
                                                <small class="text-muted ">{{ucfirst($pharmacology->customer->tell)}}</small> --}}
                                                
                                                <hr><h5>Distribution Periods</h5>
                                                <div  style="margin-bottom: 5px">
                                                <h6 >product distribution period</h6>
                                                <small class="text-muted">
                                                Date: {{$pharmacology->pivot->received_at}}
                                                </small>
                                                </div>
                                                <h6> product delivery period</h6>
                                                <small class="text-muted ">
                                                Date: {{$pharmacology->pivot->updated_at->format('Y-m-d')}}
                                                Time: {{$pharmacology->pivot->updated_at->format('H:i:s')}}
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
                        @endif
                    </tbody>
                </table>
                {{-- {{$pharmproduct}} --}}
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select required name="status" class="form-control" id="exampleSelectGender">
                                <option value=""> Select Status</option>                                        
                                    <option  value="1" >Reject</option>
                                    <option  value="2" >Accept</option>
                                    </select>
                                </div>
                            </div>
                            @error('status')
                            <small style="" class="form-text text-danger" role="alert">
                                <strong>{{$message}}</strong>
                            </small>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">   
                            <button type="submit" class="btn btn-primary mb-2">Submit Selected Product</button>
                        </div>
                        <div class="col-md-4">
                        <div id="error-div" style="margin: 5px; color:red;"></div>
                            <input name="adminid" id="adminid"  type="hidden" value="">

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
                                @error('pin')
                                <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                    <strong>{{$pin}}</strong>
                                </small>
                                @enderror
                                <span class="input-group-prepend"><label class="input-group-text"><i class="ik ik-shield"></i></label></span>
                                <input required id="userpin" type="password" class="form-control" name="pin" placeholder="Sign with pin">
                            </div>
                        </div>
                    </div>
              </form>
             </div>
         </div>
    
    </div>
</div>
@endsection