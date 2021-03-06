@extends('admin.layout.main')

@section('content')

<div class="">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-edit bg-blue"></i>
                            <div class="d-inline">
                                <h5>Product Review of {{$p->name}}  <span  class="badge  pull-right" style="background-color: #de1024; color:#fff ">
                                    {{$p->code}}
                                </span></h5>
                                <span>Please input required data in the field requested and submit for review</span>
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
                     <form action="{{url('admin/sid/product/review/create',['id' => $p])}}" class="form-inline" method="POST">
                        {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                     
                                <input type="hidden" name="failed_tag" value="{{rand(0,1000)}}{{\Carbon\Carbon::now()->format('His')}}{{$p->id}}">
                                <input type="hidden" name="id" value="{{$p->id}}">

                                    <div class="col-sm-4">
                                        <label class="sr-only" for="inlineFormInputGroupUsername2"></label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Name</div>
                                            </div>
                                        <input type="text" class="form-control" id="inlineFormInputGroupUsername2" name="name" placeholder="Product Name" value="{{old('name')? old('name'): $p->name}}">
                                        
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
                                        <div class="input-group mb-2 mr-sm-2">
                                        <input type="text" class="form-control" placeholder="{{$p->productType->name}}" value="{{$p->productType->name}}" onkeypress="return false;">
                                        </div>
                                        <label class="sr-only" for="inlineFormInputGroupUsername2">Select Product Type</label>
                                        <div class="input-group mb-2 mr-sm-2" style="display: none">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Product Type</div>
                                            </div>
                                            <select  name="product_type_id" style="" class="form-control select2">
                                                <option value="">Select Product Type</option>
                                                <?php $ptype = old('product_type_id')? old('product_type_id'):($p->productType? $p->productType->id: ""); ?>
                                                @foreach($product_types as $product_type)
                                                <option  value="{{$product_type->id}}" {{$ptype == $product_type->id? "selected":""}}>
                                                    {{$product_type->name}}
                                                </option>
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
                                            <select name="customer_id" style=""class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                                <option value="">Select Client/Customer</option>
                                                <?php $pcustomer = old('customer_id')? old('customer_id'): ($p->customer? $p->customer->id: "");?>
                                                @foreach($customers as $customer)         
                                                <option  value="{{$customer->id}}" {{$pcustomer == $customer->id? "selected":""}}>{{$customer->name}} | {{$customer->company_name}}</option>
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
                                        <input required type="text" class="form-control" id="inlineFormInputGroupUsername2" name="dosage" placeholder="Dosage" value="{{old('dosage')? old('dosage'): $p->dosage}}">
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
                                            <input type="string" class="form-control" id="inlineFormInputGroupUsername2" name="quantity" placeholder="Quantity" value="{{old('quantity')? old('quantity'): $p->quantity}}">
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
                                          <input class="form-control" type="date" placeholder="Date Manufactured" name="mfg_date" value="{{old('mfg_date')? old('mfg_date'): $p->mfg_date}}">
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
                                             <input class="form-control" type="date" placeholder="Date Expired"  name="exp_date" value="{{old('exp_date')? old('exp_date'): $p->exp_date}}">
                                        </div>
                                        <div>
                                             @error('exp_date')
                                             <small style="margin:15px" class="form-text text-danger" role="alert">
                                                 <strong>{{$message}}</strong>
                                             </small>
                                             @enderror
            
                                        </div>       
                                    </div>  
                                    <div class="col-sm-6">
                                        <div class="input-group mb-2 mr-sm-2">
                                           
                                            <textarea type="text" class="form-control" id="exampleTextarea1" name="indication" placeholder="Indication" value="{{old('indication')? old('indication'): ''}}" rows="4">{{$p->indication}}
                                            </textarea>
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
                                        <label class="sr-only" for="inlineFormInputGroupUsername2">Amount</label>
                                        <div class="input-group mb-2 mr-sm-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"></div>
                                            </div>
                                            <input type="text" class="form-control" id="inlineFormInputGroupUsername2" name="price" placeholder="Amount" value="{{old('price')? old('price'): $p->price}}">
                                        </div>
                                        <div>
                                            @error('price')
                                            <small style="margin:15px" class="form-text text-danger" role="alert">
                                                <strong>{{$message}}</strong>
                                            </small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-primary mb-2">Submit for review</button>

                                    </div>
                                </div>
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
                                    <h3 class="card-title">All products Recieved</h3>
                                  </div>
                                <div class="col-md-12">
                                  

									 <table id="order-table2" class="table table-striped table-bordered nowrap dataTable">
									    <thead>
									        <tr>
									            <th>Code</th>
									            <th>Product Name</th>
									            <th>Product Type</th>
									            <th>Customer</th>
                                                <th>Amt Paid</th>
                                                <th>Created By</th>
                                                <th>Date/Time Created</th>
                                                <th>Actions</th>
									            
									       </tr>
									    </thead>
									    <tbody>                                                
                                            @foreach($products as $product)
                                            <tr>
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
                                            <td class="font">{{$product->created_at}}</td>
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
