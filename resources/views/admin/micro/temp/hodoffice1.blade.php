
                    <div class="card" style="height: 500px">
                        <div class="card-header" style="border-color: #ffc107;" >
                            @foreach($evaluations->groupBy('product_id') as $evaluation)
                            <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                               {{count($evaluation)}} 
                            </label>
                            @endforeach
                            <h3>Pending Report</h3>
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
                                    @foreach($evaluations->sortBy('micro_hod_evaluation') as $evaluation)
                                  <li class="list-group-item" style="padding: 1px;border:1px">
                                    <div class="dd-handle">
                                            
                                        <div class="card-body feeds-widget">
                                        <div class="feed-item">
                                            <a href="{{ route('admin.hod_office.showreport',['id' => $evaluation->id]) }}">
                                                <div class="feeds-left"><i class="ik ik-check-square text-warning"></i></div>
                                                <div class="feeds-body">
                                                    <h4 class="">
                                                          
                                                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                                {{$evaluation->code}}
                                                           </span>
                                                       
                                                          <span href="" class="badge pull-right">
                                                          <p style="font-size: 10px;margin: 2px"></p>
                                                          </span><br>
                                                      
                                                           <span><small class="float-right ">  <strong>Test:</strong>
                                                            @if (count($evaluation->loadAnalyses)>0)
                                                            {{count($evaluation->loadAnalyses)}}mla
                                                            @endif
                                                            @if (count($evaluation->efficacyAnalyses)>0)
                                                            & {{count($evaluation->efficacyAnalyses)}}ea
                                                            @endif
                                                            
                                                          </small>
                                                         </span><br>   
                       
                                                    </h4>
                                                
                                                    <span>
                                                        <span>
                                                       
                                                            <small class="float-right font"><strong>Assigned: </strong>
                                                                {{\App\Admin::find($evaluation->micro_analysed_by)? \App\Admin::find($evaluation->micro_analysed_by)->full_name:'null'}}
                                                            </small><br>
                                                            <small class="float-right font"><strong>Approval 1: </strong>
                                                                {{\App\Admin::find($evaluation->micro_approved_by)? \App\Admin::find($evaluation->micro_approved_by)->full_name:'null'}}
                                                            </small><br>
                                                            <small class="float-right font"><strong>Approval 2: </strong>
                                                                {{\App\Admin::find($evaluation->micro_finalappoved_by)? \App\Admin::find($evaluation->micro_finalappoved_by)->full_name:'null'}}
                                                            </small><br>
                                                            </span>
                                                    </span>
                                                
                                                      <span>
                                                      <small class="float-right font" style="margin-left: 5px"> 
                                                          <strong>Evaluation: </strong> {!! $evaluation->report_evaluation !!}</small>
                                                      </span>
                                                          @if ($evaluation->micro_grade != null )
                                                          <span>
                                                            <small class="float-right font" style="margin: 0.5px"> <strong>Grade: </strong> {!! $evaluation->micro_grade_report !!}</small>
                                                          </span>  
                                                          @endif 
                    
                                                </div>
                                            </a>
                                            <span class="float-right font" style="margin-top:10px">
                                                
                                                 
                                            </span>
                                            <span style="font-size:10px" style="margin-top:10px">
                                                @if (count(App\MicrobialLoadReport::where('product_id',$evaluation->id)->get())>0)
                                                @foreach($evaluation->loadAnalyses as $temp)
                                                @if($evaluation->loadAnalyses->first() == $temp)
                                                {{$temp->pivot->created_at->format('d/m/y')}}
                                                @endif
                                                @endforeach
                                                @else
                                                @foreach($evaluation->efficacyAnalyses as $temp)
                                                @if($evaluation->efficacyAnalyses->first() == $temp)
                                                {{$temp->pivot->created_at->format('d/m/y')}}
                                                @endif
                                                @endforeach                            
                                                @endif


                                            </span>
                                        </div>
                                        </div>
                     
                                    </div>  
                                  </li>
                                  @endforeach
                                </ul>
                          </div>
                    </div>
                    

                    <div class="card" style="height: 500px">
                        <div class="card-header" style="border-color: #ffc107;" >
                            @foreach($final_reports->groupBy('product_id') as $evaluation)
                            <label class="badge badge-warning" style="background-color: #ffc107; margin-right:5px;">
                               {{count($evaluation)}} 
                            </label>
                            @endforeach
                            <h3>Reports to Hod</h3>
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
                       
                          <div class="card-body progress-task" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                                
                                <ul class="list-group" id="myList2">
                                    @foreach($final_reports->sortBy('micro_hod_evaluation') as $evaluation)
                                  <li class="list-group-item" style="padding: 1px;border:1px">
                                    <div class="dd-handle">
                                            
                                        <div class="card-body feeds-widget">
                                        <div class="feed-item">
                                            <a href="{{ route('admin.hod_office.showreport',['id' => $evaluation->id]) }}">
                                                <div class="feeds-left"><i class="ik ik-check-square text-warning"></i></div>
                                                <div class="feeds-body">
                                                    <h4 class="">
                                                          
                                                            <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">
                                                                {{$evaluation->code}}
                                                           </span>
                                                       
                                                          <span href="" class="badge pull-right">
                                                          <p style="font-size: 10px;margin: 2px"></p>
                                                          </span><br>
                                                      
                                                           <span><small class="float-right ">  <strong>Test:</strong>  @if (count($evaluation->loadAnalyses)>0)
                                                            {{count($evaluation->loadAnalyses)}}mla
                                                            @endif
                                                            @if (count($evaluation->efficacyAnalyses)>0)
                                                            & {{count($evaluation->efficacyAnalyses)}}ea
                                                            @endif
                                                          </small>
                                                         </span><br>   
                       
                                                    </h4>
                                                
                                                     <span>
                                                    <small class="float-right font"><strong>Assigned: </strong>
                                                        {{\App\Admin::find($evaluation->micro_analysed_by)? \App\Admin::find($evaluation->micro_analysed_by)->full_name:'null'}}
                                                    </small><br>
                                                    <small class="float-right font"><strong>Approval 1: </strong>
                                                        {{\App\Admin::find($evaluation->micro_approved_by)? \App\Admin::find($evaluation->micro_approved_by)->full_name:'null'}}
                                                    </small><br>
                                                    <small class="float-right font"><strong>Approval 2: </strong>
                                                        {{\App\Admin::find($evaluation->micro_finalapproved_by)? \App\Admin::find($evaluation->micro_finalapproved_by)->full_name:'null'}}
                                                    </small><br>
                                                    </span>
                                                
                                                      <span>
                                                      <small class="float-right font" style="margin-left: 5px"> 
                                                          <strong>Evaluation: </strong> {!! $evaluation->final_hod_micro_evaluation !!}</small>
                                                      </span>
                                                          @if ($evaluation->micro_grade != null )
                                                          <span>
                                                            <small class="float-right font" style="margin: 0.5px"> <strong>Grade: </strong> {!! $evaluation->micro_grade_report !!}</small>
                                                          </span>  
                                                          @endif 
        
                                                </div>
                                            </a>
                                            <span class="float-right font" style="margin-top:10px">
                                                
                                                 
                                            </span>
                                            <span style="font-size:10px" style="margin-top:10px">
                                                @if (count(App\MicrobialLoadReport::where('product_id',$evaluation->id)->get())>0)
                                                @foreach($evaluation->loadAnalyses as $temp)
                                                @if($evaluation->loadAnalyses->first() == $temp)
                                                {{$temp->pivot->created_at->format('d/m/y')}}
                                                @endif
                                                @endforeach
                                                @else
                                                @foreach($evaluation->efficacyAnalyses as $temp)
                                                @if($evaluation->efficacyAnalyses->first() == $temp)
                                                {{$temp->pivot->created_at->format('d/m/y')}}
                                                @endif
                                                @endforeach                            
                                                @endif
                                            </span>
                                        </div>
                                        </div>
                     
                                    </div>
                                      
                                  </li>
        
                                  @endforeach
                                </ul>
                          </div>
                    </div>