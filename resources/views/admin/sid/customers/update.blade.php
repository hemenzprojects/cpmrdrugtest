@extends('admin.layout.main')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-edit bg-blue"></i>
                <div class="d-inline">
                    <h5>Customers</h5>
                    <span>Bellow are registerd customers</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="../index.html"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="{{url('admin/sid/customer/create')}}">New Product</a>
                   </li>
                    
                </ol>
            </nav>
        </div>
        
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="dt-responsive ">
                    <table id="complex-dt" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                            <th>Name</th>
                            <th>Street Address</th>
                            <th>Tell.</th>
                            <th>Added By</th>
                            <th>Action</th>
        
                        </tr> 
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                        <tr>
                            <td class="font">{{$customer->name}}</td>
                             <td class="font">{{$customer->street_address}}</td>
                            <td class="font">{{$customer->tell}}</td>
                            <td class="font">{{$customer->created_by}}</td>
                            <td class="font">
                            <div class="table-actions">
                                                    
                                    {{-- {!! $product->show_tag !!} --}}

                                    {!! $customer->edit_tag !!}
                                
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
    <div class="col-md-4">
        <div class="card" style="min-height: 422px;">
            <div class="card-header"><h3>Register Customer</h3></div>
            <div class="card-body">
                <form action="{{url('admin/sid/customer/update',['id' => $c])}}" method="POST">
                    {{ csrf_field() }}

                    <div id="error-div" style="margin: 5px; color:red;"></div>
                  
                        <div class="form-group">
                            <label for="exampleSelectGender">Title</label>
                            <select name="title" class="form-control" id="exampleSelectGender" value="{{old('title')? old('title'): $c->title}}">
                            <option value="{{ $c->title}}"> {{$c->title}}</option>
                                <option>Mr</option>
                                <option>Mrs</option>
                                <option>Miss</option>
                                <option>Dr</option>
                            </select>
                        </div>
                                      
                    <div class="form-group">
                        <label for="exampleInputUsername1">Firstname</label>
                        <input type="text" required class="form-control" id="exampleInputUsername1" name="first_name" placeholder="Firstname" value="{{old('first_name')? old('first_name'): $c->first_name}}">

                        @error('first_name')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputUsername1">Lastname</label>
                        <input type="text" required class="form-control" id="exampleInputUsername1" placeholder="Lastname" name="last_name" value="{{old('last_name')? old('last_name'): $c->last_name}}">
                        @error('last_name')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" required class="form-control" id="exampleInputEmail1" placeholder="Email" name="email" value="{{old('email')? old('email'): $c->email}}">
                        @error('email')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Street Address</label>
                        <input type="text" required class="form-control" id="exampleInputUsername1" placeholder="Street Address" name="street_address" value="{{old('street_address')? old('street_address'): $customer->street_address}}">
                        @error('street_address')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputConfirmPassword1">House No.</label>
                        <input type="text" required class="form-control" id="exampleInputUsername1" placeholder="House No." name="house_number" value="{{old('house_number')? old('house_number'): $c->house_number}}">
                        @error('house_number')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                    </div>
                  
                    <div class="form-group">
                        <label for="exampleInputConfirmPassword1">Tell No.</label>
                        <input type="number" required class="form-control" id="exampleInputUsername1" placeholder="Tell No." name="tell" value="{{old('tell')? old('tell'): $c->tell}}">
                        @error('tell')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection