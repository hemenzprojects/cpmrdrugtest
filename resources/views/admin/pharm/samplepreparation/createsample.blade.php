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
                        <span>Pharmacology product experimentation processes </span>
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
                    <h3>Sample Preparations</h3>
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
                                        <span href="" class="badge  pull-right" style="background-color:red; color:#fff">
                                        {{$sample_prep->productType->code}}|{{$sample_prep->id}}|{{$sample_prep->created_at->format('y')}}
                                        <sup style="font-size: 1px">
                                            {{$sample_prep->productType->code}}{{$sample_prep->id}}{{$sample_prep->created_at->format('y')}}
                                           </sup>
                                        </span>
                                          {{-- <span>{{ucfirst($sample_prep->name)}}</span> --}}
                                        </p>
                                        <span href="" class="badge pull-right">
                                            <p style="font-size: 11.5px;margin: 2px"><strong>Animal Exp:</strong> {!! $sample_prep->pharm_product_status !!}</p> 
                                        </span><br>
                                     
                                    </div> 
                                                                                       
                                    <a onclick="return confirm('Are you sure of deleting record?')" href="{{url('admin/pharm/samplepreparation/delete',['id' =>$sample_prep->id ])}}">
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
                                            <small class="text-muted ">{{$sample_prep->productType->code}}|{{$sample_prep->id}}|{{$sample_prep->created_at->format('y')}}</small>
                                            <h6>Product Type </h6>
                                            <small class="text-muted ">{{ucfirst($sample_prep->productType->name)}}</small>
                                            <h6>Quantity</h6>                                         
                                            @foreach ($sample_prep->departments->groupBy('id')->first() as $product)
                                            <small class="text-muted ">{{$product->pivot->quantity}}</small>
                                            @endforeach
                                            <small class="text-muted "></small>
                                            <h6>Indication</h6>
                                            <p class="text-muted"> {{ ucfirst($sample_prep->indication)}}<br></p>
                                            <h6>Dosage</h6>
                                            <p class="text-muted"> {{ ucfirst($sample_prep->dosage)}}<br></p>
                                             </div>

                                             <div class="col-sm-6">
                                                <h5>Test Conducted</h5>
                                                @foreach ($sample_prep->samplePreparation as $product)
                                                {{\App\PharmTestConducted::find($product->pharm_testconducted_id)->name}}
                                                @endforeach
                                            </div>
                                          </div><hr>

                                          <h5>Preparation Details</h5>
                                            
                                          @foreach ($sample_prep->samplePreparation as $product)
                                          <p><strong>Volume/Mass/Weight :</strong> {{$product->measurement}} </p>
                                          <p><strong>Dosage :</strong> {{$product->dosage}} </p>
                                          <p><strong>Yield :</strong> {{$product->yield}} </p>
                                          <p><strong>Remarks :</strong> {{$product->remarks}} </p>

                                          @endforeach                                 

                                            <hr><div class="row">
                                                
                                                <div class="col-sm-6">
                                                    @foreach ($sample_prep->samplePreparation as $product)
                                                    <h6>Distributor </h6>
                                                    <small class="text-muted">{{\App\Admin::find($product->distributed_by)? \App\Admin::find($product->distributed_by)->full_name:'null'}}</small>
                                                    <h6>Delivery Officer </h6>
                                                    <small class="text-muted">{{\App\Admin::find($product->delivered_by)?\App\Admin::find($product->delivered_by)->full_name:'null'}}</small>
                                                    <h6>Received By </h6>
                                                    <small class="text-muted">{{\App\Admin::find($product->received_by)?\App\Admin::find($product->received_by)->full_name:'null'}}</small>
                                                 
                                                    @endforeach
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6 >Date Distributed</h6>
                                                    <p>
                                                        @foreach ($sample_prep->samplePreparation as $product)
                                                        Date: <small class="text-muted ">{{$product->created_at->format('Y-m-d')}}</small>
                                                        Time: <small class="text-muted ">{{$product->created_at->format('H:i:s')}}</small>
                                                        @endforeach
                                                    </p>
                                                    <p>
                                                        <h6 >Date Analysed</h6>
        
                                                        @foreach ($sample_prep->samplePreparation as $product)
                                                        Date: <small class="text-muted ">{{$product->updated_at->format('Y-m-d')}}</small>
                                                        Time: <small class="text-muted ">{{$product->updated_at->format('H:i:s')}}</small>
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
                            @foreach($exp_inprogress->sortBy('pharm_hod_evaluation') as $inprogress)
                          

                            <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                            <div class="dd-handle">
                                <div class="row align-items-center">

                                    <div class="col-lg-10 col-md-12" >
                                        <p  style="margin-bottom: 10px">
                                       <a data-toggle="modal"  data-placement="auto" data-target="#demoModal{{$inprogress->id}}" title="View Experiment" href=""></i>  
                                        <span href="" class="badge  pull-right" style="background-color: #ffc107 ">
                                        {{$inprogress->productType->code}}|{{$inprogress->id}}|{{$inprogress->created_at->format('y')}}
                                        <sup style="font-size: 1px">
                                            {{$inprogress->productType->code}}{{$inprogress->id}}{{$inprogress->created_at->format('y')}}
                                         </sup>    
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
                                           
                                         </span>
                                         <span><strong>Evaluation:</strong> 
                                           {!! $inprogress->pharm_report_evaluation !!}
                                        </span>
                                    </div>
                                    <a href="{{url('admin/pharm/report/show',['id' => $inprogress->id])}}">
                                    <div class="col-lg-2 col-md-12">
                                        <i class="ik ik-eye"></i>
                                    </div>
                                   </a>                                               
                                </div>  
                              
                            </div>
                            </li>
                        
                            <div class="modal fade" id="demoModal{{$inprogress->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
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
                                                <small class="text-muted ">{{$inprogress->productType->code}}|{{$inprogress->id}}|{{$inprogress->created_at->format('y')}} |   {{ucfirst($inprogress->name)}}</small>
                                                <h6>Product Type </h6>
                                                <small class="text-muted ">{{ucfirst($inprogress->productType->name)}}</small> 
                                                <small class="text-muted "></small>
                                                <h6>Indication</h6>
                                                <p class="text-muted"> {{ ucfirst($inprogress->indication)}}<br></p>
    
                                               
                                            </div>
                                            <div class="col-md-4 col-12">
                                                @foreach ($inprogress->samplePreparation as $product)
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
                                                    @foreach ($inprogress->samplePreparation as $product)
                                                    Date: <small class="text-muted ">{{$product->created_at->format('Y-m-d')}}</small>
                                                    Time: <small class="text-muted ">{{$product->created_at->format('H:i:s')}}</small>
                                                    @endforeach
                                                </p>
                                                <p>
                                                    <h6 >Date Analysed</h6>
    
                                                    @foreach ($inprogress->samplePreparation as $product)
                                                    Date: <small class="text-muted ">{{$product->updated_at->format('Y-m-d')}}</small>
                                                    Time: <small class="text-muted ">{{$product->updated_at->format('H:i:s')}}</small>
                                                    @endforeach
                                                </p>
                                                </div>
                                            </div>
                                        </div>
                                            
                                         
                                        
                                              <ul class="nav justify-content-center" style="margin-top: 10px"> 
                                                <h6> {{\App\PharmTestConducted::find($inprogress->pharm_testconducted)->name}}</h6>                                          
                                               </ul>
                                               <ul class="nav justify-content-center" style="margin-top: 5px"> 
                                                <h6> Group 1</h6>                                          
                                               </ul>
                                            <div class="row" style="margin:5px; padding:15px; background:#f7f4f4">
                                                                
                                                <div class="col-md-2 col-6"> <strong>Animalmodel</strong>
                                                    <br>
                                                @foreach ($inprogress->animalExperiment->where('group',1) as $product)
                                                <p>{{$product->pharm_animal_model}} </p>
                                                @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Weight</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',1) as $product)
                                                    <p>{{$product->weight}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Volume given</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',1) as $product)
                                                    <p>{{$product->volume}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Death</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',1) as $product)
                                                    <p>{{$product->death}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Sex</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',1) as $product)
                                                    <p>{{$product->sex}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>method</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',1) as $product)
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
                                                @foreach ($inprogress->animalExperiment->where('group',2) as $product)
                                                <p>{{$product->pharm_animal_model}} </p>
                                                @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Weight</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',2) as $product)
                                                    <p>{{$product->weight}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Volume given</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',2) as $product)
                                                    <p>{{$product->volume}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Death</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',2) as $product)
                                                    <p>{{$product->death}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>Sex</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',2) as $product)
                                                    <p>{{$product->sex}} </p>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-2 col-6"> <strong>method</strong>
                                                    <br>
                                                    @foreach ($inprogress->animalExperiment->where('group',2) as $product)
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
                                        <span href="" class="badge  pull-right" style="background-color: #26c281 ">
                                        {{$exp_completed->productType->code}}|{{$exp_completed->id}}|{{$exp_completed->created_at->format('y')}}
                                        <sup style="font-size: 1px">
                                            {{$exp_completed->productType->code}}{{$exp_completed->id}}{{$exp_completed->created_at->format('y')}}
                                         </sup> 
                                      </span>
                                        </a> 
                                         <span>{{ucfirst($exp_completed->name)}}</span>
                                        </p>
                                          <span> <strong>Test :</strong> 
                                          {{\App\PharmTestConducted::find($exp_completed->pharm_testconducted)->name}}
                                        </span><br>
                                        <span> <strong>Exp Analysed By :</strong> 
                                           
                                            @foreach ($exp_completed->animalExperiment->groupBy('id')->first() as $item)
                                            {{\App\Admin::find($item->added_by_id)->full_name}}
                                            @endforeach
                                           
                                         </span>
                                    </div>
                                   <a href="{{url('admin/pharm/completedreport/show',['id' => $exp_completed->id])}}">
                                    <div class="col-lg-2 col-md-12">
                                        <i class="ik ik-eye"></i>
                                    </div>
                                   </a>                                               
                                </div>  
                              
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
            <div class="card">
                <div class="card-header d-block">
                   
                    <h3>  @foreach($pharmproducts->groupBy('product_id') as $pharmproduct)
                        <label class="badge badge-warning" style="background-color:#f5365c; margin-right:5px;">
                           {{count($pharmproduct)}} 
                        </label>
                        @endforeach Sample Prepared To Animal House</h3>
                </div>
              <form action="{{route('admin.pharm.samplepreparation.store')}}" method="post">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="dt-responsive">
                        <table id="scr-vrt-dt"
                               class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Measurement</th>
                                <th>Test Conducted</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                           @foreach($pharmproducts as $pharmproduct)
                            <tr style="background-color: #fff">
                                <td class="font">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" id="pharmproduct_{{$pharmproduct->id}}" product_method="{{$pharmproduct->productType->method_applied}}" name="product_id[]" class="custom-control-input method_applied" value="{{$pharmproduct->id}}">
                                    <span class="custom-control-label"></span>
                                </label>
                               </td>
                                <td class="font">

                                <a data-toggle="modal" data-placement="auto" data-target="#demoModal{{$pharmproduct->id}}" title="View Product" href="">
                                 <span href="" class="badge badge-danger pull-right">
                                     
                                        {{$pharmproduct->productType->code}}|{{$pharmproduct->id}}|{{$pharmproduct->created_at->format('y')}}
                                </span>
                                </a> 
                                 <sup style="font-size: 1px">
                                    {{$pharmproduct->productType->code}}{{$pharmproduct->id}}{{$pharmproduct->created_at->format('y')}}
                                 </sup> 
                                </td>
                                <td class="font">
                                    <input type="text" class="form-control" name="measurement_{{$pharmproduct->id}}"  placeholder="Volume/Mass/Weight" >
                                </td>
                                {{-- <td class="font">
                                    <input type="text" class="form-control" name="dosage_{{$pharmproduct->id}}"  placeholder="Dosage">
                                </td>
                                <td class="font">
                                    <input type="text" class="form-control" name="yield_{{$pharmproduct->id}}"  placeholder="Yield">
                                </td> --}}
                                <td class="font">
                            
                                    <select  name="pharm_testconducted_{{$pharmproduct->id}}" style="" class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                        <option value="">Select Test</option>
                                        @foreach($pharm_testconducteds as $pharm_testconducted)
                                                            
                                        <option value="{{$pharm_testconducted->id}}" {{$pharm_testconducted->id == $pharmproduct->productType->method_applied ? "selected":""}}>{{$pharm_testconducted->name}}</option>
                                        
                                        @endforeach
                                        </select>
                                </td>
                                <td class="font">
                                    <input type="text" class="form-control" name="remarks_{{$pharmproduct->id}}" placeholder="Remarks">
                                </td> 

                            </tr>
                            <div class="modal fade" id="demoModal{{$pharmproduct->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel"> Microbiology Product Details </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="card-body"> 
                                    
                                            <h6> Product Name </h6>
                                            <small class="text-muted ">{{$pharmproduct->productType->code}}|{{$pharmproduct->id}}|{{$pharmproduct->created_at->format('y')}} |   {{ucfirst($pharmproduct->name)}}</small>
                                            <h6>Product Type </h6>
                                            <small class="text-muted ">{{ucfirst($pharmproduct->productType->name)}}</small>
                                            <h6>Quantity</h6>                                         
                                            @foreach ($pharmproduct->departments->where('id',2) as $product)
                                            <small class="text-muted ">{{$product->pivot->quantity}}</small>
                                            @endforeach
                                            <small class="text-muted "></small>
                                            <h6>Indication</h6>
                                            <p class="text-muted"> {{ ucfirst($pharmproduct->indication)}}<br></p>

                                            <hr><h5>Distribution Details</h5>
                                            <h6>Received By </h6>
                                            @foreach ($pharmproduct->departments->where('id',2) as $product)
                                            <small class="text-muted">{{\App\Admin::find($product->pivot->received_by)? \App\Admin::find($product->pivot->received_by)->full_name:'null'}}</small>
                                            @endforeach
                                            <h6>Distributed By </h6>
                                            @foreach ($pharmproduct->departments->where('id',2) as $product)
                                            <small class="text-muted">{{\App\Admin::find($product->pivot->distributed_by)?\App\Admin::find($product->pivot->distributed_by)->full_name:'null'}}</small>
                                            @endforeach
                                            <h6>Delivered By </h6>
                                            @foreach ($pharmproduct->departments->where('id',2) as $product)
                                            <small class="text-muted">{{\App\Admin::find($product->pivot->delivered_by)?\App\Admin::find($product->pivot->delivered_by)->full_name:'null'}}</small>
                                            @endforeach
                                            


                                            <hr><h5>Customer Details</h5>
                                            
                                            <h6>Name</h6>
                                            <small class="text-muted ">{{ucfirst($pharmproduct->customer->name)}}</small>
                                            <h6>Tell</h6>
                                            <small class="text-muted ">{{ucfirst($pharmproduct->customer->tell)}}</small>
                                            
                                            <hr><h5>Distribution Periods</h5>
                                            <div  style="margin-bottom: 5px">
                                            <h6 >product distribution period</h6>
                                                <small class="text-muted">
                                                @foreach ($pharmproduct->departments as $product)
                                                Date: <small class="text-muted ">{{$product->pivot->created_at->format('Y-m-d')}}</small>
                                                Time: <small class="text-muted ">{{$product->pivot->created_at->format('H:i:s')}}</small>
                                                @endforeach
                                            </small>
                                            </div>
                                            <h6> product delivery period</h6>
                                            <small class="text-muted ">
                                                @foreach ($pharmproduct->departments as $product)
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
                           @endforeach
                        </tbody>
                      
                        </table>
                    </div>
                     <div class="row">
                        <div class="col-md-9">
                     
                        </div>
                        <div class="col-md-3">
                            <button onclick="return confirm('Please click Ok to confirm submission of sample preparation')"  type="submit" class="btn btn-primary mr-2">Submit</button>
                        </div>
                     </div>
                   
                </div>
              </form> 
            </div>
        </div>
    </div>
</div>
@endsection