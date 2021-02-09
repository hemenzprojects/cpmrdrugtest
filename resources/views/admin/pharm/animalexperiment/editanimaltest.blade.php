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
                  <input class="form-control" id="listSearch1" type="text" placeholder="Type something to search list items">
                </span>
                  
              <div class="card-body todo-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                  <div class="dd" data-plugin="nestable" >
                      <ul class="list-group" id="myList1">
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
                                      <sup style="font-size: 1px">
                                          {{$animalexp->productType->code}}{{$animalexp->id}}{{$animalexp->created_at->format('y')}}
                                       </sup> 
              
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
          <form action="{{route('admin.pharm.animalexperiment.send_animaltest')}}" method="post">
              {{ csrf_field() }} 
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
                                              <sup style="font-size: 1px">
                                                  {{$inprogress->productType->code}}{{$inprogress->id}}{{$inprogress->created_at->format('y')}}
                                              </sup> 
                                              </p> 
                                              <span class="badge  pull-right"> 
                                              <strong>Test :</strong> 
                                                  {{\App\PharmTestConducted::find($inprogress->pharm_testconducted)->name}}
                                              </span>

                                              <span class="badge  pull-right">
                                              <strong>Analysed By :</strong> 
                                                  
                                                  {{-- @foreach ($inprogress->animalExperiment->groupBy('id')->first() as $item)
                                                  {{\App\Admin::find($item->added_by_id)->full_name}}
                                                  @endforeach --}}
                                                  
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
                                                 <a href="{{route('admin.pharm.animalexperiment.editanimaltest',['id' => $inprogress])}}">
                                                  <i class="ik ik-edit-2">Edit</i>
                                                  </a>
                                                  
                                          </div>
                                          <br> 
                                              @endif
                                          
                                      </div>
                                      <label class="custom-control custom-checkbox">
                                      <input type="checkbox" id="" name="product_id[]" class="custom-control-input method_applied" value="{{$inprogress->id}}">
                                          <span class="custom-control-label"></span>
                                      </label>
                                  </div>
                                  
                              </div>
                              </li>
                              </a>  
                              
                              @endforeach
                          </ul>
                      </div>
                         
                  </div>
                  <span style="padding: 10px;color:#007bff">
                      <button type="submit" onclick="return confirm('Please make sure selected products completes experiment proccess before sending. Thank you')" class="badge badge-success">Send</button>
                      <a href="" class="text-dark" style="float: right; ">View all</a>
                  </span>
              </div>
          </form>
         
      </div>
     
      <div class="col-md-4">
          <div class="card task-board">
              <div class="card-header" style="border-color: #26c281;" >
                  @foreach($completed_reports->groupBy('product_id') as $completed)
                  <label class="badge badge-warning" style="background-color:#26c281; margin-right:5px;">
                     {{count($completed)}} 
                  </label>
                  @endforeach
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
                                        <span> 
                                            <sup style="font-size: 1px">
                                              {{$completed->productType->code}}{{$completed->id}}{{$completed->created_at->format('y')}}
                                       </sup> 
                                      </span>
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
              <a href="{{route('admin.pharm.animalexperimentation.testconducted')}}" class="text-dark" style="float: right; ">View all</a>
              </span>
              </div>
          
      </div>
  </div>


        <div class="card">
            <div class="card-body">

            <form action="{{url('admin/pharm/animalexperiment/update',['id' =>$editexperiment->id ])}}" method="post">
                {{ csrf_field() }} 
            
                        {{-- <ul class="nav justify-content-center" style="margin-top: 10px"> 
                            <h5> </h5> -
                        <h6> {{\App\PharmTestConducted::find($editexperiment->pharm_testconducted)->name}}</h6>                                          
                        </ul>
                         --}}
                         <div class="row">
                                   
                            <div class="col-sm-4">
                              <label for="exampleSelectGender">Product</label>
                              <div class="input-group mb-2 mr-sm-2">
                                  <div class="input-group-prepend">
                                      <div class="input-group-text"></div>
                                  </div>
                                 
                                 
                                    <select required name="product_id" id="pharmproduct_id"  style="" class="form-control select2" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                      <option value="">Select Product</option>
                                      <option value="{{$editexperiment->id}}" {{$editexperiment->id == $editexperiment->id? "selected":""}}>{{$editexperiment->productType->code}}|{{$editexperiment->id}}|{{$editexperiment->created_at->format('y')}}</option>
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
                  
                    {{-- <input type="hidden" name="pharm_testconducted" value="{{$editexperiment->pharm_testconducted}}"> --}}
                        <ul class="nav justify-content-center" style="margin: 20px"> 
                            <h6 ></h6>
                        </ul>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm"  id="dynamic_field" style="scrollX: true">
                                <thead>
                                    <tr>
                                    
                                <th>Animal Model
                                </th>
                                <th>Weight</th>
                                <th>Dosage</th>
                                <th>Route of Administration </th>
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
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($editexperiment->animalExperiment as $product)

                                    <tr>
                                        <td class="font">                              
                                            <input type="hidden" name="oldproduct_id" value="{{$editexperiment->id}}">
                                                <div class="form-group">
                                                    <select class="form-control select2" name="animalmodel[]" style="width:170px;">
                                                        @foreach (\App\PharmAnimalModel::all() as $animalmodel)  
                                                        <option  value="{{$animalmodel->id}}" {{$product->animal_model == $animalmodel->id? "selected":""}}>
                                                            {{$animalmodel->name}}
                                                        </option>  
                                                        @endforeach 
                                                    </select>   
                                                </div>
                                            
                                        </td>
                                        <td class="font">    
                                        
                                            <input class="form-control" type="text" name="weight[]" value="{{$product->weight}}" style="width:70px"><br>
                                        
                                        </td>
                                        <td class="font">
                                        
                                            <input class="form-control" type="text" name="dosage[]" value="{{$product->dosage}}"><br>
                                    
                                        </td>

                                        <td class="font"> 
                                        
                                            <div class="form-group"> 
                                                <select class="form-control select2" name="method_of_admin[]" style="width:170px">
                                                    <option value="{{$product->method}}">{{$product->animal_method}}</option>                                                     
                                                    <option value="1">Oral</option><option value="2">Subcutanious</option>
                                                    <option value="3">Intradermal</option>
                                                    <option value="4">Intra Veinous</option>
                                                    <option value="5">Applied Topical</option>
                                                    <option value="6">Applied Topical & Intrademal</option>
                                                </select>
                                                </div>
                                        
                                        </td>

                                        <td class="font">
                                            
                                        <input class="form-control" type="text" name="time_administration[]" value="{{$product->time_administration}}"><br>
                                
                                        </td>

                                        <td class="font" >
                                                                                                                    
                                        <div class="form-group">
                                            <ul><li style="font-size:10p"> @foreach ($product['toxicity'] as $itm) 
                                                {{$itm}}  
                                              @endforeach 
                                            </li></ul> 
                                        <select class="form-control select2 toxicity1" name="toxicity[{{$loop->index}}][]" multiple style="width:170px">
                                            <option selected>
                                                @foreach ($product['toxicity'] as $itm) 
                                                {{$itm}}  
                                              @endforeach 
                                        </option>
                                        @foreach (\App\PharmToxicity::all() as $toxicity)  
                                        <option  value="{{$toxicity->name}}" {{$product->toxicity == $toxicity->id? "selected":""}}>
                                            {{$toxicity->name}}
                                        </option>  
                                        @endforeach                                                
                                        </select>
                                        </div>
                                    
                                        </td>

                                        <td class="font">
                                            <div class="form-group"> 
                                            <select class="form-control select2" name="death[]" style="width:70px">
                                                <option value="{{$product->death}}">{{$product->no_death}}</option>                
                                                <option value="1"> Yes </option>
                                                <option value="2"> No </option>

                                            </select>
                                            </div>
                                        </td> 


                                        <td class="font">
                                        <input class="form-control" type="text" name="time_death[]" value="{{$product->time_death}}"><br>
                                    

                                    </td>

                                        <td class="font">
                                            <div class="form-group"> 
                                                <select class="form-control select2" name="sex[]" style="width:100px">
                                                    <option value="{{$product->sex}}">{{$product->animal_sex}}</option>                                                     
                                                    <option value="1"> Male </option>
                                                    <option value="2"> Female </option>
                                                </select>
                                            </div>                        
                                        </td>
                                
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-4" style="margin: 10px">
                                <label for=""> Total Number of Days</label>
                                @foreach ($editexperiment->animalExperiment as $product)
                                @if($editexperiment->animalExperiment->first() == $product)
                                <input required class="form-control" type="text" name="total_days" value="{{$product->total_days}}">
                                @endif
                                @endforeach
                            </div>
                        
                            <div class="col-md-4" style="margin: 10px">
                                <label for=""> Group</label>
                                @foreach ($editexperiment->animalExperiment as $product)
                                @if($editexperiment->animalExperiment->first() == $product)
                            <input type="text" class="form-control" name="group" value="{{$product->group}}">
                            @endif
                            @endforeach
                            </div>

                        </div>
        
                <div class="modal-footer">
                    <a href="{{route('admin.pharm.animalexperimentation.maketest')}}"><span class="btn btn-secondary">New Test</span></a>    
                            <button class="btn btn-primary">Save changes</button>
                </div>
        </form>
        </div>
        </div>

</div>
@endsection


