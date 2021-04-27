<div class="card task-board">
    <div class="card-header" style="border-color: #ffc107;" >
        @foreach($evaluations->groupBy('product_id') as $evaluation)
        <label class="badge badge-warning" style="background-color:#ffc107; margin-right:5px;">
           {{count($evaluation)}} 
        </label>
        @endforeach
        <h3>Report Evaluation</h3>
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
        
    <div class="card-body todo-task" style=" overflow-x: hidden;overflow-y: auto; height:550px; margin-bottom: 30px">
        <div class="dd" data-plugin="nestable" >
            <ul class="list-group" id="myList2">
                @foreach($evaluations->sortBy('products.pharm_hod_evaluation') as $evaluation)
              
                <a href="{{url('admin/pharm/hod_office/evaluate_one',['id' => $evaluation->id])}}">
                <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                <div class="dd-handle">
                    <div class="row align-items-center">

                        <div class="col-lg-10 col-md-12" >
                            <p  style="margin-bottom: 10px">
                         <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                {{$evaluation->code}}
                            </span>
                            
                             <span></span>
                            </p>
                              <span> <strong>Test :</strong> 
                              {{\App\PharmTestConducted::find($evaluation->pharm_testconducted)->name}}
                            </span><br>
                               <span> <strong>Animal Exp :</strong> 
                                @foreach ($evaluation->animalExperiment->groupBy('id')->first() as $item)
                                {{\App\Admin::find($item->added_by_id)->full_name}}
                                @endforeach
                             </span><br>
                             <span> <strong>Report Analyst:</strong>
                                {{\App\Admin::find($evaluation->pharm_analysed_by)->full_name}}
                             </span><br>
                             <span><strong>Evaluation:</strong> 
                                {!! $evaluation->hod_pharm_evaluation !!}
                            </span><br>
                            <span><strong>Approved By:</strong> 
                                {{ucfirst(\App\Admin::find($evaluation->pharm_appoved_by)? \App\Admin::find($evaluation->pharm_appoved_by)->full_name:'Null')}}
                             </span><br>
                             <span style="font-size:10px" style="margin-top:10px">
                                <strong>Date sent</strong>   {{($evaluation->pharm_datecompleted ? \Carbon\Carbon::parse($evaluation->pharm_datecompleted)->format(' F j,  Y') :'Null')}}
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

