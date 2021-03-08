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
                                    <a href="../index.html"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Forms</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Group Add-Ons</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        @foreach( $errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                                    <div class="card-header">
                                        <h3>Input Data</h3>
                                    </div>
                                    <div class="card-body">
                    	     <form action="{{url('admin/sid/product/update',['id' => $p])}}" class="form-inline" method="POST">
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
                                                <input type="text"  class="form-control" id="inlineFormInputGroupUsername2" name="name" placeholder="Product Name" value="{{old('name')? old('name'): $p->name}}">
                                                
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
                                            <div class="col-sm-4">
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
                                             <div class="col-md-3">
                                                <label class="sr-only" for="inlineFormInputGroupUsername2">Receipt Num</label>
                                                <div class="input-group mb-2 mr-sm-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Receipt No.</div>
                                                    </div>
                                                <input required type="text" class="form-control" id="" name="receipt_num" placeholder="Receipt No." value="{{old('receipt_num')? old('receipt_num'): $p->receipt_num}}">
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
                                                    @if ($p->single_multiple_lab ==1)
                                                         
                                                    <div class="col-md-6">
                     
                                                            <label class="custom-control custom-checkbox">
                                                                <input type="checkbox" name="single_multiple_lab" id="check_singlelab" value="1" class="custom-control-input" {{$p->single_multiple_lab == 1 ?'checked':''}}>
                                                                <span class="custom-control-label">&nbsp; Single Lab</span>
                                                            </label>
                                                   
                                                    </div>
                                                     <div class="col-md-6" >
                                                    
                                                     <label class="custom-control custom-checkbox">
                                                         <input type="checkbox" name="micro_hod_evaluation" value="1" class="custom-control-input" {{$p->micro_hod_evaluation == NULL ?'checked':''}}>
                                                         <span class="custom-control-label">&nbsp;Microbiology</span>
                                                     </label>
                                                     <label class="custom-control custom-checkbox">
                                                         <input type="checkbox" name="pharm_hod_evaluation" value="1" class="custom-control-input" {{$p->pharm_hod_evaluation == NULL ?'checked':''}}>
                                                         <span class="custom-control-label">&nbsp; Pharmacology</span>
                                                     </label>
                                                     <label class="custom-control custom-checkbox">
                                                         <input type="checkbox" name="phyto_hod_evaluation" value="1" class="custom-control-input" {{$p->phyto_hod_evaluation == NULL?'checked':''}}>
                                                         <span class="custom-control-label">&nbsp; Phytochemistry</span>
                                                     </label>
                                                 </div>
                                                  @endif 
                                                  @if ($p->single_multiple_lab ==2)
                                                         
                                                  <div class="col-md-6">
                                                      
                                                          <label class="custom-control custom-checkbox">
                                                              <input type="checkbox" name="single_multiple_lab" id="check_multilab" value="2" class="custom-control-input" {{$p->single_multiple_lab == 2 ?'checked':''}}>
                                                              <span class="custom-control-label">&nbsp; Multiple Lab</span>
                                                          </label>
                                                      
                                                  </div>
                                                   <div class="col-md-6" >
                                                  
                                                   <label class="custom-control custom-checkbox">
                                                       <input type="checkbox" name="micro_hod_evaluation" value="1" class="custom-control-input" {{$p->micro_hod_evaluation == NULL ?'checked':''}}>
                                                       <span class="custom-control-label">&nbsp;Microbiology</span>
                                                   </label>
                                                   <label class="custom-control custom-checkbox">
                                                       <input type="checkbox" name="pharm_hod_evaluation" value="1" class="custom-control-input" {{$p->pharm_hod_evaluation == NULL ?'checked':''}}>
                                                       <span class="custom-control-label">&nbsp; Pharmacology</span>
                                                   </label>
                                                   <label class="custom-control custom-checkbox">
                                                       <input type="checkbox" name="phyto_hod_evaluation" value="1" class="custom-control-input" {{$p->phyto_hod_evaluation == NULL?'checked':''}}>
                                                       <span class="custom-control-label">&nbsp; Phytochemistry</span>
                                                   </label>
                                               </div>
                                                @endif
                                                </div>                                              
                                                @if ($p->micro_hod_evaluation == Null && $p->pharm_hod_evaluation == Null  && $p->phyto_hod_evaluation == Null)
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
                                                    <p>Please check approved lab(s)</p>
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
                                                </div>
                                                <div class="col-md-7 multilab" style="display: none">
                                                    <p>Please check approved lab(s)</p>
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
                                                </div>
                                                 </div>  
                                                 @endif
                                             </div>
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-primary mb-2">Update Product</button>

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
                                    <h3 class="card-title">All products Received</h3>
                                  </div>
                                <div class="col-md-12" style="overflow-x: scroll" >
                                  

									 <table id="order-table_product" class="table table-striped table-bordered nowrap dataTable" >
									    <thead>
									        <tr>
                                                <th></th>
									            <th>Code</th>
									            <th>Product Name</th>
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
                                                <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                    {{$product->code}}
                                                </span>
                                           </td>
                                               <td class="font" style="width:15%" >{{ucfirst($product->name)}}
                                                @if ($product->failed_tag)
                                                <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;">#R</span></sup>
                                                @endif
                                                @if($product->single_multiple_lab ==1)
                                                <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#S</span></sup>
                                                @endif
                                                @if($product->single_multiple_lab ==2)
                                                <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#M</span></sup>
                                                @endif
                                            </td>
                                            <td class="font" >{{$product->productType->name}}</td>
                                            <td class="font">{{$product->customer_name}}</td>
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
