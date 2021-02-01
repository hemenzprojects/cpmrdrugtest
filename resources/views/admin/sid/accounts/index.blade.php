@extends('admin.layout.main')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-menu bg-blue"></i>
                <div class="d-inline">
                    <h5>Account</h5>
                    <span>Bellow are account details of </span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="ik ik-home"></i></a>
                    </li>                    
                </ol>
            </nav>
        </div>
     
    </div>
</div>
<div class="card">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card" style="padding: 1%">
                         <div class="row" style="margin: %">
                        <div class="col-md-4">
                            <p style="margin-bottom: 2%"><strong>Product :</strong></p></div>
                        <div class="col-md-6">
                         <div>{{$product->productType->code}}|{{$product->id}}|{{$product->created_at->format('y')}} - {{$product->name}}</div>
                         
                        </div>
                       
                     </div> 
                     <div class="row" style="margin: %">
                         <div class="col-md-4">
                             <p style="margin-bottom: 2%"><strong>Customer :</strong></p></div>
                         <div class="col-md-6">
                          <div>{{$product->customer_name}}</div>
                         </div>
                         
                      </div> 
                      </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                            <div class="text-center" style="margin: "> 
                                  <h5><span style="font-size: 17px">Total Amount Paid: </span><span style="color: #2dce89;font-size: 20px; font-weight: 900; "><br>GH {{$product->price}}.00</span></h5> 
                                  <h5> <span style="font-size: 17px">Total Amount Due :</span> <span style="color: #e80808;font-size: 20px; font-weight: 900; "><br>GH {{460 - $product->price }}.00</span></h5> 

                               </div>
                            </div>
                        </div>
                    </div>
                  
                     <p style="margin-bottom: 2%"><strong>Initial Payments</strong></p>
               
                <form action="{{route('admin.sid.product.account.store',['id' => $product->id] )}}" method="POST">
                        {{ csrf_field() }}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Receipt Num</th>
                                    <th>Date</th>
                                    <th>Amt (Gh)</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Account::where('product_id',$product->id)->get() as $item)
                                <tr>
                                    <td>
                                        <p>{{$item->customer}}</p>
                                    </td>
                                    <td>
                                        <p>{{$item->receipt_num}}</p>
                                    </td>
                                    <td>
                                        <p>{{$item->created_at}}</p>
                                    </td>
                                    <td>
                                        <p>{{$item->price}}.00</p>
                                    </td>
                                    <td>
                                    <a href="{{route('admin.sid.product.account.delete',['p_id' => $product->id,'act_id'=> $item->id,'price'=> $product->price])}}">
                                        <button onclick="return confirm('Click ok if you sure of deleting product')" type="button" name="remove" class="btn btn-danger btn_remove">X</button></a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <thead>
                                <tr>
                                <th>Total</th>
                                <th></th>
                                <th>
                                    <input type="hidden" class="form-control" name="initial_amt" value="{{$product->price}}">
                                </th>
                                <th style="font-size: 17px"><strong>{{$product->price}}.00</strong></th>
                                <th><strong></strong></th>

                                </tr>
                            </thead>
                        </table>
                    </div>
                    <p class="mb-10"><strong>Amt Paid</strong></p>
                    <div class="row">
                        <label class="col-sm-6 col-lg-6 col-form-label">Input amount paid</label>
                        <div class="col-sm-6 col-lg-6">
                            <div class="form-group">
                                <input type="text" class="form-control"  name="customer" placeholder="Customer" value="{{$product->customer_name}}">
                                @error('customer')
                                <small class="form-text text-danger" role="alert">
                                    <strong>{{$message}}</strong>
                                </small>
                                @enderror<br>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control"  name="receipt_num" placeholder="Receipt Num">
                                @error('customer')
                                <small class="form-text text-danger" role="alert">
                                    <strong>{{$message}}</strong>
                                </small>
                                @enderror<br>
                            </div>
                            <div class="input-group">
                                @error('amt_paid')
                                <small  class="form-text text-danger" role="alert">
                                    <strong>{{$message}}</strong>
                                </small>
                                @enderror<br>
                                <span class="input-group-prepend">
                                    <label class="input-group-text">GH</label>
                                </span>
                                <input type="text" class="form-control" name="amt_paid" placeholder="Amount Paid">
                                <span class="input-group-append">
                                    <label class="input-group-text">.00</label>
                                </span>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Make Payment</button>
                        </div>
                    </div>
                </form>
             </div>
             </div>
            <div class="col-md-6">
              
            </div>
    
        </div>
     </div>
</div>


@endsection