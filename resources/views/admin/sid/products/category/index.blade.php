@extends('admin.layout.main')

@section('content')

<div class="">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-edit bg-blue"></i>
                            <div class="d-inline">
                                <h5>Product Category Registration</h5>
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
                                <li class="breadcrumb-item active" aria-current="page">All Products Category</li>
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
                    <form  action="{{url('admin/sid/create_product_category')}}" class="forms-sample" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputName1">Category Code</label>
                                    <input type="text" name="code" class="form-control" id="exampleInputUsername1" placeholder="Code">                       
                                 </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Category Name</label>
                                    <input type="text" name="name" class="form-control" id="exampleInputUsername1" placeholder="Name">                           
                             </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                   
                                        <label for="exampleSelectGender">Microbial Form </label>
                                        <select name="form" class="form-control" id="exampleSelectGender">
                                            <option value="1">Cold</option>
                                            <option value="2">Hot</option>
                                        </select>
                                                                
                                </div>
                            </div>
                            <div class="col-sm-3">
                              
                                    <div class="form-group">
                                        <label for="exampleSelectGender">Microbial State</label>
                                        <select name="state" class="form-control" id="exampleSelectGender">
                                            <option value="1">Solid</option>
                                            <option value="2">Liquid</option>
                                        </select>
                                    </div>                         
                                </div>  
                        </div>
                           <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Method Applied</label>
                                        <select name="method_applied" class="form-control" id="exampleSelectGender">
                                            <option value="1">Aural</option>
                                            <option value="2">Skin/Dermal</option>
                                        </select>                                
                                        </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail3">Pharmacology Standards</label>
                                        <div class="form-group">
                                            <select name="pharm_standard_id" class="form-control select2">
                                                @foreach($pharm_standards as $pharm_standard)
                                                                
                                                <option  value="{{$pharm_standard->id}}" {{$pharm_standard->id == old('product_type_id')? "selected":""}}><strong>{{$pharm_standard->description}}</strong> ....... {{$pharm_standard->default}}</option>
            
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-sm-3">
                                        
                                        <button style="margin-top:30px" type="submit" class="btn btn-primary mr-2">Submit</button>

                                    </div>  
                             </div>
                    </form>
                

                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-12">
                            <h3 class="card-title">All products Recieved</h3>
                          </div>
                        <div class="col-md-12">
                          

                             <table id="order-table2" class="table table-striped table-bordered nowrap dataTable">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Product State</th>
                                        <th>Product Form</th>
                                        <th>Method Applied</th>
                                        <th>Created By</th>
                                        <th>Date/Time Created</th>
                                        <th>Actions</th>

                                   </tr>
                                </thead>
                                <tbody>                                                
                                    @foreach($product_types as $product_type)
                                    <tr>
                                    <td class="font">{{$product_type->code}}</td>
                                    <td class="font">{{$product_type->name}}</td>
                                    <td class="font">{{$product_type->microbial_form}}</td>
                                    <td class="font">{{$product_type->microbial_state}}</td>
                                    <td class="font">{{$product_type->pharm_method_applied}}</td>
                                    <td class="font">{{App\Admin::find($product_type->added_by_id)->full_name}}</td>
                                    <td class="font">{{$product_type->created_at->format('Y / m / d')}}</td>
                                    <td class="font">
                                        <div class="table-actions">
                                        <a href="#"><i class="ik ik-eye"></i></a>
                                            <a href="{{route('admin.sid.product.category.edit', ['id' => $product_type->id])}}"><i class="ik ik-edit-2"></i></a>
                                            <a href="#"><i class="ik ik-trash-2"></i></a>
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

@endsection
