@extends('admin.layout.main')

@section('content')

<div class="card">
        <div class="card-body">
            <div class="card">
                <div class="text-center" style="margin: 2%"> 
                    <h4 class="font" style="font-size:18px">Generate report on prepared samples </h4>
                   <p class="card-subtitle"> Select date below to generate report on samples created</p>
                  </div>
                <div class="row" style="margin:1%">
                
                    <div class="col-lg-6">
                      
                       
                    </div>
                </div>
            </div>
            <div class="card-header row">
                <div class="col col-sm-1">
                    <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                       {{count($recordbooks)}} 
                    </label>
                </div>
                <div class="col col-sm-11">
                    <div class="card-search with-adv-search dropdown">
                        <form action="{{route('admin.pharm.samplepreparation.report')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-3">
                                <span style="margin: 5">From</span>  
                                <input type="date" name="from_date" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                              
                                <div class="col-md-3">
                                    <span style="margin: 5px">To  </span>  <input type="date" name="to_date" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-3">
                                    <span style="margin: 5px">User</span>  
                                    <select name="pharm_admin" id="" class="form-control">
                                        <option value="">All Useres</option>
                                        @foreach ($admins as $item)
                                       <option value="{{$item->id}}">{{$item->full_name}}</option> 
                                        @endforeach
                                       
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="hidden" name="samplepreparation">
                                    <button style="margin-top: 20px" type="submit" class="btn btn-primary mr-2">search</button>  
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
               
            </div><br>
            
            <div class="dt-responsive">
               
                    <table id="order-table1" class="table table-striped table-bordered nowrap">
                    
                      
                    <thead>
                    <tr>
                    
                        <th>Product</th>
                        <th>Weight</th>
                        <th>Dosage</th>
                        <th>Yield</th>
                        <th>Created By</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($recordbooks as $recordbook)
                            @php
                            $product = \App\Product::find($recordbook->product_id);
                            @endphp
                            <tr style="background-color: #fff">
                           
                            <td class="font">
                            <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$recordbook->id}}" title="View Product" href="">
                             <span href="" class="badge badge-danger pull-right">
                                {{ucfirst(\App\Product::findOrFail($recordbook->product_id)->code)}}
                            </span>
                            </a> 
                            
                            </td>
                            <td class="font">
                                {{$recordbook->weight}}
                            </td>
                            <td class="font">
                                {{$recordbook->dosage}}
                            </td>
                            <td class="font">
                                {{$recordbook->yield}}
                            </td>
                            <td class="font">
                                {{\App\Admin::find($recordbook->created_by)? \App\Admin::find($recordbook->created_by)->full_name:'null'}}
                            </td> 
                            <td class="font">
                                {{ Carbon\Carbon::parse($recordbook->created_at)->format('jS \\ F Y')}}
                            </td> 
                      
                        </tr>
                        <div class="modal fade" id="demoModal{{$recordbook->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="demoModalLabel"> Microbiology Product Details </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="card-body"> 
                                
                                        <h6> Product Name </h6>
                                        <small class="text-muted "> {{ucfirst($product->code)}}
                                           </small>
                                        <h6>Product Type </h6>
                                        <small class="text-muted ">{{ucfirst($product->productType->name)}}</small>
                                                                     
                                        <small class="text-muted "></small>
                                        <h6>Indication</h6>
                                        <p class="text-muted">{{ucfirst($product->indication)}}<br></p>
        
                                                <h6>Delivery Officer </h6>
                                                <small class="text-muted">{{\App\Admin::find($recordbook->delivered_by)?\App\Admin::find($recordbook->delivered_by)->full_name:'null'}}</small>
                                                <h6>Received By </h6>
                                                <small class="text-muted">{{\App\Admin::find($recordbook->received_by)?\App\Admin::find($recordbook->received_by)->full_name:'null'}}</small>
                                              
                                               
                                                <hr><h5>Distribution Periods</h5>
                                                <div  style="margin-bottom: 5px">
                                                <p>
                                                    <h6 >Distribution Period</h6>
                                                    Date: <small class="text-muted ">{{$recordbook->updated_at->format('Y-m-d')}}</small>
                                                    Time: <small class="text-muted ">{{$recordbook->updated_at->format('H:i:s')}}</small>
                                                   
                                                </p>
                                                 <p>
                                                    <h6 >Date Analysed</h6>
                                                   {{--                                                   
                                                    Date: <small class="text-muted ">{{$recordbook->updated_at->format('Y-m-d')}}</small>
                                                    Time: <small class="text-muted ">{{$recordbook->updated_at->format('H:i:s')}}</small> --}}
                                                   
                                                </p>
                                                </div>
                                            
                                                <hr><h5>Preparation Details</h5>
                                                <p><strong>Volume/Mass/Weight :</strong> {{$recordbook->measurement}} </p>
                                                <p><strong>Dosage :</strong> {{$recordbook->dosage}} </p>
                                                <p><strong>Yield :</strong> {{$recordbook->yield}} </p>
                                                <p><strong>Remarks :</strong> {{$recordbook->remarks}} </p>
        
                                    </div> 
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary"></button>
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



@endsection