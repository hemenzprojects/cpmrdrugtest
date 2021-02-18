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
                    	     <form action="{{url('admin/sid/create_product')}}" class="form-inline" method="POST">
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
                                            <div class="col-sm-4">
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
                                                    <input required type="number" class="form-control" id="" name="price" placeholder="Amount" value="{{old('price')? old('price'): ''}}">
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
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="check_singlelab" id="check_singlelab" class="custom-control-input">
                                                        <span class="custom-control-label">&nbsp; Single Labs</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-7 singlelab" style="display: none">
                                                    <p>Please check approved lab(s)</p>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="micro_hod_evaluation" value="1" class="custom-control-input">
                                                        <span class="custom-control-label">&nbsp;Microbiology</span>
                                                    </label>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="pharm_hod_evaluation" value="1" class="custom-control-input">
                                                        <span class="custom-control-label">&nbsp; Pharmacology</span>
                                                    </label>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="phyto_hod_evaluation" value="1" class="custom-control-input">
                                                        <span class="custom-control-label">&nbsp; Phytochemistry</span>
                                                    </label>
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
                                <div class="col-lg-8 col-md-12">
                                    <h3 class="card-title">All products Received</h3>
                                  </div>
                                <div class="col-md-12">
                                  

									 <table id="order-table_product" class="table table-striped table-bordered nowrap dataTable">
									    <thead>
									        <tr>
                                                <th></th>
									            <th>Code</th>
									            <th>Product Name</th>
									            <th>Product Type</th>
									            <th>Customer</th>
                                                <th>Amt Paid</th>
                                                <th>Created By</th>
                                                <th>Date</th>
                                                <th>Actions</th>
									            
									       </tr>
									    </thead>
									    <tbody>                                                
                                            @foreach($products->sortBy('id') as $product)
                                            <tr>
                                            <td><p  style="display: none">{{$product->id}}</p></td>
                                            <td class="font">
                                                <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                    {{$product->code}}
                                                </span>
                                           </td>
                                               <td class="font">{{ucfirst($product->name)}}
                                                @if ($product->failed_tag)
                                                <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;">R</span></sup>
                                                @endif
                                            </td>
                                            <td class="font">{{$product->productType->name}}</td>
                                            <td class="font">{{$product->customer_name}}</td>
                                            <td class="font">{{$product->price}}</td>
                                            <td class="font">{{ucfirst($product->created_by)}}</td>
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
                                            <div class="modal fade" id="exampleModalCenter{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterLabel">Transactional Details</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        </div>
                                                       
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
          
            


@endsection
