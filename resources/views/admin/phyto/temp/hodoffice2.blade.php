<div class="card">
    <form action="{{route('admin.phyto.hod_office.evaluate')}}" method="post">
        {{ csrf_field() }}
    <div class="card-header" style="border-color: #ffc107;" >
        @foreach($evaluations->groupBy('product_id') as $evaluation)
        <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
           {{count($evaluation)}} 
        </label>
        @endforeach
        <h3>Pending Reports</h3>
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
   
      <div class="card-body progress-task" style=" overflow-x: hidden;overflow-y: auto; height:800px; margin-bottom: 30px">
        
            <ul class="list-group" id="myList3">
                @foreach($evaluations->sortBy('phyto_process_status') as $evaluation)
              <li class="list-group-item" style="padding: 1px;border:1px">
                <div class="dd-handle">
                        
                    <div class="card-body feeds-widget">
                    <div class="feed-item">
                        <a href="{{url('admin/phyto/hod_office/evaluate_one',['id' => $evaluation->id])}}">
                            <div class="feeds-left">
                                <div class="">
                                    <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="evaluated_product[]" class="custom-control-input" value="{{$evaluation->id}}">
                                        <span class="custom-control-label"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="feeds-body">
                                <h4 class="">
                                      
                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                            {{$evaluation->code}}
                                       </span>
                                <br>   
   
                                </h4>
                                <span class=" font">
                                                       
                                    <small class="float-right font"><strong>Assigned: </strong>
                                        <span style="font-size: 10px; margin:2px">        
                                        {{\App\Admin::find($evaluation->phyto_analysed_by)? \App\Admin::find($evaluation->phyto_analysed_by)->full_name:' null '}}
                                        </span>
                                    </small><br>
                                    <small class="float-right font"><strong>Approval 1: </strong>
                                        <span style="font-size: 10px;margin:2px"> 
                                        {{\App\Admin::find($evaluation->phyto_approved_by)? \App\Admin::find($evaluation->phyto_approved_by)->full_name:' null '}}
                                        </span>
                                    </small><br>
                                    <small class="float-right font"><strong>Approval 2: </strong>
                                        <span style="font-size: 10px;margin:2px"> 
                                        {{\App\Admin::find($evaluation->phyto_finalapproved_by)? \App\Admin::find($evaluation->phyto_finalapproved_by)->full_name:' null '}}
                                        </span>
                                    </small>
                                 </span><br><br>
                            
                                
                                   <span>
                                     <strong>Evaluation:</strong> 
                                    {!! $evaluation->phyto_report_evaluation !!}
                                   </span><br>
                                   <span><strong>Created at:</strong> 
                                    <sup style="font-size: 10px"> 
                                     @foreach($evaluation->organolipticReport as $temp)
                                     @if($evaluation->organolipticReport->first() == $temp)
                                     {{$temp->created_at->format('d/m/y')}}
                                     @endif
                                     @endforeach
                                    </sup> 

                            </div>
                        </a>
                    </div>
                    </div>
 
                </div>
                  
              </li>

              @endforeach
            </ul>
         
      </div>
      <span style="padding: 10px;color:#007bff">
        <button type="submit" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.completed Reports can not be edited. Thank you')" class="badge badge-success">Complete</button>
        <a href="" class="text-dark" style="float: right; "></a>
     </span>
    </form>
</div>