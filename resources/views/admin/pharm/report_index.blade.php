@extends('admin.layout.main')

@section('content')

<div class="container-fluid">

    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-server bg-blue"></i>
                    <div class="d-inline">
                        <h5>Taskboard</h5>
                        <span>Pharmacology / Toxicology product experimentation processes </span>
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
                <div class="card-header" style="border-color: red;" >
                    @foreach($sample_preps->groupBy('product_id') as $sample_prep)
                    <label class="badge badge-warning" style="background-color:red; margin-right:5px;">
                       {{count($sample_prep)}} 
                    </label>
                    @endforeach
                    <h3>Sample preparations @ animal exp. unit</h3>
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
                            @foreach($sample_preps as $sample_prep)
                          <a data-toggle="modal"  data-placement="auto" data-target="#demoModal{{$sample_prep->id}}" title="View Product" href="">

                            <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                            <div class="dd-handle">
                                <div class="row align-items-center">
                                    <div class="col-md-10 col-md-12">
                                        <p>
                                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                {{$sample_prep->code}}
                                            </span>
                                          {{-- <span>{{ucfirst($sample_prep->name)}}</span> --}}
                                        </p>
                                        <span href="" class="badge pull-right">
                                            <p style="font-size: 11.5px;margin: 2px"><strong>Animal Exp:</strong> {!! $sample_prep->pharm_product_status !!}</p> 
                                        </span><br>
                                     
                                    </div> 
                                                                            
                                     <a onclick="return confirm('Are you sure of deleting record?')" href="{{url('admin/pharm/samplepreparation/animalhouse/delete',['id' =>$sample_prep->id ])}}">
                                        <div class="col-md-2 col-md-12">
                                            <i class="ik ik-trash-2"></i>
                                        </div>
                                         </a> 
                                </div>  
                                 
                            </div>
                            </li>
                        </a>  
                            <div class="modal fade" id="demoModal{{$sample_prep->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel">Sample prepation details</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="card-body"> 
                                          <div class="row">
                                              <div class="col-sm-6">
                                                  
                                            <h6> Product Name </h6>
                                            <small class="text-muted ">
                                                <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                    {{$sample_prep->code}}
                                                </span>
                                            </small>
                                            <h6>Product Type </h6>
                                            <small class="text-muted ">{{ucfirst($sample_prep->productType->name)}}</small>

                                            <small class="text-muted "></small>
                                            <h6>Indication</h6>
                                            <p class="text-muted"> {{ ucfirst($sample_prep->indication)}}<br></p>
                                            <h6>Dosage</h6>
                                            <p class="text-muted"> {{ ucfirst($sample_prep->dosage)}}<br></p>
                                             </div>

                                             <div class="col-sm-6">
                                                <h5>Test to conduct</h5>
                                                @foreach ($sample_prep->samplePreparation as $product)
                                                {{\App\PharmTestConducted::find($product->pharm_testconducted_id)->name}}
                                                @endforeach
                                            </div>
                                          </div><hr>

                                          <h5>Preparation to animal house</h5>
                                            
                                          @foreach ($sample_prep->samplePreparation as $product)
                                          <p><strong>Measurement:</strong> {{$product->measurement}} </p>
                                          <p><strong>Remarks :</strong> {{$product->remarks}} </p>

                                          @endforeach                                 

                                            <hr><div class="row">
                                                
                                                <div class="col-sm-6">
                                                    @foreach ($sample_prep->samplePreparation as $product)
                                                    <h6>Distributor / Created by</h6>
                                                    <small class="text-muted">{{\App\Admin::find($product->distributed_by)? \App\Admin::find($product->distributed_by)->full_name:'null'}}</small>
                                                    <h6>Delivery Officer </h6>
                                                    <small class="text-muted">{{\App\Admin::find($product->delivered_by)?\App\Admin::find($product->delivered_by)->full_name:'null'}}</small>
                                                    <h6>Received By </h6>
                                                    <small class="text-muted">{{\App\Admin::find($product->received_by)?\App\Admin::find($product->received_by)->full_name:'null'}}</small>
                                                 
                                                    @endforeach
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6 >Date Distributed / Created</h6>
                                                    <p>
                                                        @foreach ($sample_prep->samplePreparation as $product)
                                                       @if ($product->distributed_at == Null)
                                                       Date:  
                                                       @else
                                                       Date: <small class="text-muted ">{{ Carbon\Carbon::parse($product->distributed_at)->format('jS \\, F Y')}}</small>

                                                       @endif
                                                        @endforeach
                                                    </p>
                                                    <p>
                                                        <h6>Date Delivered</h6>
        
                                                        @foreach ($sample_prep->samplePreparation as $product)
                                                        Date: <small class="text-muted ">{{ Carbon\Carbon::parse($product->delivered_at)->format('jS \\, F Y')}}</small>
                                                        @endforeach
                                                    </p>
                                                </div>

                                            </div>
                                                                                   

                                         
                                           
                                        </div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </ul>
                    </div>

                </div>
                <span style="padding: 10px;color:#007bff">
                 <a href="" class="text-dark" style="float: right; ">View all</a>
                </span>
                </div>
            
        </div>
        <div class="col-md-4">
            <div class="card task-board">
                <div class="card-header" style="border-color: #ffc107;" >
                    @foreach($exp_inprogress->groupBy('product_id') as $inprogress)
                    <label class="badge badge-warning" style="background-color:#ffc107; margin-right:5px;">
                       {{count($inprogress)}} 
                    </label>
                    @endforeach
                    <h3>In progress </h3>
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
                    <input class="form-control" id="listSearch2" type="text" placeholder="Type something to search list items">
                  </span>
                    
                <div class="card-body todo-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                    <div class="dd" data-plugin="nestable" >
                        <ul class="list-group" id="myList2">
                            
                            @foreach($exp_inprogress->sortBy('products.pharm_hod_evaluation') as $inprogress)
                            <div class="form-check mx-sm-2" style="display: none">
                                <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input pharmtestselect"  value="{{$inprogress->id}}" checked>
                                    <span class="custom-control-label">&nbsp; </span>
                                </label>
                            </div>
                             

                            <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                            <div class="dd-handle">
                                <div class="row align-items-center">

                                    <div class="col-lg-10 col-md-12" >
                                        <p  style="margin-bottom: 10px">
                                       <a data-toggle="modal"  data-placement="auto" data-target="#demoModal{{$inprogress->id}}" title="View Experiment" href=""></i>  
                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                            {{$inprogress->code}}
                                        </span>
                                        </a> 
                                         <span></span>
                                        </p>
                                          <span> <strong>Test :</strong> 
                                          {{\App\PharmTestConducted::find($inprogress->pharm_testconducted)->name}}
                                        </span><br>
                                           <span> <strong>Exp Analysed By :</strong> 
                                           
                                            @foreach ($inprogress->animalExperiment->groupBy('id')->first() as $item)
                                            {{\App\Admin::find($item->added_by_id)->full_name}}
                                            @endforeach
                                           
                                         </span><br>
                                         <span> <strong>Report Analyst:</strong>
                                            {{ucfirst(\App\Admin::find($inprogress->pharm_analysed_by)? \App\Admin::find($inprogress->pharm_analysed_by)->full_name:'Null')}}
                                         </span>

                                         <span><strong>Evaluation:</strong> 
                                           {!! $inprogress->pharm_general_report_evaluation !!}
                                        </span>
                                    </div>
                                    <div class="col-lg-2 col-md-12">
                                        <a href="{{url('admin/pharm/report/show',['id' => $inprogress->id])}}">
                                        <i class="ik ik-eye"></i>
                                    </a>
                                    <a href="{{url('admin/pharm/report/show',['id' => $inprogress->id])}}">
                                        <i class="ik ik-edit-2"></i>
                                    </a>    
                                    {{-- <a href="{{url('admin/pharm/samplepreparation/animalhouse/rejecttest',['id' => $inprogress->id ])}}">
                                    </a> --}}
                                    <i class="ik ik-trash-2" data-toggle="modal" data-target="#exampleModalCenter{{$inprogress->id}}"></i>

                                    </div>
                                   
                                    </div>  
                                   
                            </div>
                            </li>
                             
                            <div class="modal fade" id="exampleModalCenter{{$inprogress->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterLabel">Reject {{$inprogress->code}} report to animalhouse</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <form  id="pharmreportrejectapprovalform{{$inprogress->id}}" approve-user-url="{{route('admin.pharm.animalhouse.approverejection')}}" action="{{route('admin.pharm.samplepreparation.animalhouse.rejecttest')}}" class="" method="POST">
                                            {{ csrf_field() }}
                                            <input id ="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <h6>Please approve with pin to reject report</h6>
                                                <div id="error-div{{$inprogress->id}}" style="margin: 5px; color:red;"></div>
                                                <input required id="userpin{{$inprogress->id}}" type="password" class="form-control" name="pin" placeholder="Approve with PIN">
                                                <input type="hidden" value="{{$inprogress->id}}" name="product_id">
                                              <input type="hidden" id="useremail{{$inprogress->id}}" type="email" class="form-control" name="email" placeholder="Enter your email" value="{{App\Admin::find(Auth::guard("admin")->id())->email}}" readonly>
                                            </div>
                                          
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Approve</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                       
                        </ul>
                    </div>

                </div>
                <span style="padding: 10px;color:#007bff">
                 <a href="" class="text-dark" style="float: right; ">View all</a>
                </span>
                </div>
            
        </div>
        <div class="col-md-4">
            <div class="card task-board">
                <div class="card-header" style="border-color: #26c281;" >
                    @foreach($exp_completeds->groupBy('product_id') as $inprogress)
                    <label class="badge badge-warning" style="background-color:#26c281; margin-right:5px;">
                       {{count($exp_completeds)}} 
                    </label>
                    @endforeach
                    <h3>Completed Reports </h3>
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
                    <input class="form-control" id="listSearch3" type="text" placeholder="Type something to search list items">
                  </span>
                    
                <div class="card-body todo-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                    <div class="dd" data-plugin="nestable" >
                        <ul class="list-group" id="myList3">
                            @foreach($exp_completeds as $exp_completed)
                          

                            <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                            <div class="dd-handle">
                                <div class="row align-items-center">

                                    <div class="col-lg-10 col-md-12" >
                                        <p  style="margin-bottom: 10px">
                                       <a data-toggle="modal"  data-placement="auto" data-target="#demoModal{{$exp_completed->id}}" title="View Experiment" href=""></i>  
                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                            {{$exp_completed->code}}
                                        </span>
                                        </a> 
                                        </p>
                                          <span> <strong>Test :</strong> 
                                          {{\App\PharmTestConducted::find($exp_completed->pharm_testconducted)->name}}
                                        </span><br>
                                        <span> <strong>Exp Analysed By :</strong> 
                                           
                                            @foreach ($exp_completed->animalExperiment->groupBy('id')->first() as $item)
                                            {{\App\Admin::find($item->added_by_id)->full_name}}
                                            @endforeach
                                           
                                         </span><br>
                                         <span> <strong>Report Analyst:</strong>
                                            {{ucfirst(\App\Admin::find($exp_completed->pharm_analysed_by)? \App\Admin::find($exp_completed->pharm_analysed_by)->full_name:'Null')}}
                                         </span>
                                    </div>
                                   <a href="{{url('admin/pharm/completedreport/show',['id' => $exp_completed->id])}}">
                                    <div class="col-lg-2 col-md-12">
                                        <i class="ik ik-eye"></i>
                                    </div>
                                   </a> 
                                                                             
                                </div>  
                                <span class="float-right font" style="margin-top:10px">
                                    <a href="{{route('admin.pharm.report.pdf',['id' => $exp_completed->id])}}">
                                        <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                                      </a>
                                       
                                  </span>  
                            </div>
                            </li>
                        
                            {{-- <div class="modal fade" id="demoModal{{$exp_completed->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="width: 160%">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel">
                                                <hr>Animal Experiment Details </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="card-body"> 
                                        <div class="row">
                                            <div class="col-md-4 col-12">
                                                <h6> Product Name </h6>
                                                <small class="text-muted ">{{$exp_completed->productType->code}}|{{$exp_completed->id}}|{{$exp_completed->created_at->format('y')}} |   {{ucfirst($exp_completed->name)}}</small>
                                                <h6>Product Type </h6>
                                                <small class="text-muted ">{{ucfirst($exp_completed->productType->name)}}</small> 
                                                <small class="text-muted "></small>
                                                <h6>Indication</h6>
                                                <p class="text-muted"> {{ ucfirst($exp_completed->indication)}}<br></p>
    
                                               
                                            </div>
                                            <div class="col-md-4 col-12">
                                                @foreach ($exp_completed->samplePreparation as $product)
                                                <h6>Distributor </h6>
                                                <small class="text-muted">{{\App\Admin::find($product->distributed_by)? \App\Admin::find($product->distributed_by)->full_name:'null'}}</small>
                                                <h6>Delivery Officer </h6>
                                                <small class="text-muted">{{\App\Admin::find($product->delivered_by)?\App\Admin::find($product->delivered_by)->full_name:'null'}}</small>
                                                <h6>Received By </h6>
                                                <small class="text-muted">{{\App\Admin::find($product->received_by)?\App\Admin::find($product->received_by)->full_name:'null'}}</small>
                                              
                                                @endforeach
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <h5>Distribution Periods</h5>
                                                <div  style="margin-bottom: 5px">
                                                <p>
                                                    <h6 >Distribution Period</h6>
                                                    @foreach ($exp_completed->samplePreparation as $product)
                                                    Date: <small class="text-muted ">{{$product->created_at->format('Y-m-d')}}</small>
                                                    Time: <small class="text-muted ">{{$product->created_at->format('H:i:s')}}</small>
                                                    @endforeach
                                                </p>
                                                <p>
                                                    <h6 >Date Analysed</h6>
    
                                                    @foreach ($exp_completed->samplePreparation as $product)
                                                    Date: <small class="text-muted ">{{$product->updated_at->format('Y-m-d')}}</small>
                                                    Time: <small class="text-muted ">{{$product->updated_at->format('H:i:s')}}</small>
                                                    @endforeach
                                                </p>
                                                </div>
                                            </div>
                                        </div>
                                            
                                         
                                        
                                              <ul class="nav justify-content-center" style="margin-top: 10px"> 
                                                <h6> {{\App\PharmTestConducted::find($exp_completed->pharm_testconducted)->name}}</h6>                                          
                                               </ul>
                                               <ul class="nav justify-content-center" style="margin-top: 5px"> 
                                                <h6> Group 1</h6>                                          
                                               </ul>
                                            <div class="row" style="margin:5px; padding:15px; background:#f7f4f4">
                                                                
                                                <div class="col-md-2 col-6"> <strong>Animalmodel</strong>
                                                    <br>
                                                @foreach ($exp_completed->animalExperiment->where('group',1) as $product)
                                                <p>{{$product->pharm_animal_model}} </p>
                                                @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Weight</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',1) as $product)
                                                    <p>{{$product->weight}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Volume given</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',1) as $product)
                                                    <p>{{$product->volume}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Death</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',1) as $product)
                                                    <p>{{$product->death}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Sex</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',1) as $product)
                                                    <p>{{$product->sex}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>method</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',1) as $product)
                                                    <p> {{$product->method}}</p>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <ul class="nav justify-content-center" style="margin-top: 15px"> 
                                                <h6> Group 2</h6>                                          
                                               </ul>
                                            <div class="row" style="margin:5px; padding:15px; background:#f7f4f4">
                                                                
                                                <div class="col-md-2 col-6"> <strong>Animalmodel</strong>
                                                    <br>
                                                @foreach ($exp_completed->animalExperiment->where('group',2) as $product)
                                                <p>{{$product->pharm_animal_model}} </p>
                                                @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Weight</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',2) as $product)
                                                    <p>{{$product->weight}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Volume given</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',2) as $product)
                                                    <p>{{$product->volume}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Death</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',2) as $product)
                                                    <p>{{$product->death}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Sex</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',2) as $product)
                                                    <p>{{$product->sex}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>method</strong>
                                                    <br>
                                                    @foreach ($exp_completed->animalExperiment->where('group',2) as $product)
                                                    <p> {{$product->method}}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                           
                                           
                                        </div> 
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary"></button>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            @endforeach
                        </ul>
                    </div>

                </div>
                <span style="padding: 10px;color:#007bff">
                <a href="{{route('admin.pharm.completedreports.index')}}" class="text-dark" style="float: right; ">View all</a>
                </span>
                </div>
            
        </div>
        {{-- <div class="col-md-4">
            <div class="card">
                <div class="card-header">
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
                <div class="card-body completed-task">
                    <div class="dd" data-plugin="nestable">
                        <ol class="dd-list">                                   
                            <li class="dd-item" data-id="1">
                                <div class="dd-handle">                                        
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

<div class="row">
    <div class="col-md-12">
       
            <div class="card">
                
                <div class="card-header d-block">
                    <div class="row">
                        <div class="col-md-9">
                            <h3>  @foreach($samples_to_animalhouses->groupBy('product_id') as $pharmproduct)
                                <label class="badge badge-warning" style="background-color:#f5365c; margin-right:5px;">
                                   {{count($pharmproduct)}} 
                                </label>
                                @endforeach Sample(s) prepared to animal house form</h3>
                        </div>
                        <div class="col-md-3">
                            <p>Please input accurate data </p>
                        </div>
                    </div>
                </div>
              <form action="{{route('admin.pharm.sampleprep_animalhouse.store')}}" method="post">
                {{ csrf_field() }}
                <div class="card-body" style="overflow-x: scroll" >
                    <div class="dt-responsive">
                        <table id="scr-vtr-dynamic" class="table table-striped table-bordered nowrap" >
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Measurement</th>
                                <th>Remarks</th>
                                <th>Test to Conduct</th>
                                <th>Created By</th>

                                <th>#</th>
                            </tr>
                            </thead>
                            <tbody>
                        
                           @foreach($samples_to_animalhouses as $pharmproduct)

                            @foreach ($pharmproduct->samplePreparation as $item)
                            <tr style="background-color: #fff">
                            <td class="font">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" id="pharmproduct_{{$pharmproduct->id}}" product_method="{{$pharmproduct->productType->method_applied}}" name="product_id[]" class="custom-control-input method_applied" value="{{$pharmproduct->id}}">
                                <span class="custom-control-label"></span>
                            </label>
                            <input type="hidden" name="item_id[]" value="{{$item->id}}">
                           </td>
                            <td class="font">

                            <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$pharmproduct->id}}" title="View Product" href="">
                                <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                    {{$pharmproduct->code}}
                                </span>
                            </a> 
                          
                            </td>
                            <td class="font">
                                <input type="text" class="form-control" name="measurement[]"  placeholder="Volume/Mass/Weight">
                            </td>

                            <td class="font">
                                <input type="text" class="form-control" name="remarks[]" placeholder="Remarks">
                            </td> 
                            <td class="font">
                                <strong>{{\App\PharmTestconducted::find($item->pharm_testconducted_id)->name}}</strong> 
                            </td>
                            <td class="font">
                                {{ucfirst(\App\Admin::find($item->created_by)? \App\Admin::find($item->created_by)->full_name:'null')}}
                            </td>
                             <td>
                                <a onclick="return confirm('Are you sure of deleting record?')" href="{{url('admin/pharm/samplepreparation/delete',['id' =>$pharmproduct->id ])}}">
                                    <div class="col-md-2 col-md-12">
                                        <i class="ik ik-trash-2"></i>
                                    </div>
                                     </a> 
                             </td>
                        </tr>
                        <div class="modal fade" id="demoModal{{$pharmproduct->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="demoModalLabel">Sample prepared and product details </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="card-body"> 
                                
                                        <p><strong>Product Name  :</strong> {{$pharmproduct->code}}</p>
                                        <p><strong>Product Type  :</strong> {{ucfirst($pharmproduct->productType->name)}}</p>
                                        <p><strong>Indication  :</strong> {{ ucfirst($pharmproduct->indication)}}</p><br>

                                        <h5>Preparation Details</h5>
                                            
                                          <p><strong>Volume/Mass/Weight :</strong> {{$item->weight}} </p>
                                          <p><strong>Dosage :</strong> {{$item->dosage}} </p>
                                          <p><strong>Yield :</strong> {{$item->yield}} </p>
                                          <p><strong>Date created :</strong>  {{ Carbon\Carbon::parse($item->created_at)->format('jS \\, F Y')}}</p>


                                    </div> 
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endforeach
                           @endforeach
                        </tbody>
                      
                        </table>
                      

                        
                    </div>
                 
                   <div class="row">
                       <div class="col-sm-9"></div>
                       <div class="col-sm-2">
                        <button onclick="return confirm('Please click Ok to confirm submission of sample preparation')"  type="submit" class="btn btn-primary mr-2">Send Samples</button>
                       </div>
                   </div>
                </div>
              </form> 
            </div>
      
    </div>
 
</div>
@endsection