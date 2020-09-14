@extends('admin.layout.main')

@section('content')
<div class="card">
    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="text-center" style="margin: 2%"> 
                    <h4 class="font" style="font-size:18px">Generate Report</h4>
                   <p class="card-subtitle"> selec date below to generate report</p>
                  </div>
                <div class="row" style="margin:1%">
                
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Daily Report</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Search</button>                                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Monthly Report</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Search</button>                                        </div>
                    </div>
            
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Yearly Report</label>
                            <div class="col-sm-6">
                                <input type="date" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">search</button>                                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header row">
                <div class="col col-sm-3">
                    <div class="card-options d-inline-block">
                        <a href="#"><i class="ik ik-inbox"></i></a>
                        <a href="#"><i class="ik ik-plus"></i></a>
                        <a href="#"><i class="ik ik-rotate-cw"></i></a>
                        <div class="dropdown d-inline-block">
                            <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-horizontal"></i></a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="moreDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">More Action</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-sm-6">
                    <div class="card-search with-adv-search dropdown">
                        <form action="" class="">
                            <input type="text" class="form-control global_filter" id="global_filter" placeholder="Search.." required="">
                            <button type="submit" class="btn btn-icon"><i class="ik ik-search"></i></button>
                            <button type="button" id="adv_wrap_toggler" class="adv-btn ik ik-chevron-down dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                            
                        </form>
                    </div>
                </div>
                <div class="col col-sm-3">
                    <div class="card-options text-right">
                        <span class="mr-5" id="top">1 - 50 of 2,500</span>
                        <a href="#"><i class="ik ik-chevron-left"></i></a>
                        <a href="#"><i class="ik ik-chevron-right"></i></a>
                    </div>
                </div>
            </div><br>
            
            <div class="dt-responsive">
               
                    <table id="lang-dt" class="table table-striped table-bordered nowrap">
                      Total Quantity: 
                       <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                          {{count($recordbooks)}} 
                       </label>
                      
                    <thead>
                    <tr>
                    
                        <th>Product</th>
                        <th>Volume</th>
                        <th>Dosage</th>
                        <th>Yield</th>
                        <th>Status</th>
                        <th>Delivery Officer</th>
                        <th>Received By</th>
                        <th>Date received</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($recordbooks as $recordbook)
                        
                        <tr style="background-color: #fff">
                           
                            <td class="font">
                            <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$recordbook->id}}" title="View Product" href="">
                             <span href="" class="badge badge-danger pull-right">
                                {{ucfirst(\App\Product::find($recordbook->product_id)->productType->code)}}|{{$recordbook->product_id}}|{{ucfirst(\App\Product::find($recordbook->product_id)->created_at->format('y'))}}
                            </span>
                            </a> 
                            - {{ucfirst(\App\Product::find($recordbook->product_id)->name)}}
                            </td>
                            <td class="font">
                                {{$recordbook->measurement}}
                            </td>
                            <td class="font">
                                {{$recordbook->dosage}}
                            </td>
                            <td class="font">
                                {{$recordbook->yield}}
                            </td>
                            <td class="font">
                                {!! \App\Product::find($recordbook->product_id)->pharm_product_status !!}
                            </td>
                            <td class="font">
                                {{\App\Admin::find($recordbook->delivered_by)? \App\Admin::find($recordbook->delivered_by)->full_name:'null'}}
                            </td> 
                            <td class="font">
                            {{\App\Admin::find($recordbook->received_by)? \App\Admin::find($recordbook->received_by)->full_name:'null'}}
                            </td> 
                            <td class="font">
                                {{$recordbook->updated_at->format('Y / m / d')}}
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
                                        <small class="text-muted "> {{ucfirst(\App\Product::find($recordbook->product_id)->productType->code)}}|{{$recordbook->product_id}}|{{ucfirst(\App\Product::find($recordbook->product_id)->created_at->format('y'))}}
                                            - {{ucfirst(\App\Product::find($recordbook->product_id)->name)}}</small>
                                        <h6>Product Type </h6>
                                        <small class="text-muted ">{{ucfirst(\App\Product::find($recordbook->product_id)->productType->name)}}</small>
                                                                     
                                        <small class="text-muted "></small>
                                        <h6>Indication</h6>
                                        <p class="text-muted">{{ucfirst(\App\Product::find($recordbook->product_id)->indication)}}<br></p>
        
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
</div>

@endsection