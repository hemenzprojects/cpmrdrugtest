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
                    @foreach($animalexps->groupBy('product_id') as $animalexp)
                    <label class="badge badge-warning" style="background-color:red; margin-right:5px;">
                       {{count($animalexp)}} 
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
                    <input class="form-control" id="listSearch2" type="text" placeholder="Type something to search list items">
                  </span>
                    
                <div class="card-body todo-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                    <div class="dd" data-plugin="nestable" >
                        <ul class="list-group" id="myList2">
                            @foreach($animalexps as $animalexp)
                          <a data-toggle="modal"  data-placement="auto" data-target="#demoModal{{$animalexp->id}}" title="View Product" href="">

                            <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                            <div class="dd-handle">
                                <div class="row align-items-center">
                                    <div class="col-lg-12 col-md-12">
                                        <p>
                                        <span href="" class="badge  pull-right" style="background-color: red; color:#fff">
                                        {{$animalexp->productType->code}}|{{$animalexp->id}}|{{$animalexp->created_at->format('y')}}
                                        </span>
                                          {{-- <span>{{ucfirst($animalexp->name)}}</span> --}}
                                        </p>
                                       
                                    </div> 
                                    <a onclick="return confirm('Are you sure of deleting record?')" href="{{url('admin/pharm/animalexperiment/reject',['id' =>$animalexp->id ])}}">
                                        <div class="col-md-2 col-md-12">
                                            <i class="ik ik-trash-2"></i>
                                        </div>
                                     </a>                                                
                                    
                                </div>  
                                 
                            </div>
                            </li>
                        </a>  
                            <div class="modal fade" id="demoModal{{$animalexp->id}}" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel">Sample prepation details Details </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="card-body"> 
                                    
                                            <h6> Product Name </h6>
                                            <small class="text-muted ">{{$animalexp->productType->code}}|{{$animalexp->id}}|{{$animalexp->created_at->format('y')}} </small>
                                            <h6>Product Type </h6>
                                            <small class="text-muted ">{{ucfirst($animalexp->productType->name)}}</small> 
                                            <small class="text-muted "></small>
                                            <h6>Indication</h6>
                                            <p class="text-muted"> {{ ucfirst($animalexp->indication)}}<br></p>

                                            @foreach ($animalexp->samplePreparation as $product)
                                            <h6>Distributor </h6>
                                            <small class="text-muted">{{\App\Admin::find($product->distributed_by)? \App\Admin::find($product->distributed_by)->full_name:'null'}}</small>
                                            <h6>Delivery Officer </h6>
                                            <small class="text-muted">{{\App\Admin::find($product->delivered_by)?\App\Admin::find($product->delivered_by)->full_name:'null'}}</small>
                                            <h6>Received By </h6>
                                            <small class="text-muted">{{\App\Admin::find($product->received_by)?\App\Admin::find($product->received_by)->full_name:'null'}}</small>
                                          
                                            @endforeach
                                            <hr><h5>Distribution Periods</h5>
                                            <div  style="margin-bottom: 5px">
                                            <p>
                                                <h6 >Distribution Period</h6>
                                                @foreach ($animalexp->samplePreparation as $product)
                                                Date: <small class="text-muted ">{{$product->created_at->format('Y-m-d')}}</small>
                                                Time: <small class="text-muted ">{{$product->created_at->format('H:i:s')}}</small>
                                                @endforeach
                                            </p>
                                            <p>
                                                <h6 >Date Analysed</h6>

                                                @foreach ($animalexp->samplePreparation as $product)
                                                Date: <small class="text-muted ">{{$product->updated_at->format('Y-m-d')}}</small>
                                                Time: <small class="text-muted ">{{$product->updated_at->format('H:i:s')}}</small>
                                                @endforeach
                                            </p>
                                            </div>
                                        
                                            <hr><h5>Preparation Details</h5>
                                            
                                            @foreach ($animalexp->samplePreparation as $product)
                                            <p><strong>Remarks :</strong>  {{\App\PharmTestConducted::find($product->pharm_testconducted_id)->name}}</p>
                                            <p><strong>Volume/Mass/Weight :</strong> {{$product->measurement}} </p>
                                            <p><strong>Dosage :</strong> {{$product->dosage}} </p>
                                            <p><strong>Yield :</strong> {{$product->yield}} </p>
                                            <p><strong>Remarks :</strong> {{$product->remarks}} </p>

                                            @endforeach
                                           
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
                           <a title="View Product" href="">

                            <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                            <div class="dd-handle">
                                <div class="row">
                                    <div class="col-lg-10 col-md-12">
                                           <p>
                                            <span href="" class="badge  pull-right" style="background-color: #ffc107">
                                            {{$inprogress->productType->code}}|{{$inprogress->id}}|{{$inprogress->created_at->format('y')}}
                                            </span>
                                              {{-- <span>{{ucfirst($inprogress->name)}}</span> --}}
                                            </p> 
                                            <span class="badge  pull-right"> 
                                            <strong>Test :</strong> 
                                                {{\App\PharmTestConducted::find($inprogress->pharm_testconducted)->name}}
                                            </span>

                                            <span class="badge  pull-right">
                                            <strong>Analysed By :</strong> 
                                                 
                                                  @foreach ($inprogress->animalExperiment->groupBy('id')->first() as $item)
                                                  {{\App\Admin::find($item->added_by_id)->full_name}}
                                                  @endforeach
                                                
                                            </span>
                                            <span class="badge  pull-right"
                                            ><strong>Evaluation:</strong> 
                                                {!! $inprogress->pharm_report_evaluation !!}
                                            </span><br>
                                            @if ($inprogress->pharm_hod_evaluation ==null)
                                            <div class="float-right">
                                                <a onclick="return confirm('Are you sure of deleting record?')" href="{{url('admin/pharm/animalexperiment/delete',['id' =>$inprogress->id ])}}">
                                                  
                                                  <i style="color: rgb(200, 8, 8)" class="ik ik-trash-2"> delete </i>
                                                </a>
                                               
                                                <span> | </span>
                                                <a data-toggle="modal"  data-placement="auto" data-target="#fullwindowModal{{$inprogress->id}}" title="View Product" href="">
                                                <i class="ik ik-edit-2">Edit</i>
                                                  </a>
                                           </div>
                                           <br> 
                                            @endif
                                          
                                      </div>
                                   
                                  </div>
                                
                            </div>
                            </li>
                            </a>  
                                <div class="modal fade full-window-modal" id="fullwindowModal{{$inprogress->id}}" tabindex="-1" role="dialog" aria-labelledby="fullwindowModalLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                   
                                        <ul class="nav justify-content-center" style="margin: 20px"> 
                                            <h5>Animal Experiment Details</h5>
                                          </ul>
                                        {{-- <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div> --}}
                                        <div class="modal-body" style="">
                                         <form action="{{url('admin/pharm/animalexperiment/update',['id' =>$inprogress->id ])}}" method="post">
                                                {{ csrf_field() }} 
                                            <div class="card-body" style="margin-left: 10%;margin-right: 10%;background-color: #d3d3d394; padding:3"> 
                                                <div class="row" style="background-color:; padding:3%">
                                                    <div class="col-md-4 col-12">
                                                        <h6> Product Name </h6>
                                                        <small class="text-muted ">{{$inprogress->productType->code}}|{{$inprogress->id}}|{{$inprogress->created_at->format('y')}} |   {{ucfirst($inprogress->name)}}</small>
                                                        <h6>Product Type </h6>
                                                        <small class="text-muted ">{{ucfirst($inprogress->productType->name)}}</small> 
                                                        <input type="hidden" name="" id="{{$inprogress->productType->method_applied}}" >
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
                                                    
                                                 
                                                 <div class="card" style="background-color: #d3d3d394">

                                                        <ul class="nav justify-content-center" style="margin-top: 10px"> 
                                                        <h6> {{\App\PharmTestConducted::find($inprogress->pharm_testconducted)->name}}</h6>                                          
                                                        </ul>
                                                        
                                                    <input type="hidden" name="pharm_testconducted" value="{{$inprogress->pharm_testconducted}}">
                                                         <ul class="nav justify-content-center" style="margin: 20px"> 
                                                            <h6 ></h6>
                                                          </ul>
                                                        <div class="table-responsive" style="overflow-x: scroll;">
                                                            <table class="table table-inverse">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Animal Model</th>
                                                                        <th>Weight</th>
                                                                        <th>Dosage</th>
                                                                        <th>Root of Administration </th>
                                                                        <th>Time of Administration</th>
                                                                        <th>Signs of Toxicity</th>
                                                                        <th>Death</th>
                                                                        <th>Time of Death</th>
                                                                        <th> Sex </th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>

                                                                        <td class="font">
                                                                           
                                                                            <input type="hidden" name="product_id" value="{{$inprogress->id}}">
                                                                                @foreach ($inprogress->animalExperiment as $product)

                                                                                <div class="form-group">
                                                                                    <select class="form-control select2" name="animalmodel[]" style="width:170px;">
                                                                                        @foreach (\App\PharmAnimalModel::all() as $animalmodel)  
                                                                                        <option  value="{{$animalmodel->id}}" {{$product->animal_model == $animalmodel->id? "selected":""}}>
                                                                                            {{$animalmodel->name}}
                                                                                        </option>  
                                                                                        @endforeach 
                                                                                    </select>

                                                                                    
                                                                                </div>
                                                                                @endforeach                                                   
                                                                          
                                                                        </td>
                                                                        <td class="font">
                                                                              
                                                                            @foreach ($inprogress->animalExperiment as $product)
                                                                            <input class="form-control" type="text" name="weight[]" value="{{$product->weight}}" style="width:70px"><br>
            
                                                                            @endforeach
                                                                        </td>
                                                                        <td class="font">
                                                

                                                                            @foreach ($inprogress->animalExperiment as $product)
                                                                            <input class="form-control" type="text" name="dosage[]" value="{{$product->dosage}}"><br>
                        
                                                                            @endforeach
            
                                                                        </td>

                                                                        <td class="font"> 
                                                                            @foreach ($inprogress->animalExperiment as $product)
                                                                             <div class="form-group"> 
                                                                                 <select class="form-control select2" name="method_of_admin[]" style="width:170px">
                                                                                     <option value="{{$product->method}}">{{$product->animal_method}}</option>                                                     
                                                                                     <option value="1">Intravenous </option>
                                                                                     <option value="2">Intramuscular </option>
                         
                             
                                                                                 </select>
                                                                                 </div>
                                                                               
                                                                             @endforeach
                                                                         </td>

                                                                         <td class="font">
                                                                            @foreach ($inprogress->animalExperiment as $product)
                                                                           <input class="form-control" type="text" name="time_administration[]" value="{{$product->time_administration}}"><br>
                       
                                                                           @endforeach
            
                                                                       </td>

                                                                        <td class="font" >
                    
                                                                            @foreach ($inprogress->animalExperiment as $product)  
                                                                                                                    
                                                                        <div class="form-group"> 
                                                                        <select class="form-control select2" name="toxicity[]" style="width:170px">
                                                                        @foreach (\App\PharmToxicity::all() as $toxicity)  
                                                                        <option  value="{{$toxicity->id}}" {{$product->toxicity == $toxicity->id? "selected":""}}>
                                                                            {{$toxicity->name}}
                                                                        </option>  
                                                                        @endforeach                                                
                                                                        </select>
                                                                        </div>
                                                                        @endforeach  
                                                                        </td>

                                                                        <td class="font">
                                                                            @foreach ($inprogress->animalExperiment as $product)
                                                                            <div class="form-group"> 
                                                                            <select class="form-control select2" name="death[]" style="width:70px">
                                                                                <option value="{{$product->death}}">{{$product->no_death}}</option>                
                                                                                <option value="1"> Yes </option>
                                                                                <option value="2"> No </option>
                        
                                                                            </select>
                                                                            </div>
                                                                 
                                                                            @endforeach
                                                                        </td> 
                          

                                                                        <td class="font">
                                                                            @foreach ($inprogress->animalExperiment as $product)
                                                                           <input class="form-control" type="text" name="time_death[]" value="{{$product->time_death}}"><br>
                       
                                                                           @endforeach
            
                                                                       </td>

                                                                        <td class="font">
                                                                            @foreach ($inprogress->animalExperiment as $product)
                                                                            <div class="form-group"> 
                                                                                <select class="form-control select2" name="sex[]" style="width:100px">
                                                                                    <option value="{{$product->sex}}">{{$product->animal_sex}}</option>                                                     
                                                                                    <option value="1"> Male </option>
                                                                                    <option value="2"> Female </option>
                        
                            
                                                                                </select>
                                                                            </div>
                                                                              
                                                                            @endforeach
                                                                        </td>
                                                                 
                                                                    </tr>
                                                                  
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        
             
                                                        <div class="row" style="margin-top:20px">
                                                            <div class="col-md-4" style="margin: 10px">
                                                                <label for=""> Total Number of Days</label>
                                                                @foreach ($inprogress->animalExperiment->groupBy('id')->first() as $product)
                                                                <input required class="form-control" type="text" name="total_days" value="{{$product->total_days}}">
                                                                 @endforeach
                                                            </div>
                                                            <div class="col-md-4" style="margin: 10px">
                                                                <label for=""> Group</label>

                                                            <input type="text" class="form-control" name="group" value="{{$product->group}}">
                                                            </div>

                                                        </div>
                                                 </div>
                                                
                                          </div>
                                           <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                          </div>
                                        </form>
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
                    @foreach($completed_reports->groupBy('product_id') as $completed)
                    <label class="badge badge-warning" style="background-color:#26c281; margin-right:5px;">
                       {{count($completed)}} 
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
                    <input class="form-control" id="listSearch3" type="text" placeholder="Type something to search list items">
                  </span>
                    
                <div class="card-body completed-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                    <div class="dd" data-plugin="nestable" >
                        <ul class="list-group" id="myList3">
                            @foreach($completed_reports as $completed)
                          <a data-toggle="modal"  data-placement="auto" data-target="#fullwindowModal{{$completed->id}}" title="View Product" href="">

                            <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                            <div class="dd-handle">
                                <div class="row align-items-center">
                                    <div class="col-lg-10 col-md-12">
                                        <p>
                                        <span href="" class="badge  pull-right" style="background-color: #26c281">
                                        {{$completed->productType->code}}|{{$completed->id}}|{{$completed->created_at->format('y')}}
                                        </span>
                                          <span>{{ucfirst($completed->name)}}</span>
                                        </p>
                                        <span> <strong>Test :</strong> 
                                            {{\App\PharmTestConducted::find($completed->pharm_testconducted)->name}}
                                          </span><br>
                                          <span> <strong>Exp Analysed By :</strong> 
                                             
                                              @foreach ($completed->animalExperiment->groupBy('id')->first() as $item)
                                              {{\App\Admin::find($item->added_by_id)->full_name}}
                                              @endforeach
                                             
                                           </span>
                                    </div> 
                                                                                       
                                    
                                </div>  
                                 
                            </div>
                            </li>
                        </a>  
                            
                            @endforeach
                        </ul>
                    </div>

                </div>
                <span style="padding: 10px;color:#007bff">
                 <a href="" class="text-dark" style="float: right; ">View all</a>
                </span>
                </div>
            
        </div>

    </div>

