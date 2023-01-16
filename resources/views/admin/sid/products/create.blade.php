@extends('admin.layout.main')

@section('content')

<div class="">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-edit bg-blue"></i>
                            <div class="d-inline">
                                <h5>Product Registration</h5>
                                <span>Please input required data in the field requested</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="#"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Products</li>
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
                                    <div class="card-header">
                                        <h3>Input Data</h3>
                                    </div>
                                    <div class="card-body">
                    	     <form id="checksinglemultlab" action="{{url('admin/sid/create_product')}}" class="form-inline" method="POST">
                                {{ csrf_field() }}
                            <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                        
                                            <div class="col-sm-4">
                                                <label class="sr-only" for="inlineFormInputGroupUsername2"></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Name</div>
                                                    </div>
                                                <input type="text" required class="form-control" id="inlineFormInputGroupUsername2" name="name" placeholder="Product Name" value="{{old('name')? old('name'): ''}}">
                                                
                                                </div>
                                                <div>
                                                    @error('name')
                                                <small style="margin:15px" class="form-text text-danger" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </small>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-4" >
                                                <label class="sr-only" for="inlineFormInputGroupUsername2">Select Product Type</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Product Type</div>
                                                    </div>
                                                    <select required name="product_type_id" style="" class="form-control select2">
                                                        <option value="">Select Product Type</option>
                                                        @foreach($product_types as $product_type)
                                                                    
                                                        <option  value="{{$product_type->id}}" {{$product_type->id == old('product_type_id')? "selected":""}}>{{$product_type->name}}</option>
                    
                                                        @endforeach
                                                    </select>
                                                </div>
                                                    <div>
                                                    @error('product_type_id')
                                                    <small style="margin:15px" class="form-text text-danger" role="alert">
                                                        <strong>{{$message}}</strong>
                                                    </small>
                                                    @enderror
                                                    </div>
                                                
                                            </div>
                                             <div class="col-sm-4">
                                                <label class="sr-only" for="inlineFormInputGroupUsername2">Select Client/Customer</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Client</div>
                                                    </div>
                                                    <select required name="customer_id" style="" class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                        <option value="">Select Client/Customer</option>
                                                        @foreach($customers as $customer)
                                                                        
                                                        <option  value="{{$customer->id}}" {{$customer->id == old('customer_id')? "selected":""}}>{{$customer->name}} | {{$customer->company_name}}</option>
                    
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    @error('customer_id')
                                                    <small style="margin:15px" class="form-text text-danger" role="alert">
                                                        <strong>{{$message}}</strong>
                                                    </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="sr-only" for="inlineFormInputGroupUsername2"></label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Dosage</div>
                                                    </div>
                                                <input required type="text" class="form-control" id="inlineFormInputGroupUsername2" name="dosage" placeholder="Dosage" value="{{old('dosage')? old('dosage'):'' }}">
                                                </div>
                                                <div>
                                                 @error('dosage')
                                                <small style="margin:15px" class="form-text text-danger" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </small>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="sr-only" for="inlineFormInputGroupUsername2">quantity</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Qty</div>
                                                    </div>
                                                    <input required type="string" class="form-control" id="inlineFormInputGroupUsername2" name="quantity" placeholder="Quantity" value="{{old('quantity')? old('quantity'): ''}}">
                                                </div>
                                                <div>      
                                                    @error('quantity')
                                                    <small style="margin:15px" class="form-text text-danger" role="alert">
                                                        <strong>{{$message}}</strong>
                                                    </small>
                                                    @enderror
                                                </div>
                                            </div> 
                                            
                                            <div class="col-sm-3">
                                                <label class="sr-only" for="inlineFormInputGroupUsername2">Date Manufactured</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Mfg</div>
                                                    </div>
                                                  <input  class="form-control" type="date" placeholder="Date Manufactured" name="mfg_date" value="{{old('mfg_date')? old('mfg_date'): ''}}">
                                                </div>  
                                                <div>
                                                  @error('mfg_date')
                                                  <small style="margin:15px" class="form-text text-danger" role="alert">
                                                      <strong>{{$message}}</strong>
                                                  </small>
                                                  @enderror
                                                </div>
                                            </div>   
                                            <div class="col-sm-3">
                                                <label class="sr-only" for="inlineFormInputGroupUsername2">Expiry Date</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Exp</div>
                                                    </div>
                                                     <input class="form-control" type="date"  placeholder="Date Expired"  name="exp_date" value="{{old('exp_date')? old('exp_date'): ''}}">
                                                     
                                                    </div>
                                                <div>
                                                     @error('exp_date')
                                                     <small style="margin:15px" class="form-text text-danger" role="alert">
                                                         <strong>{{$message}}</strong>
                                                     </small>
                                                     @enderror
                    
                                                </div>       
                                            </div>  
                                            <div class="col-sm-4">
                                                <div class="input-group mb-2 mr-sm-2">
                                         
                                                    <textarea required type="text" class="form-control" id="exampleTextarea1" name="indication" placeholder="Indication" value="{{old('indication')? old('indication'): ''}}" rows="4"></textarea>
                                                </div>
                                                <div>
                                                    @error('indication')
                                                    <small style="margin:15px" class="form-text text-danger" role="alert">
                                                        <strong>{{$message}}</strong>
                                                    </small>
                                                    @enderror
                                                </div>
                                             </div> 
                                             <div class="col-sm-3">
                                                <label class="sr-only" for="inlineFormInputGroupUsername2">Amount Paid</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Amt</div>
                                                    </div>
                                                    <input required type="number" class="form-control" id="amount" name="price" placeholder="Amount" value="{{old('price')? old('price'): ''}}">
                                                </div>
                                                <div>
                                                    @error('price')
                                                    <small style="margin:15px" class="form-text text-danger" role="alert">
                                                        <strong>{{$message}}</strong>
                                                    </small>
                                                    @enderror
                                                </div>
                                                <label class="sr-only" for="inlineFormInputGroupUsername2">Receipt Num</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Receipt No.</div>
                                                    </div>
                                                    <input required type="text" class="form-control" id="" name="receipt_num" placeholder="Receipt No." value="{{old('receipt_num')? old('receipt_num'): ''}}">
                                                </div>
                                                <div>
                                                    @error('receipt_num')
                                                    <small style="margin:15px" class="form-text text-danger" role="alert">
                                                        <strong>{{$message}}</strong>
                                                    </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                               <div class="row">
                                                <div class="col-md-5">
                                                    <label class="custom-control custom-checkbox singlelabcheck">
                                                        <input type="checkbox" name="single_multiple_lab" id="check_singlelab" value="1" class="custom-control-input">
                                                        <span class="custom-control-label">&nbsp; Single Lab</span>
                                                    </label>
                                                    <label class="custom-control custom-checkbox multilabcheck">
                                                        <input type="checkbox" name="single_multiple_lab" id="check_multilab" value="2" class="custom-control-input">
                                                        <span class="custom-control-label">&nbsp; Multiple Lab</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-7 singlelab" style="display: none">
                                                    <p>Please check approved lab. Actual Price <span class="badge badge-info">  {{$price_list->singlelab_price}}</span></p>
        
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="micro_hod_evaluation" value="1" class="custom-control-input">
                                                        <span class="custom-control-label" style="margin-right:5%">Microbiology</span>
                                                    </label>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="pharm_hod_evaluation" value="1" class="custom-control-input">
                                                        <span class="custom-control-label"style=""> Pharmacology</span>
                                                    </label>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="phyto_hod_evaluation" value="1" class="custom-control-input">
                                                        <span class="custom-control-label"style="">Phytochemistry</span>
                                                    </label>
                                                    <input type="hidden" id="singlelab_actual_price" name="singlelab_actual_price" value=" {{$price_list->singlelab_price}}">
                                                   
                                                </div>
                                                <div class="col-md-7 multilab" style="display: none">
                                                    <p>Please check approved labs. Actual Price <span class="badge badge-info">  {{$price_list->mutilabs_price}}</span></p>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="micro_hod_evaluation" value="1" class="custom-control-input">
                                                        <span class="custom-control-label" style="margin-right:5%">Microbiology</span>
                                                    </label>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="pharm_hod_evaluation" value="1" class="custom-control-input">
                                                        <span class="custom-control-label"style=""> Pharmacology</span>
                                                    </label>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="phyto_hod_evaluation" value="1" class="custom-control-input">
                                                        <span class="custom-control-label"style="">Phytochemistry</span>
                                                    </label>
                                                    <input type="hidden" id="multilab_actual_price" name="multilab_actual_price" value="{{$price_list->mutilabs_price}}">

                                                </div>
                                               </div>                                              

                                            </div>
                                        </div>

                                        <button style="float: centre" type="submit" class="btn btn-primary mb-2">Create Product</button>
                                    </form>
                                    
                                     
                                    </div>
                                </div>
                            </div>
                           </div>
                       
                       
                    </div>
                                      
                    </div>
                               
                </div>
            </div>

             <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    
                        <div class="card-body">
                           
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-md-12">
                                    <h3 class="card-title">All products Received</h3>
                                    {{-- <span style="margin: px">Year</span>  --}}

                                    {{ Form::open(array('action'=>"AdminAuth\SID\SIDController@yearlyproduct_registered", 'method'=>'post','class'=>'form-horizontal')) }}
                                    {{Form::token()}}
                                    <div class="input-group" style=" margin-top: 10px;">
                                        {{ Form::selectRange('year',date('Y') -2, date('Y'), isset($year) ?? $year, array('class'=>'form-','placeholder'=>'Select year')) }}
                                        <button type="submit" class="btn btn-primay mr-2">Search</button>    
                                    </span>
                                    </div>
                                    {{ Form::close() }} 
                                  </div>
                                  <div class="col-lg-7">
                                 
                                    
                                    <form action="{{route('admin.sid.registeredproduct.report')}}" method="POST">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span style="margin: 5px">From</span>  <input type="date" name="from_date"  required class="form-control" value="{{ $from_date}}">
                                                <div>
                                                    @error('from_date')
                                                <small style="margin:15px" class="form-text text-danger" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </small>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4"> 
                                                <span style="margin: 5px">To</span>  <input type="date" name="to_date" required class="form-control" value="{{ $to_date }}">
                                                @error('to_date')
                                                <small style="margin:15px" class="form-text text-danger" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </small>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                              
                                                <button style="margin-top: 20px" type="submit" class="btn btn-primary mr-2">search</button>  
                                            </div>
                                        </div>
                                        
                                    </form>
                                   
                                </div>
                                <div class="col col-sm-2">
                                    @if ($to_date !== Null)

                                    <div class="card-options d-inline-block">
                                       
                                            <form action="{{route('admin.sid.deliverysheet.pdf')}}" method="POST">
                                                {{ csrf_field() }}
                                            @foreach($products->sortBy('id') as $product)
                                            <input type="hidden" name="product_id[]" value="{{$product->id}}">
                                            @endforeach
                                      <button class="btn btn-info" type="submit" title="Download delivery sheet"><i class="ik ik-download"></i></button>
                                      </form> 
                                   
                                    </div>
                                                                            
                                    @endif
                                </div>
                                <div class="col-md-12" style="overflow-x: scroll" >
                                  

									 <table id="order-table_product" class="table table-striped table-bordered nowrap dataTable" >
									    <thead>
									        <tr>
                                                <th></th>
									            <th>Code</th>
									            <th  style="width:50px">Product Name</th>
									            <th>Product Type</th>
									            <th>Customer</th>
                                                <th>Amt Paid</th>
                                                {{-- <th>Created By</th> --}}
                                                <th>Date</th>
                                                <th>Actions</th>
									            
									       </tr>
									    </thead>
									    <tbody >                                                
                                            @foreach($products->sortBy('id') as $product)
                                            <tr>
                                            <td><p  style="display: none">{{$product->id}}</p></td>
                                            <td class="font">
                                            @if ($product->archive == Null)
                             
                                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                             {{$product->code}} 
                                            </span>  
                                            @else
                                            <span  class="badge  pull-right" style="background-color:#28a745; color:#fff; margin:5px">
                                                <span style="font-size: 0.1px">#completed</span> {{$product->code}}
                                            </span>  
                                            @endif
                                         
                                            
                                              
                                           </td>
                                            <td class="font" style="width:15%">
                                                {{ucfirst($product->name)}}
                                                @if ($product->failed_tag)
                                                <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;">#R</span></sup>
                                                @endif
                                                @if($product->single_multiple_lab ==1)
                                                <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#S</span></sup>
                                                @endif
                                                @if($product->single_multiple_lab ==2)
                                                <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#M</span></sup>
                                                @endif
                                                @if ($product->overall_status == 2 && $product->archive == 0)
                                                <span style="font-size: 0.1px">ready</span>
    
                                                <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;"><i class="ik ik-check-circle"></i></span></sup> 
                                                @endif
                                            </td>
                                            <td class="font" >{{$product->productType->name}}</td>
                                            <td class="font">{{$product->customer_name}}<br>
                                             <span style="font-size:10px">{{$product->customer->company_name}}</span>
                                            </td>
                                            <td class="font">{{$product->price}}</td>
                                            {{-- <td class="font">{{ucfirst($product->created_by)}}</td> --}}
                                            <td class="font">{{$product->created_at->format('Y / m / d')}}</td>
                                            <td>
                                                <div class="table-actions">
                                                {!! $product->show_tag !!}

                                                @if ($product->overall_status <1)
                                                {!! $product->edit_tag !!}
                                                @endif
                                               
                                                <a href="{{route('admin.sid.product.account.index',['id' => $product->id, 'price' => $product->price])}}"> 
                                                <button type="button" class="btn btn-icon btn-info"><i class="ik ik-dollar-sign"></i></button>    
                                                </a>
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

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-8 col-md-12">
                        <h3 class="card-title">Click to view product under each category</h3>
                      </div>
                    @foreach($product_types as $product_type)    
                    <a href="{{route("admin.sid.producttype.productlist", ['id' => $product_type->id])}}" class="badge badge-light mb-1 active">{{$product_type->name}}</a>
                    
                    @endforeach


                </div>
            </div> 


@endsection
