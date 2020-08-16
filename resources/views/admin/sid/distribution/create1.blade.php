@extends('admin.layout.main')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                {{-- <i class="ik ik-edit bg-blue"></i> --}}
                <div class="d-inline">
                    <h5>Product Distribution</h5>
                    <span>Please input required data in the field requested</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="../index.html"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Forms</a></li>
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
        <div class="card">
          
            <div class="card-body">
     <form action="{{url('admin/sid/distribute_product')}}" class="form-inline" method="POST">
        {{ csrf_field() }}

        <label class="sr-only" for="inlineFormInputGroupUsername2">Select Product Type</label>
       <div class="col-md-12">
            <div class="input-group">
                <label class="" style="padding:10px; margin-left:15px;" >Select Product</label>
                <div class="input-group-prepend">
                    <div class="input-group-text"></div>
                </div>
                
                <select name="product_id" style="" class="form-control select2">
                    @foreach($products as $product)
                                  
                    <option  value="{{$product->id}}" {{$product->id == old('product_id')? "selected":""}}>{{ucfirst($product->name)}}</option>
    
                    @endforeach
                </select>
                
            </div>
                @error('product_id')
                <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                    <strong>{{$message}}</strong>
                </small>
                @enderror
       </div>
           
        <div class="form-check mx-sm-2">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="microbiology" id="department_1" value ="1" {{(old('microbiology') == "1")? 'checked':''}}>
            <span  class="custom-control-label">&nbsp; Microbiology</span>
        </label>
    </div>
    <div class="col-sm-2 col-lg-2">
        <div class="input-group">
           
            <span class="input-group-prepend">
                <label class="input-group-text">qty</label>
            </span>
            <input type="text" class="form-control" id="inlineFormInputGroupUsername2" name="microquantity" placeholder="Micro-qty" value="{{old('microquantity')? old('microquantity'): ''}}">
            @error('microquantity')
            <small style="" class="form-text text-danger" role="alert">
                <strong>{{$message}}</strong>
            </small>
            @enderror
        </div>
    </div>
    <div class="form-check mx-sm-2">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="pharmacology" id="department_2" value = "2" {{(old('pharmacology') == "2")? 'checked':''}}>
            <span class="custom-control-label">&nbsp; Pharmacology</span>
        </label>
    </div>
    <div class="col-sm-2 col-lg-2">
        <div class="input-group">
           
            <span class="input-group-prepend">
                <label class="input-group-text">qty</label>
            </span>
            <input type="text" class="form-control" id="inlineFormInputGroupUsername2" name="pharmquantity" placeholder="Pharm-qty" value="{{old('pharmquantity')? old('pharmquantity'): ''}}">
            @error('pharmquantity')
            <small style="" class="form-text text-danger" role="alert">
                <strong>{{$message}}</strong>
            </small>
            @enderror
        </div>
    </div>
    
    <div class="form-check mx-sm-2">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="phytochemistry" id="department_3" value = "3"  {{(old('phytochemistry') == "3")? 'checked':''}}>
            <span class="custom-control-label">&nbsp; Phytochemistry</span>
        </label>
    </div>
    <div class="col-sm-2 col-lg-2">
        <div class="input-group">
           
            <span class="input-group-prepend">
                <label class="input-group-text">qty</label>
            </span>
            <input type="text" class="form-control" id="inlineFormInputGroupUsername2" name="phytoquantity" placeholder="Phyto-qty" value="{{old('phytoquantity')? old('phytoquantity'): ''}}">
            @error('phytoquantity')
            <small style="" class="form-text text-danger" role="alert">
                <strong>{{$message}}</strong>
            </small>
            @enderror
                </div>
         </div>
  
    <button type="submit" class="btn btn-primary mb-2">Submit</button>
    </form>
            </div>
              
        </div>
       
    </div>

 </div>

 <div class="card">
    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
    
      
        <li class="nav-item">
        <a class="nav-link active show" id="pills-timeline-tab" data-toggle="pill" href="#tab" role="tab" aria-controls="pills-timeline" aria-selected="false">Microbiology</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Pharmacology</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="true">Phytochemistry</a>
        </li>
    </ul>


    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade active show" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
            <div class="card-body">
               {{-- Microbiology --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                               <a data-toggle="modal" data-target="#demoModal">
                                   <div class="page-header">
                                        <div class="col-md-6">
                                            <div class="page-header-title">
                                                    <i class="ik ik-edit bg-blue"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h5>Microbiology</h5>
                                            <span>Click here to ditribute product only to this department</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                                <div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{url('admin/sid/micro_distribute_product')}}" class="form-inline" method="POST">
                                            {{ csrf_field() }}
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="demoModalLabel">Distribute product to Microbiology</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                <div class="col-md-12" style="margin:5px">
                                                        <div class="form-group">
                                                            <label for="exampleSelectGender">Select Product</label><br>
                                                            <select name="microproduct_id" style="width:100%;" class="form-control select2">
                                                                @foreach($microproducts as $microproduct)

                                                                    <option  value="{{$microproduct->id}}" {{$microproduct->id == old('microproduct')? "selected":""}}>{{ucfirst($microproduct->name)}}</option>

                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail3">Quantity</label><br>
                                                            <input type="number" required class="form-control" id="inlineFormInputGroupUsername2" name="microquantity" placeholder="Micro-qty" value="{{old('quantity')? old('quantity'): ''}}">
                                                            @error('microquantity')
                                                            <small style="" class="form-text text-danger" role="alert">
                                                                <strong>{{$message}}</strong>
                                                            </small>
                                                            @enderror                                            
                                                        </div>
                                                    </div>
                                            
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                        </div>
                        <table id="order-table" class="table table-striped table-bordered nowrap dataTable">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Product Name</th>
                                    <th>Product Type</th>
                                    <th>Quantity</th>
                                    <th>status</th>
                                    <th>Distributed by</th>
                                    <th>Received by</th>
                                    <th>Actions</th>                        
                               </tr>
                            </thead>
                            <tbody>                                            
                                @foreach($dept1 as $microproduct)
                                <tr>
                                        <td class="font">{{$microproduct->productType->code}}|{{$microproduct->id}}|{{$microproduct->created_at->format('y')}}</td>
                                        <td class="font">{{ucfirst($microproduct->name)}}</td>
                                        <td class="font">{{ucfirst($microproduct->productType->name)}}</td>
                                        <td class="font">{{$microproduct->pivot->quantity}}</td>
                                        {!! $microproduct->product_status !!}
                                        @foreach ($microproduct->productDept->groupBy('id')->first() as $distribution)
                                        <td class="font">{{$distribution->distributed_by_admin}}</td>
                                        <td class="font">{{$distribution->received_by_admin}}</td>
                                                                                
                                        @endforeach
                                            
                                        <td>
                                        <div class="table-actions">
                                                                                
                                        <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$microproduct->id}}" title="View" href=""><i class="ik ik-eye"></i></a>
                                        <a title="Edit" href=""><i class="ik ik-edit"></i></a>

                                        <a onclick="return confirm('Note! This action will delete selected category ?')" href="{{route('admin.sid.micro_distributed_product.delete', ['id' => $microproduct->id])}}"><i class="ik ik-trash-2"></i></a>
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
                                                            <small class="text-muted ">{{$microproduct->productType->Code}}|{{$microproduct->id}}|{{$microproduct->created_at->format('y')}} |   {{ucfirst($microproduct->name)}}</small>
                                                            <h6>Product Type </h6>
                                                            <small class="text-muted ">{{ucfirst($microproduct->productType->name)}}</small>
                                                            <h6>Quantity</h6>
                                                            <small class="text-muted "> {{$microproduct->pivot->quantity}}</small>
                                                            <h6>Indication</h6>
                                                            <p class="text-muted"> {{ ucfirst($microproduct->indication)}}<br></p>

                                                            <hr><h5>Distribution Details</h5>
                                                            @foreach ($microproduct->productDept->groupBy('id')->first() as $distribution)
                                                            <h6>Received By </h6>
                                                            <small class="text-muted ">{{ucfirst($distribution->received_by_admin)}}</small>
                                                            <h6>Distributed By </h6>
                                                            <small class="text-muted">{{ucfirst($distribution->distributed_by_admin)}}</small>
                                                            <h6>Delivered By </h6>
                                                            <small class="text-muted"> {{ucfirst($distribution->delivered_by_admin)}}</small>
                                                            
                                                            @endforeach

                                                            <hr><h5>Customer Details</h5>
                                                            
                                                            <h6>Name</h6>
                                                            <small class="text-muted ">{{ucfirst($microproduct->customer->name)}}</small>
                                                            <h6>Tell</h6>
                                                            <small class="text-muted ">{{ucfirst($microproduct->customer->tell)}}</small>
                                                            
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

 {{-- Pharmachology --}}
        <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                        <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                        <a data-toggle="modal" data-target="#exampleModalCenter">
                                            <div class="page-header">
                                                    <div class="col-md-6">
                                                        <div class="page-header-title">
                                                                <i class="ik ik-edit bg-blue"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h5>Pharmacology</h5>
                                                        <span>Click here to ditribute product only to this department</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form action="{{url('admin/sid/pharm_distribute_product')}}" class="form-inline" method="POST">
                                                    {{ csrf_field() }}
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterLabel">Distribute product to Pharmacology</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                        <div class="col-md-12" style="margin:5px">
                                                                <div class="form-group">
                                                                    <label for="exampleSelectGender">Select Product</label><br>
                                                                    <select name="pharmproduct_id" style="width:100%;" class="form-control select2">
                                                                        @foreach($pharmproducts as $pharmproduct)

                                                                            <option  value="{{$pharmproduct->id}}" {{$pharmproduct->id == old('microproduct')? "selected":""}}>{{ucfirst($pharmproduct->name)}}</option>

                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail3">Quantity</label><br>
                                                                    <input type="number" required class="form-control" id="inlineFormInputGroupUsername2" name="pharmquantity" placeholder="pharm-qty" value="{{old('quantity')? old('quantity'): ''}}">
                                                                    @error('pharmquantity')
                                                                    <small style="" class="form-text text-danger" role="alert">
                                                                        <strong>{{$message}}</strong>
                                                                    </small>
                                                                    @enderror                                            
                                                                </div>
                                                            </div>
                                                    
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                            <div class="col-md-12">
                                                <table id="simpletable" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Code</th>
                                                            <th>Product Name</th>
                                                            <th>Product Type</th>
                                                            <th>Quantity</th>
                                                            <th>status</th>
                                                            <th>Distributed by</th>
                                                            <th>Received by</th>
                                                            <th>Actions</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                
                                                        @foreach($dept2 as $pharmproduct)
                                                        <tr>
                                                                <td class="font">{{$pharmproduct->productType->code}}|{{$pharmproduct->id}}|{{$pharmproduct->created_at->format('y')}}</td>
                                                                <td class="font">{{ucfirst($pharmproduct->name)}}</td>
                                                                <td class="font">{{ucfirst($pharmproduct->productType->name)}}</td>
                                                                <td class="font">{{$pharmproduct->pivot->quantity}}</td>
                                                                {!! $pharmproduct->product_status !!}
                                                                @foreach ($pharmproduct->productDept->groupBy('id')->first() as $distribution)
                                                                <td class="font">{{$distribution->distributed_by_admin}}</td>
                                                                <td class="font">{{$distribution->received_by_admin}}</td>
                                                                                                                    
                                                                @endforeach
                                                                    
                                                                <td>
                                                                <div class="table-actions">
                                                                                                        
                                                                <a data-toggle="modal" data-placement="auto" data-target="#exampleModalLong{{$pharmproduct->id}}" title="View" href=""><i class="ik ik-eye"></i></a>
                                                                <a title="Edit" href=""><i class="ik ik-edit"></i></a>
                                                                
                                                                <a onclick="return confirm('Note! This action will delete selected category ?')" href="{{route('admin.sid.pharm_distributed_product.delete', ['id' => $pharmproduct->id])}}"><i class="ik ik-trash-2"></i></a>

                                                                </div>

                                                                <div class="modal fade" id="exampleModalLong{{$pharmproduct->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongLabel" style="display: none;" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLongLabel">Pharmacology Product Details</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <div class="card-body"> 

                                                                                    <h6> Product Name </h6>
                                                                                    <small class="text-muted ">{{$pharmproduct->productType->Code}}|{{$pharmproduct->id}}|{{$pharmproduct->created_at->format('y')}} |   {{ucfirst($pharmproduct->name)}}</small>
                                                                                    <h6>Product Type </h6>
                                                                                    <small class="text-muted ">{{ucfirst($pharmproduct->productType->name)}}</small>
                                                                                    <h6>Quantity</h6>
                                                                                    <small class="text-muted "> {{$pharmproduct->pivot->quantity}}</small>
                                                                                    <h6>Indication</h6>
                                                                                    <p class="text-muted"> {{ ucfirst($pharmproduct->indication)}}<br></p>
                        
                                                                                    <hr><h5>Distribution Details</h5>
                                                                                    @foreach ($pharmproduct->productDept->groupBy('id')->first() as $distribution)
                                                                                    <h6>Received By </h6>
                                                                                    <small class="text-muted ">{{ucfirst($distribution->received_by_admin)}}</small>
                                                                                    <h6>Distributed By </h6>
                                                                                    <small class="text-muted">{{ucfirst($distribution->distributed_by_admin)}}</small>
                                                                                    <h6>Delivered By </h6>
                                                                                    <small class="text-muted"> {{ucfirst($distribution->delivered_by_admin)}}</small>
                                                                                    
                                                                                    @endforeach
                        
                                                                                    <hr><h5>Customer Details</h5>
                                                                                    
                                                                                    <h6>Name</h6>
                                                                                    <small class="text-muted ">{{ucfirst($pharmproduct->customer->name)}}</small>
                                                                                    <h6>Tell</h6>
                                                                                    <small class="text-muted ">{{ucfirst($pharmproduct->customer->tell)}}</small>
                                                                                    
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
        </div>

        {{-- phytochemistry --}}
            <div class="tab-pane fade " id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-12">
                                            <a data-toggle="modal" data-target="#exampleModalLong">
                                                <div class="page-header">
                                                        <div class="col-md-6">
                                                            <div class="page-header-title">
                                                                    <i class="ik ik-edit bg-blue"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h5>Phytochemistry</h5>
                                                            <span>Click here to ditribute product only to this department</span>
                                                        </div>
                                                    </div>
                                            </a>
                                            </div>
                                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongLabel" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                <form action="{{url('admin/sid/phyto_distribute_product')}}" class="form-inline" method="POST">
                                                        {{ csrf_field() }}
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongLabel">Distribute product to Phytochemistry</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                            <div class="col-md-12" style="margin:5px">
                                                                    <div class="form-group">
                                                                        <label for="exampleSelectGender">Select Product</label><br>
                                                                        <select name="phytoproduct_id" style="width:100%;" class="form-control select2">
                                                                            @foreach($phytoproducts as $phytomproduct)
            
                                                                                <option  value="{{$phytomproduct->id}}" {{$phytomproduct->id == old('microproduct')? "selected":""}}>{{ucfirst($phytomproduct->name)}}</option>
            
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail3">Quantity</label><br>
                                                                        <input type="number" required class="form-control" id="inlineFormInputGroupUsername2" name="phytoquantity" placeholder="phyto-qty" value="{{old('quantity')? old('quantity'): ''}}">
                                                                        @error('phytoquantity')
                                                                        <small style="" class="form-text text-danger" role="alert">
                                                                            <strong>{{$message}}</strong>
                                                                        </small>
                                                                        @enderror                                            
                                                                    </div>
                                                                </div>
                                                        
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="col-md-12">
                                                <table id="multi-colum-dt" class="table table-striped table-bordered nowrap dataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Code</th>
                                                            <th>Product Name</th>
                                                            <th>Product Type</th>
                                                            <th>Quantity</th>
                                                            <th>status</th>
                                                            <th>Distributed by</th>
                                                            <th>Received by</th>
                                                            <th>Actions</th>  
                                                        </tr>
                                                    </thead>
                                                    <tbody> 
                                                        @foreach($dept3 as $phytoproduct)
                                                        <tr>
                                                                <td class="font">{{$phytoproduct->productType->code}}|{{$phytoproduct->id}}|{{$phytoproduct->created_at->format('y')}}</td>
                                                                <td class="font">{{ucfirst($phytoproduct->name)}}</td>
                                                                <td class="font">{{ucfirst($phytoproduct->productType->name)}}</td>
                                                                <td class="font">{{$phytoproduct->pivot->quantity}}</td>
                                                                {!! $phytoproduct->product_status !!}
                                                                @foreach ($phytoproduct->productDept->groupBy('id')->first() as $distribution)
                                                                <td class="font">{{$distribution->distributed_by_admin}}</td>
                                                                <td class="font">{{$distribution->received_by_admin}}</td>
                                                                                                                    
                                                                @endforeach
                                                                    
                                                                <td>
                                                                <div class="table-actions">
                                                                                                        
                                                                <a data-toggle="modal" data-placement="auto" data-target="#exampleModalCenter{{$phytoproduct->id}}" title="View" href=""><i class="ik ik-eye"></i></a>
                                                                <a title="Edit" href=""><i class="ik ik-edit"></i></a>
                                                                
                                                                <a onclick="return confirm('Note! This action will delete selected category ?')" href="{{route('admin.sid.phyto_distributed_product.delete', ['id' => $phytoproduct->id])}}"><i class="ik ik-trash-2"></i></a>
                                                                </div>
                                                            <div class="modal fade" id="exampleModalCenter{{$phytoproduct->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalCenterLabel">Modal title</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                            <div class="card-body"> 

                                                                                    <h6> Product Name </h6>
                                                                                    <small class="text-muted ">{{$phytoproduct->productType->Code}}|{{$phytoproduct->id}}|{{$phytoproduct->created_at->format('y')}} |   {{ucfirst($phytoproduct->name)}}</small>
                                                                                    <h6>Product Type </h6>
                                                                                    <small class="text-muted ">{{ucfirst($phytoproduct->productType->name)}}</small>
                                                                                    <h6>Quantity</h6>
                                                                                    <small class="text-muted "> {{$phytoproduct->pivot->quantity}}</small>
                                                                                    <h6>Indication</h6>
                                                                                    <p class="text-muted"> {{ ucfirst($phytoproduct->indication)}}<br></p>
                        
                                                                                    <hr><h5>Distribution Details</h5>
                                                                                    @foreach ($phytoproduct->productDept->groupBy('id')->first() as $distribution)
                                                                                    <h6>Received By </h6>
                                                                                    <small class="text-muted ">{{ucfirst($distribution->received_by_admin)}}</small>
                                                                                    <h6>Distributed By </h6>
                                                                                    <small class="text-muted">{{ucfirst($distribution->distributed_by_admin)}}</small>
                                                                                    <h6>Delivered By </h6>
                                                                                    <small class="text-muted"> {{ucfirst($distribution->delivered_by_admin)}}</small>
                                                                                    
                                                                                    @endforeach
                        
                                                                                    <hr><h5>Customer Details</h5>
                                                                                    
                                                                                    <h6>Name</h6>
                                                                                    <small class="text-muted ">{{ucfirst($phytoproduct->customer->name)}}</small>
                                                                                    <h6>Tell</h6>
                                                                                    <small class="text-muted ">{{ucfirst($phytoproduct->customer->tell)}}</small>
                                                                                    
                                                                                    <hr><h5>Distribution Periods</h5>
                                                                                    <div  style="margin-bottom: 5px">
                                                                                    <h6 >product distribution period</h6>
                                                                                    <small class="text-muted">
                                                                                    Date: {{$phytoproduct->pivot->created_at->format('Y-m-d')}}
                                                                                    Time: {{$phytoproduct->pivot->created_at->format('H:i:s')}}
                                                                                    </small>
                                                                                    </div>
                                                                                    <h6> product delivery period</h6>
                                                                                    <small class="text-muted ">
                                                                                    Date: {{$phytoproduct->pivot->updated_at->format('Y-m-d')}}
                                                                                    Time: {{$phytoproduct->pivot->updated_at->format('H:i:s')}}
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
                </div>
            </div>
</div>
@endsection