<div class="card task-board">
    <form action="{{route('admin.pharm.hod_office.evaluate')}}" method="post">
        {{ csrf_field() }}
    <div class="card-header" style="border-color: #ffc107;" >
        @foreach($final_reports->groupBy('product_id') as $approval)
        <label class="badge badge-warning" style="background-color:#ffc107; margin-right:5px;">
           {{count($approval)}} 
        </label>
        @endforeach
        <h3>Final HoD Evaluation</h3>
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
        <div class="dd" data-plugin="nestable">
            <ul class="list-group" id="myList2">
                @foreach($final_reports->sortBy('products.pharm_hod_evaluation') as $approval)

                @if ($hod_anex->user_type_id == 1)
                <a href="{{url('admin/pharm/hod_office/finalreport_show',['id' => $approval->id])}}">
                @else
                <a href="{{url('admin/pharm/hod_office/evaluate_one',['id' => $approval->id])}}">  
                @endif

                <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                <div class="dd-handle">
                    <div class="row align-items-center">
                        <div class="" style="margin-left: 10px">
                            <label class="custom-control custom-checkbox">
                            <input type="checkbox" name="pharm_evaluated_product[]" class="custom-control-input" value="{{$approval->id}}">
                                <span class="custom-control-label"></span>
                            </label>
                        </div>
                        <div class="col-lg-10 col-md-12" >
                            <p  style="margin-bottom: 10px">
                         <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                {{$approval->code}}
                            </span>
                            
                             <span></span>
                            </p>
                              <span> <strong>Test :</strong> 
                              {{\App\PharmTestConducted::find($approval->pharm_testconducted)->name}}
                            </span><br>
                               <span> <strong>Animal Exp :</strong> 
                                @foreach ($approval->animalExperiment->groupBy('id')->first() as $item)
                                {{ucfirst(\App\Admin::find($item->added_by_id)? \App\Admin::find($item->added_by_id)->full_name:'Null')}}
                                @endforeach
                             </span><br>
                             <span> <strong>Report Analyst:</strong>
                                {{ucfirst(\App\Admin::find($approval->pharm_analysed_by)? \App\Admin::find($approval->pharm_analysed_by)->full_name:'Null')}}

                             </span><br>
                             <span><strong>approval:</strong> 
                                {!! $approval->final_hod_pharm_evaluation !!}
                            </span><br>
                            <span><strong>Approval 1:</strong> 
                                {{ucfirst(\App\Admin::find($approval->pharm_approved_by)? \App\Admin::find($approval->pharm_approved_by)->full_name:'Null')}}
                             </span><br>
                             <span><strong>Approval 2:</strong> 
                                {{ucfirst(\App\Admin::find($approval->pharm_finalapproved_by)? \App\Admin::find($approval->pharm_finalapproved_by)->full_name:'Null')}}
                             </span>
                             <br>
                             <span style="font-size:10px" style="margin-top:10px">
                                <strong>Date sent</strong>   {{($approval->pharm_dateapproved ? (\Carbon\Carbon::parse($approval->pharm_dateapproved)->format(' F j,  Y')):'Null')}}
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
    @if ($hod_anex->user_type_id == 1)
    <span style="padding: 10px;color:#007bff">
        <button type="submit" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.completed Reports can not be edited. Thank you')" class="badge badge-success">Complete</button>
        <a href="" class="text-dark" style="float: right; "></a>
     </span>
     @endif
    </form>
</div>

