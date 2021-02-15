@extends('admin.layout.main')

@section('content')


<div class="container-fluid">
  
    <div class="card" style="padding: 15px">
           <div class="text-center"> 
           <img src="{{asset('admin/img/logo.jpg')}}" class="" width="11%">
           <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
           <p class="card-subtitle">Phytochemistry Department</p>
          </div>

          <div class="card">
                <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> PRODUCT DETAILS</strong></h4>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="font"> <strong>Name of Product:</strong></td>
                                <td class="font">
                                    {{$phytoshowreport->productType->code}}|{{$phytoshowreport->id}}|{{$phytoshowreport->created_at->format('y')}} |   {{ucfirst($phytoshowreport->name)}}
                                </td>
                            </tr>
                            <tr>
                            <td class="font"><strong>Date Recievied: </strong></td>
                            <td class="font">
                                
                                @foreach (\App\ProductDept::where('product_id',$phytoshowreport->id)->where('dept_id',3)->get() as $item)
                                {{$item->received_at}}   
                                @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="font"><strong>Date Analyzed:</strong></td> 
                                <td class="font">{{$phytoshowreport->phyto_dateanalysed}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

    
                <div class="col-md-10">
                    <div class="row">
                        
                        <div class="col-lg-10 col-md-10"><h6>A. {{\App\PhytoTestConducted::find(1)->name}}</h6></div> 
                            @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation <2)
                            <div class="col-lg-1 col-md-10" style="margin: 1%"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#demoModal">Add</button></div>
                            @endif
                            <div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="demoModalLabel"><h6>A. {{\App\PhytoTestConducted::find(1)->name}}</h6></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        
                                                <div class="modal-body">
                                                    <form action="{{url('admin/phyto/makereport/organoleptics/update')}}" method="post">
                                                        {{ csrf_field() }} 
                                                        <table class="table table-inverse">                      
                                                            <tbody>
                                                                
                                                                @foreach ($phyto_organoleptics->except($organoleptics_ids)->where('action',1) as $organo_item)
                                                                <tr>
                                                                    <input type="hidden" name="product_id" value="{{$phytoshowreport->id}}">
                                                                    <input type="hidden" name="phyto_testconducted_1" value="{{\App\PhytoTestConducted::find(1)->id}}">
                                                                <th>
                                                                    <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input select_all_child" id="" name="organoleptics_id[]" value="{{$organo_item->id}}">
                                                                    <span class="custom-control-label">&nbsp;</span>
                                                                    </label>
                                                                </th>
                                                                <td class="font">{{$organo_item->name}} :</td>
                                                                <input type="hidden" name="organolepticsname_{{$organo_item->id}}" value="{{$organo_item->name}}">
                                    
                                                                <td class="font"><input class="form-control" type="text" name="organolepticsfeature_{{$organo_item->id}}" value="{{$organo_item->feature}}"></td>
                                                                </tr>        
                                                                @endforeach
                                                                
                                                            </tbody>
                                                        </table>
                                                    
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        
                                                    </form>
                                                </div>
                                        
                                    
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <table class="table table-inverse">                      
                        <tbody>
                            @foreach ($phytoshowreport->phytOrganoliptic as $organo_item)
                    
                            <tr>
                            
                                @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation <2)
                                {{-- <th>
                                <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input select_all_child" id="" name="organoleptics_id[]" value="" checked>
                                <span class="custom-control-label">&nbsp;</span>
                                </label>
                                    </th> --}}
                                @endif
                            
                                <td class="font" style="width: 300px"><strong> {{$organo_item->pivot->name}} :</strong></td>
                                <input type="hidden" name="organolepticsname_{{$organo_item->id}}" value="{{$organo_item->name}}">

                                <td class="font"><input class="form-control" type="text" name="organolepticsfeature_ {{$organo_item->pivot->id}} " value="{{$organo_item->pivot->feature}}"></td>
                                @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation <2)
                                    <td > 
                                    <a onclick="return confirm('Please confrim before deleting row')" href="{{url('admin/phyto/makereport/organoleptics/delete',['p_id' => $phytoshowreport->id, 'organo_id' => $organo_item->pivot->phyto_organoleptics_id ])}}">
                                    <button type="button" name="remove" class="btn btn-danger btn_remove">X</button>
                                    </a> 
                                    </td>
                                @endif
                            </tr>   
                                
                            @endforeach
                        </tbody>
                        </table>

                        <div class="row">
                            <div class="col-lg-10 col-md-10"><h6>B. {{\App\PhytoTestConducted::find(2)->name}}</h6></div> 
                            @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation <2)
                            <div class="col-lg-1 col-md-10" style="margin: 1%"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong">Add</button></div>  
                            @endif
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongLabel" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                            
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongLabel">B. {{\App\PhytoTestConducted::find(2)->name}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{url('admin/phyto/makereport/physicochemdata/update')}}" method="post">
                                                        {{ csrf_field() }}                 
                                                        <table class="table table-inverse">                      
                                                            <tbody>
                                                                @foreach ($phyto_physicochemdata->except($physicochemdata_ids)->where('action',1) as $physicochem_item)
                                                                <tr>
                                                                    <input type="hidden" name="product_id" value="{{$phytoshowreport->id}}">
                                                                    <input type="hidden" name="phyto_testconducted_2" value="{{\App\PhytoTestConducted::find(2)->id}}">
                                                                <th>
                                                                    <label class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input select_all_child" id="" name="physicochemdata_id[]" value="{{$physicochem_item->id}}">
                                                                    <span class="custom-control-label">&nbsp;</span>
                                                                    </label>
                                                                </th>
                                                                <td class="font">
                                                                    <p class="physicochem_{{$physicochem_item->id}}">{{$physicochem_item->name}}</p>
                                                                    <input type="{{$physicochem_item->id != 4?'hidden':''}}" class="form-control" name="physicochemname_{{$physicochem_item->id}}" value="{{$physicochem_item->name}}">
                                                                </td>
                                                                <td class="font"><input class="form-control" type="text" name="physicochemresult_{{$physicochem_item->id}}" value="{{$physicochem_item->result}}"></td>
                                                                </tr>        
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form> 
                                                </div>
                                                
                                    
                                                </div>
                                                
                                </div>
                            </div>
                        </div>
                        <table class="table table-inverse">                      
                        <tbody>
                                @foreach ($phytoshowreport->pchemdataReport as $physicochem_item)
                                <tr>
                                    @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation <2)
                                  {{-- <th>
                                    <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input select_all_child" id="" name="physicochemdata_id[]" value="{{$physicochem_item->pivot->id}}" checked>
                                    <span class="custom-control-label">&nbsp;</span>
                                    </label>
                                  </th> --}}
                                @endif
                                <td class="font" style="width: 300px"><strong>{{$physicochem_item->pivot->name}} :</strong></td>
                                <input type="hidden" name="physicochemname_{{$physicochem_item->pivot->id}}" value="{{$physicochem_item->name}}">
                                <td style="color: #fff" class="font"><input class="form-control" type="text" name="physicochemresult_{{$physicochem_item->pivot->id}}" value="{{$physicochem_item->pivot->result}}"></td>
                                
                                @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation <2)
                                
                                </a> 
                                <td >
                                    <a onclick="return confirm('Please confrim before deleting row')" href="{{url('admin/phyto/makereport/physicochemdata/delete',['p_id' => $phytoshowreport->id, 'physico_id' => $physicochem_item->pivot->phyto_physicochemdata_id])}}">
                                    <button type="button" name="remove" class="btn btn-danger btn_remove">X</button>
                                </td>
                                @endif

                            </tr>        

                                @endforeach
                            </tbody>
                        </table>  
                    </div>
                </div>
                
        
       <div class="row">

        <div class="col-md-12" style="margin-bottom:2%">
            <form action="{{url('admin/phyto/makereport/update',['id' => $phytoshowreport->id])}}" method="post">
                 {{ csrf_field() }} 
                 <h6 style="margin-top: 2%">C. {{\App\PhytoTestConducted::find(3)->name}}</h6>
                 <input type="hidden" name="phyto_testconducted_3" value="{{\App\PhytoTestConducted::find(3)->id}}">
                 <div class="form-group">
                     <p> 
                        @error('chemicalconst')
                        <small style="margin:15px" class="form-text text-danger" role="alert">
                            <strong>{{$message}}</strong>
                        </small>
                        @enderror
                     </p>
                     <select class="form-control select2" name="chemicalconst[]" multiple="multiple">
                         @foreach ($phytoshowreport->pchemconstReport as $pchemconst_item)
                         @foreach (\App\PhytoChemicalConstituents::where('id', $pchemconst_item->pivot->name)->get() as $item)
                         <option value="{{$item->id}}" selected>{{$item->name}}</option>
                         @endforeach
                        @endforeach

                         @foreach (\App\PhytoChemicalConstituents::where('action',1)->get() as $item)
                         <option value="{{$item->id}}">{{$item->name}}</option>  
                         @endforeach
                     
                     </select>

                 </div>
                          
                 <h6 style="margin-top: 2%">REMARKS</h6>
                  <textarea class="form-control" name="comment" id="" cols="30" rows="3"> {{$phytoshowreport->phyto_comment}}</textarea>
               
                  <h6 style="margin-top: 2%">DATE ANALYSED</h6>
                 <input class="form-control" required type="date" name="date_analysed" value="{{$phytoshowreport->phyto_dateanalysed}}" style="width:250px">
                   

                 <div class="col-sm-3" style="margin-top:30px">
                    <div class="form-group">
                        <label for="exampleInputEmail3"> <strong><span style="color: red">Report Evaluation</span></strong>  </label>
                        <select name="phyto_grade" required class="form-control" id="exampleSelectGender">
                        <option value="{{\App\Product::find($phytoshowreport->id)->phyto_grade}}">{!! \App\Product::find($phytoshowreport->id)->phyto_grade_report !!}</option>
                            <option value="1">Failed</option>
                            <option value="2">Passed</option>
                        </select>                                
                        </div>
                </div>

                 <div class="row invoice-info" style="margin: 15px">
                    <?php
                    $phyto_analysed_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_analysed_by:'');
                    $user_type         = (\App\Admin::find($phyto_analysed_by)? \App\Admin::find($phyto_analysed_by)->user_type_id:'');
                    ?>
                    <div class="col-sm-4 invoice-col">
                        <p>Analyzed By</p><br>
                        @if (\App\Product::find($report_id)->phyto_hod_evaluation >null)
                        <img src="{{asset(\App\Admin::find($phyto_analysed_by)? \App\Admin::find($phyto_analysed_by)->sign_url:'')}}" class="" width="42%"><br>
                        @endif
                        -----------------------------<br>
                      
                        <span>{{ucfirst(\App\Admin::find($phyto_analysed_by)? \App\Admin::find($phyto_analysed_by)->full_name:'')}}</span>
                        <p>{{ucfirst(\App\UserType::find($user_type )? \App\UserType::find($user_type )->name:'')}}</p>

                    </div> 
                    <div class="col-sm-4 invoice-col">
                         
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <?php
                        $phyto_appoved_by = (\App\Product::find($report_id)? \App\Product::find($report_id)->phyto_appoved_by:'');
                        $hod_user_type = (\App\Admin::find($phyto_appoved_by)? \App\Admin::find($phyto_appoved_by)->user_type_id:'');

                        ?>
                        <p>Supervisor</p><br>

                        @if (\App\Product::find($report_id)->phyto_hod_evaluation ==2)

                        <img src="{{asset(\App\Admin::find($phyto_appoved_by)? \App\Admin::find($phyto_appoved_by)->sign_url:'')}}" class="" width="42%"><br>
                        @endif

                        ------------------------------<br> 
    
                      <span>{{ucfirst(\App\Admin::find($phyto_appoved_by)? \App\Admin::find($phyto_appoved_by)->full_name:'')}}</span>
                      <p>{{ucfirst(\App\UserType::find($hod_user_type)? \App\UserType::find($hod_user_type)->name:'')}}</p>
         
                    </div>

                </div>

                 <div class="row" style="margin-top: 5%">
                     <div class="col-9">
                         @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation <2)
                         <button type="submit" onclick="return confirm('NB: report will be submitted to the head of department. Click Ok to confirm report submission')" class="btn btn-success pull-right">
                             <i class="fa fa-credit-card"></i> 
                             Submit for Approval
                         </button>
                             @endif
                             @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation ==2)
                         <button type="button" onclick="myFunction()" class="btn btn-primary pull-right" id="complete_report" style="margin-right: 5px;">
                         <i class="fa fa-view"></i> Complete Report</button>
                             @endif
                         <input type="hidden" id="report_url" value="{{url('admin/micro/completedreport/show',['id' => $phytoshowreport->id])}}">
                     </div>
                     <div class="col-3">                        
                         @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation ==1)
                         <button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>
                         @endif
                         @if (\App\Product::find($phytoshowreport->id)->phyto_hod_evaluation ==2)
                         <button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>        
                        @endif
                     </div>
                 </div>
           </form>
      </div>
       </div>
    </div>

</div>



@endsection