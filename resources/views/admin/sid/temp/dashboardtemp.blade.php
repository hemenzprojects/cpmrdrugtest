@if (Auth::guard('admin')->user()->dept_id ==4)
    
    <div class="">
        <div class="">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6> Products at the lab</h6>
                                    <h2> {{count($all_product)}}
                                    </h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-square"></i>  
                                </div>
                            </div>
                            <small class="text-small mt-10 d-block">Total number of distributed products </small>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>Completed Products</h6>
                                    <h2>{{count($all_completedproduct)}}</h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-square"></i>  
                                </div>
                            </div>
                            <small class="text-small mt-10 d-block">Total number of product tested in a year</small>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>Pending Products</h6>
                                    <h2>{{count($all_pendingproduct)}}</h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-square"></i>  
                                </div>
                            </div>
                            <small class="text-small mt-10 d-block">Total number of Pending products in a year</small>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state">
                                    <h6>Failed Products</h6>
                                    <h2>{{count($all_failedproduct)}}</h2>
                                </div>
                                <div class="icon">
                                    <i class="ik ik-message-square"></i>
                                </div>
                            </div>
                            <small class="text-small mt-10 d-block">Total number of failed products in a year</small>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>

        <div class="row">
       
            <div class="col-md-4">
                <div class="card"  >
                    <span class="" style="padding:5px">
                        <input class="form-control" id="listSearch1" type="text" placeholder="Type something to search list items">
                      </span>
                     <div class="card-body" style=" overflow-x: hidden;overflow-y: auto; height:350px; margin-bottom: 30px">
                        
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        
                            <ul class="list-group" id="myList1">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Select product / check to archive</a><hr>
                                    @foreach (App\Product::where('overall_status',2)->get() as $product)
                                    <label class="custom-control custom-checkbox" style="margin-bottom: -12%;     margin-left: -6%;">
                                        <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1">
                                        <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                    <li class="list-group-item dd-item" style="padding: 1px;border:1px" data-id="1">
                                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile{{$product->id}}" role="tab" aria-controls="v-pills-profile" aria-selected="false">

                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff">{{$product->code}}</span>  - {{$product->name}}
                                    </a>
                                    
                                    <hr>
                                   </li>
                               
                                    @endforeach
                        
                            </ul>

                       

                          </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body"  >
                          <ul class="nav justify-content-center" style="margin-top: 10px"> 
                            <h5>FINAL REPORTS</h5>
                          </ul>
                          <div class="tab-content" id="v-pills-tabContent"  style="overflow-x: scroll">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">...</div>
                           
                            @foreach (App\Product::where('overall_status',2)->get() as $final_report)
                            <div class="tab-pane fade" id="v-pills-profile{{$final_report->id}}" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                <table class="table table-striped table-bordered nowrap dataTable" >
                                    <tr>
                                        <th>Product</th>
                                        <th>Microbiology</th>
                                        <th>Pharmacology</th>
                                        <th>Phytochemistry</th>
                                    </tr>
                                   
                                    <tr>
                                                                
                                   
                                    <td class="font"> 
                                        <span style="color: #0e9059">
                                            {{$final_report->code}} 
                                           </span><br>
                                      {{$final_report->name}}  
                                      @if ($final_report->failed_tag)
                                      <sup><span class="badge-info" style="padding: 2px 4px;border-radius: 4px;">#R</span></sup>
                                      @endif
                                      @if($final_report->single_multiple_lab ==1)
                                      <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#S</span></sup>
                                      @endif
                                      @if($final_report->single_multiple_lab ==2)
                                      <sup><span class="badge-success" style="padding: 2px 4px;border-radius: 4px;">#M</span></sup>
                                      @endif
                                      <br>
                                     <strong> Received at: </strong> {{($final_report->created_at)->format('jS, \\ F Y')}}  
                                   </td>
                       
                                    <td class="font">
                                        @if ($final_report->micro_hod_evaluation == 2)
                                        <a target="_blank" href="{{ route('admin.sid.print_microreport',['id' => $final_report->id]) }}">
                                           <button type="button" class="btn btn-outline-success btn-rounded">Print Report</button>
                                       </a><br><br>
                                       <a href="{{route('admin.sid.microreport.pdf',['id' => $final_report->id])}}">
                                           <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                                         </a>
                                        @endif
                                 
                                  </td>
                                    <td class="font">
                                     @if ($final_report->phyto_hod_evaluation == 2)
                                     <a  target="_blank" href="{{route('admin.sid.print_pharmreport',['id' => $final_report->id])}}">
                                       <button type="button" class="btn btn-outline-success btn-rounded">Print Report</button>
                                   </a><br><br>
                                   <a href="{{route('admin.sid.pharmreport.pdf',['id' => $final_report->id])}}">
                                       <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                                     </a>   
                                     @endif
                                          
                                   </td>
                                    <td class="font">
                                     @if ($final_report->pharm_hod_evaluation == 2)
                                     <a  target="_blank" href="{{route('admin.sid.print_phytoreport',['id' => $final_report->id])}}">
                                       <button type="button" class="btn btn-outline-success btn-rounded"></i>Print Report</button>
                                      </a><br><br>
                                      <a href="{{route('admin.sid.phytoreport.pdf',['id' => $final_report->id])}}">
                                          <i style="color: rgb(200, 8, 8)" class="ik ik-download"> download </i>
                                        </a>
                                     @endif
                                       </td>
                        
                                    </tr>
                                  
                        
                                    </table>
                            
                            
                            </div>
                            @endforeach

                          </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    
        
    </div>
 @endif