</select>
 <form action="{{route('admin.pharm.animalexperiment.store')}}" method="post">
    {{ csrf_field() }}
    <div class="card">
        <div class="card-body">
            <ul class="nav justify-content-center" style="margin-top: 10px"> 
                <h5>Animal Experimentation Form</h5><hr>
            </ul><br>
            <div class="row">
                                   
                  <div class="col-sm-4">
                    <label for="exampleSelectGender">Product</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"></div>
                        </div>
                        {{-- need to check  --}}
                         <select required name="product_id" id="pharmproduct_id" style="" class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
                            <option value="">Select Product</option>
                            @foreach($animalexps as $animalexp)
                            @foreach($animalexp->pharmsamplePreparation as $item)                                                                              
                            <option spvolume="{{$item->pivot->measurement}}"  product_ma="{{\App\Product::find($item->pivot->product_id)->productType->method_applied}}"  value="{{$item->pivot->product_id}}" {{$item->pivot->product_id== old('product')? "selected":""}}>{{\App\Product::find($item->pivot->product_id)->productType->code}}|{{\App\Product::find($item->pivot->product_id)->id}}|{{\App\Product::find($item->pivot->product_id)->created_at->format('y')}}</option>
                            @endforeach
                            @endforeach
                         </select>

                      </div>
                      {{-- this is to get value from samplePreparation table and input in Animal exp form  --}}

                    <div>
                        @error('product_id')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                    </div>
                  </div>            
               
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="exampleSelectGender">Testconducted</label>
                        <select class="form-control" id="pharmtest" name="pharm_testconducted">
                            <option  value="1">Acute Toxicity Test</option>
                            <option value="2">Dermal  Toxicity Test</option>
                        </select>
                    </div>
               
               </div>
               <div class="col-sm-4">
                    @foreach( $errors->all() as $error)
                    <li style="color: red">{{$error}}</li>
                    @endforeach
               </div>
                    
            </div><br>
        
            <div class="dt-responsive" style="overflow-x:auto;">
                <ul class="nav justify-content-center" style="margin-top: 10px"> 
                    <h6></h6><hr>
                </ul><br>
                <table class="table table-striped table-bordered table-sm"  id="dynamic_field" style="scrollX: true">
                    
                    <thead>
                    <tr>
                        <th>Animal Model
                        </th>
                        <th>Weight</th>
                        <th>Dosage</th>
                        <th>Root of Administration </th>
                        <th>Time of Administration</th>
                        <th>Signs of Toxicity<br>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-12">
                                      <label class="custom-control custom-checkbox">
                                          <input type="checkbox" id="toxicity1" class="custom-control-input" value="1"><span></span>
                                      <span class="custom-control-label">All Nill</span>
                                  </label>
                            </div> 
                        </th>
                        <th>Death</th>
                        <th>Time of Death</th>
                        <th> Sex<br>
                           <div class="row" style="margin-top: 10px">
                              <div class="col-md-6">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" id="male_sex" class="custom-control-input" value="1"><span></span>
                                    <span class="custom-control-label">M</span>
                                </label>
                                </div> 
                                <div class="col-md-6">
                                        <label class="custom-control custom-checkbox">
                                      <input type="checkbox" id="female_sex" class="custom-control-input" value="2"> 
                                        <span class="custom-control-label">F</span>
                                    </label>
                                </div>
                           </div>
                        </th>

                        <th><button type="button" name="add" id="add" class="btn btn-success">Add</button>
                        </th>
                    </tr>
                    </thead>

                </table>
             
            </div>
    </div>

    <div class="card">
        
    <div class="row" style="margin: 2%">
        <div class="col-md-9">
            <div class="row">
            <div class="col-md-6">
                <label for=""></label>
                <input type="number" required placeholder=" Total number of days observed" class="form-control" name="total_days" value="">   
            </div>

            <div class="col-md-4">
                <label for=""></label>
                <input type="text" required placeholder="Group" class="form-control" name="group" value="">   
            </div>
        </div>
        </div>
        <div class="col-md-3">   
            <button type="submit" onclick="return confirm('Great work done. Please ensure that all input fields are correct as compare to the experiment made. If set click Ok else cancel to continue report process. Thank you')" class="btn btn-primary mb-2"> Complete Experiment</button>
        </div>
    </div>
    </div>
</div> 
</form>
</div>

<div class="col-md-6"> 
    <div class="container">
       
    </div>
</div>
@endsection



