@extends('admin.layout.main')

@section('content')
<div class="">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-server bg-blue"></i>
                    <div class="d-inline">
                        <h5>Taskboard</h5>
                        <span>Welcome to Microbiology workspace</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Apps</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Taskboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card task-board">
                <div class="card-header" style="border-color: #f5365c;" >
                    @foreach($microproducts->groupBy('product_id') as $microproduct)
                    <label class="badge badge-warning" style="background-color:#f5365c; margin-right:5px;">
                       {{count($microproduct)}} 
                    </label>
                    @endforeach
                    <h3>Todos</h3>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="ik ik-chevron-left action-toggle"></i></li>
                            <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                            <li><i class="ik ik-minus minimize-card"></i></li>
                            <li><i class="ik ik-x close-card"></i></li>
                        </ul>
                    </div>
                </div>
                  <span class="" style="padding:5px">
                    <input class="form-control" id="listSearch1" type="text" placeholder="Type something to search list items">
                    </span>
                    
                <div class="card-body todo-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                    <div class="dd" data-plugin="nestable" >
                        <ul class="list-group" id="myList1">
                            @foreach($microproducts as $microproduct)
                            <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                            <div class="dd-handle">
                                <div class="row align-items-center">
                                    <div class="col-lg-9 col-md-12">
                                        <p><span href="" class="badge badge-danger pull-right">
                                        {{$microproduct->productType->code}}|{{$microproduct->id}}|{{$microproduct->created_at->format('y')}}
                                        </span>
                                          <span> {{ucfirst($microproduct->name)}}</span>
                                        </p>
                                    </div> 
                                    <div class="col-lg-3 col-md-12">
                                           <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$microproduct->id}}" title="View Product" href=""><i class="ik ik-eye"></i></a>   
                                    </div>                                                           
                                    <div class="modal fade" id="demoModal{{$microproduct->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="demoModalLabel"> Microbiology Product Details </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                        <div class="card-body"> 
                                                    
                                                            <h6> Product Name </h6>
                                                            <small class="text-muted ">{{$microproduct->productType->code}}|{{$microproduct->id}}|{{$microproduct->created_at->format('y')}} |   {{ucfirst($microproduct->name)}}</small>
                                                            <h6>Product Type </h6>
                                                            <small class="text-muted ">{{ucfirst($microproduct->productType->name)}}</small>
                                                            <h6>Quantity</h6>
                                                            @foreach ($microproduct->departments as $product)
                                                            <small class="text-muted ">{{$product->pivot->quantity}}</small>
                                                            @endforeach
                                                            <small class="text-muted "></small>
                                                            <h6>Indication</h6>
                                                            <p class="text-muted"> {{ ucfirst($microproduct->indication)}}<br></p>
        
                                                            <hr><h5>Distribution Details</h5>
                                                            <h6>Received By </h6>
                                                            @foreach ($microproduct->departments as $product)
                                                            <small class="text-muted">{{\App\Admin::find($product->pivot->received_by)? \App\Admin::find($product->pivot->received_by)->full_name:'null'}}</small>
                                                            @endforeach
                                                            <h6>Distributed By </h6>
                                                            @foreach ($microproduct->departments as $product)
                                                            <small class="text-muted">{{\App\Admin::find($product->pivot->distributed_by)?\App\Admin::find($product->pivot->distributed_by)->full_name:'null'}}</small>
                                                            @endforeach
                                                            <h6>Delivered By </h6>
                                                            @foreach ($microproduct->departments as $product)
                                                            <small class="text-muted">{{\App\Admin::find($product->pivot->delivered_by)?\App\Admin::find($product->pivot->delivered_by)->full_name:'null'}}</small>
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
                                                                @foreach ($microproduct->departments as $product)
                                                                Date: <small class="text-muted ">{{$product->pivot->created_at->format('Y-m-d')}}</small>
                                                                Time: <small class="text-muted ">{{$product->pivot->created_at->format('H:i:s')}}</small>
                                                                @endforeach
                                                            </small>
                                                            </div>
                                                            <h6> product delivery period</h6>
                                                            <small class="text-muted ">
                                                                @foreach ($microproduct->departments as $product)
                                                                Date: <small class="text-muted ">{{$product->pivot->updated_at->format('Y-m-d')}}</small>
                                                                Time: <small class="text-muted ">{{$product->pivot->updated_at->format('H:i:s')}}</small>
                                                                @endforeach
                                                          
                                                            </small>
                                                        </div> 
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                    </div>
                                </div>  
                                 
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header" style="border-color: #ffc107;" >
                    @foreach($microproduct_withtests->groupBy('product_id') as $microproduct_withtest)
                    <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                       {{count($microproduct_withtest)}} 
                    </label>
                    @endforeach
                    <h3>In Progress</h3>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="ik ik-chevron-left action-toggle"></i></li>
                            <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                            <li><i class="ik ik-minus minimize-card"></i></li>
                            <li><i class="ik ik-x close-card"></i></li>
                        </ul>
                    </div>
                </div>
                   <span class="" style="padding:5px">
                    <input class="form-control" id="listSearch" type="text" placeholder="Type something to search list items">
                    </span>
               
                  <div class="card-body progress-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                        
                        <ul class="list-group" id="myList">
                            @foreach($microproduct_withtests as $microproduct_withtest)
                          <li class="list-group-item" style="padding: 1px;border:1px">
                            <div class="dd-handle">
                                    
                                <div class="card-body feeds-widget">
                                <div class="feed-item">
                                    <a href="{{ route('admin.microbial_report.show', $microproduct_withtest->id) }}">
                                        <div class="feeds-left"><i class="ik ik-check-square text-warning"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="">
                                                <span href="" class="badge badge-warning pull-right">
                                                {{$microproduct_withtest->productType->code}}|{{$microproduct_withtest->id}}|{{$microproduct_withtest->created_at->format('y')}}
                                              </span>                
                                              <small class="float-right text-muted">{{count($microproduct_withtest->loadAnalyses)}} MLA Tests</small><br>
                                              @if (count($microproduct_withtest->efficacyAnalyses)>0)
                                              <small class="float-right text-muted">{{count($microproduct_withtest->efficacyAnalyses)}} MEA Tests</small><br>
                                              @endif

                                              {{-- <small class="float-right text-muted">{{$microproduct_withtest->microbialReports[0]->micro_indication}}</small> --}}

                                            </h4>
                                             @foreach($microproduct_withtest->microbialReports->groupBy('id')->first() as $report)
                                           <span>
                                            <small class="float-right font">Assigned {{\App\Admin::find($report->added_by_id)? \App\Admin::find($report->added_by_id)->full_name:'null'}}</small>

                                            </span>
                                              @endforeach 


                                        </div>
                                    </a>
                                </div>
                                </div>
             
                            </div>
                              
                          </li>
                          @endforeach
                        </ul>
                      
                  </div>
            </div>
        </div>   
        <div class="col-md-4">
            <div class="card">
                <div class="card-header" style="border-color:#26c281; margin:5px">
                    <h3>Completed</h3>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="ik ik-chevron-left action-toggle"></i></li>
                            <li><i class="ik ik-rotate-cw reload-card" data-loading-effect="pulse"></i></li>
                            <li><i class="ik ik-minus minimize-card"></i></li>
                            <li><i class="ik ik-x close-card"></i></li>
                        </ul>
                    </div>
                </div>
                <span class="" style="padding:5px;">
                    <input class="form-control" id="listSearch2" type="text" placeholder="Type something to search list items">
                    </span>
                <div class="card-body completed-task" style=" overflow-x: hidden;overflow-y: auto; height:350px;margin-bottom: 30px">
                    <div class="dd" data-plugin="nestable">
                        <ul class="dd-list list-group" id="myList2">                                   
                           
                            <li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> simply random text. It has roots in a piece of classical</p>
                                </div>
                            </li>
                            <li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> simply random text. It has roots in a piece of classical</p>
                                </div>
                            </li><li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> simply random text. It has roots in a piece of classical</p>
                                </div>
                            </li><li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> simply random text. It has roots in a piece of classical</p>
                                </div>
                            </li><li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> simply random text. It has roots in a piece of classical</p>
                                </div>
                            </li><li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> simply random text. It has roots in a piece of classical</p>
                                </div>
                            </li><li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> simply random text. It has roots in a piece of classical</p>
                                </div>
                            </li><li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> boat random text. It has roots in a piece of classical</p>
                                </div>
                            </li><li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> kwame random text. It has roots in a piece of classical</p>
                                </div>
                            </li><li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> mike random text. It has roots in a piece of classical</p>
                                </div>
                            </li><li class="dd-item" data-id="2">
                                <div class="dd-handle">
                                    {{-- <h6>Event Done</h6> --}}
                                    <p> simply random text. It has roots in a piece of classical</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.micro.report.create_test')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="row align-items-center">
                                                   
                       <div class="col-lg-12 col-md-12">
                        <div class="col-sm-12 1 box" style="display: none">
                            <div class="card">
                                <div class="card-header d-block">
                                    <span>Microbial Load Analysis</span>
                                </div>
                                <div class="card-body p-0 table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Test Conducted</th>
                                                    <th>Result</th>
                                                    <th>Acceptance Criterion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($MicrobialLoadAnalysis as $mltest)
                                                <tr>
                                                    <td class="font">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="mltest_id[]" value="{{$mltest->id}}" class="custom-control-input" checked="">
                            
                                                            <span class="custom-control-label">&nbsp;</span>
                                                        </label> 
                                                    </td>
                                                    <td class="font">
                                                        <input type="text" class="form-control" name="test_conducted[]" id="exampleInputName1" placeholder="Result" value="{{$mltest->test_conducted}}">
                                                      
                                                    </td>
                                                    <td class="font">
                                                        <input type="text" class="form-control" name="result[]" id="exampleInputName1" placeholder="Result" value="{{$mltest->result}}">
                                                    </td>
                                                    <td class="font">
                                                        <input type="text" class="form-control" name="acceptance_criterion[]" id="expresult-{{$mltest->id}}" placeholder="Result" value="{{$mltest->acceptance_criterion}}">
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <p></p>
                        </div> 
                        <div class="col-sm-12 2 box" style="display: none">
                            <div class="card">
                                <div class="card-header d-block">
                                    <span>Microbial Efficacy Analysis</span>
                                </div>
                                <div class="card-body p-0 table-border-style">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Pathogen</th>
                                                    <th>Product Inhibition Zone</th>
                                                    <th>Ciprofloxacin Inhibition Zone</th>
                                                    <th>Fluconazole Inhibition Zone</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($MicrobialEfficacyAnalysis as $metest)
                                                <tr>
                                                    <td class="font">
                                                        
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="metest_id[]" value="{{$metest->id}}" class="custom-control-input" checked="true">
                            
                                                            <span class="custom-control-label">&nbsp;</span>
                                                        </label> 
                                                        
                                                    </td>
                                                    <td class="font">{{$metest->pathogen}}</td>
                                                    <input type="hidden" class="form-control" name="pathogen[]" value="{{$metest->pathogen}}">

                                                    <td class="font">
                                                        <input type="text" class="form-control" name="pi_zone[]" id="exampleInputName1" placeholder="PI Zone" value="{{$metest->pi_zone}}">
                                                    </td>
                                                    <td class="font">{{$metest->ci_zone}}</td>
                                                    <input type="hidden" class="form-control" name="ci_zone[]" value="{{$metest->ci_zone}}">

                                                    <td class="font">{{$metest->fi_zone}}</td>
                                                    <input type="hidden" class="form-control" name="fi_zone[]"  value="{{$metest->fi_zone}}">

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> 
                       </div>
                        <div id="visitfromworld" style="width:100%;">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <h3 class="card-title">Select and assign product to various tests</h3>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputName1"></label>
                                    <select name="micro_product_id"  id="microproduct_id" style="" class="form-control select2">
                                        
                                        @foreach($microproducts as $microproduct)

                                    <option datatype="{{$microproduct->productType->id}}" value="{{ucfirst($microproduct->id)}}" {{$microproduct->id == old('products')? "selected":""}}>{{ucfirst($microproduct->name)}}</option>
                        
                                        @endforeach
                                    </select>
                                </div>
                                @error('micro_product_id')
                                <small style="margin-left:15px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                <strong>{{$message}}</strong>
                                </small>
                                @enderror
                            </div>  
                        </div>  
                    </div>
                
                    <div class="card-body">                   
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="custom-control custom-checkbox" >
                                <input type="checkbox" class="custom-control-input" name="loadanalyses" id="inlineCheckbox1" value="1">
                                <span class="custom-control-label">&nbsp;Microbial Load Analysis</span>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <label class="custom-control custom-checkbox" >
                                <input type="checkbox" class="custom-control-input" name="efficacyanalyses" id="inlineCheckbox1" value="2">
                                <span class="custom-control-label">&nbsp;Microbial Efficacy Analysis</span>
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" style="float:right" class="btn btn-primary mb-2">Submit Report </button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- {{$micro_report}} --}}
@endsection