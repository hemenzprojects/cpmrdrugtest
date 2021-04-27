
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
                                          <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                              {{$animalexp->code}}
                                          </span>
                                    
              
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
                                          <small class="text-muted ">
                                              <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                  {{$animalexp->code}}
                                              </span> </small>
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
                                          <p><strong>Test Conducted :</strong>  {{\App\PharmTestConducted::find($product->pharm_testconducted_id)->name}}</p>
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
                                              <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                  {{$inprogress->code}}
                                              </span> 
                                              </p> 
                                              <span class="badge  pull-right"> 
                                              <strong>Test :</strong> 
                                                  {{\App\PharmTestConducted::find($inprogress->pharm_testconducted)->name}}
                                              </span><br>

                                              <span class="badge  pull-right">
                                              <strong>Analysed By :</strong> 
                                                  
                                                  @foreach ($inprogress->animalExperiment->groupBy('id')->first() as $item)
                                                  {{\App\Admin::find($item->added_by_id)->full_name}}
                                                  @endforeach
                                                  
                                              </span><br>
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
                                          <span style="font-size:9px">
                                            <strong>Date :</strong> 
                                            @foreach ($inprogress->animalExperiment->groupBy('id')->first() as $item)
                                            {{$item->created_at->format('d/m/y')}}
                                            @endforeach
                                        </span>
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
                          <a href="{{url('admin/pharm/completedexperiment/show',['id' => $completed->id])}}">

                          <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                          <div class="dd-handle">
                              <div class="row align-items-center">
                                  <div class="col-lg-10 col-md-12">
                                      <p>
                                          <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                              {{$completed->code}}
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
                              <span style="font-size:9px">
                                <strong>Date :</strong> 
                                @foreach ($completed->animalExperiment->groupBy('id')->first() as $item)
                                {{$item->created_at->format('d/m/y')}}
                                @endforeach
                            </span>
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