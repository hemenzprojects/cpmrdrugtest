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
                                    {{$phytoshowreport->productType->code}}|{{$phytoshowreport->id}}|{{$phytoshowreport->created_at->format('y')}}
                                </td>
                            </tr>
                            <tr>
                            <td class="font"><strong>Date Recievied:</strong></td>
                                <td class="font">{{$phytoshowreport->name}}</td>
                            </tr>
                            <tr>
                                <td class="font"><strong>Date of Report:</strong></td> 
                                <td class="font">{{$phytoshowreport->phyto_dateanalysed}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        
            </div>

           <div class="card">
              <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> TECHNICAL INFORMATION</strong></h4>

              <div class="col-md-7">

                <div class="col-lg-10 col-md-10" style="margin: 5px"><h5>A. {{\App\PhytoTestConducted::find(1)->name}}</h5></div> 
                <div class="table-responsive">
                    <table class="table">

                    <tbody>
                      @foreach ($phytoshowreport->organolipticReport as $item)
                      <tr>
                        <th scope="row">{{$item->name}} :</th>
                        <td class="font">{{$item->feature}}</td>
                      </tr>
                      @endforeach
                    </tbody>
         
                </table>
            </div>

            <div class="col-lg-10 col-md-10" style="margin: 5px"><h5>B. {{\App\PhytoTestConducted::find(2)->name}}</h5></div>
            <div class="table-responsive"> 
                <table class="table">
                    <tbody>
                        @foreach ($phytoshowreport->phytochemdataReport as $item)
                        <tr>
                          <th scope="row">{{$item->name}} : </th> 
                          <td class="font"> = {{$item->result}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                </table>
            </div>
            
            <div class="col-lg-10 col-md-10" style="margin: 5px"><h5>C. {{\App\PhytoTestConducted::find(3)->name}}</h5></div>
                 <h6 class="" style="margin: 3%"> 
                  @foreach ($phytoshowreport->phytochemconstReport as $pchemconst_item)
                  @foreach (\App\PhytoChemicalConstituents::where('id', $pchemconst_item->name)->get() as $item)
                  {{$item->name}},
                  @endforeach
                 @endforeach
                 </h6>
                    
            </div>
            <div class="col-md-5"></div>

           </div>

           <div class="card">
            <h4 class="font" style="font-size:18px; margin:20px; margin-top:15px"><strong> REMARKS</strong></h4>
           <h6 style="margin:15px">{{$phytoshowreport->phyto_comment}}</h6>
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
        
           <div class="col-12">
            <div class="row">
                <div class="col-md-6" style="margin-right: 16%">
                  @if (\App\Product::find($report_id)->phyto_hod_evaluation <2)
                  <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="fa fa-credit-card"></i> Approve Report</button>
                  @endif
                  @if (\App\Product::find($report_id)->phyto_hod_evaluation ==2) 
                 <a href="{{ old('redirect_to', URL::previous())}}">
                  <div class="alert alert-success" role="alert">
                      Report succesfully completed. Final report of {{\App\Product::find($report_id)->productType->code}}|{{\App\Product::find($report_id)->id}}|{{\App\Product::find($report_id)->productType->created_at->format('y')}}  will be printed by SID 
                  </div>
                 </a>
                 
                 @endif
                  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                       
  
                           <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalCenterLabel">Please Sign to evaluate report</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                              </div>
                              <div class="modal-body">
                                  <form  id="phytohodapproveform" sign-user-url="{{route('admin.phyto.hod_office.checkhodsign')}}" action="{{route('admin.phyto.hod_office.evaluatereport',['id' => $report_id])}}" class="" method="POST">
                                      {{ csrf_field() }}
                                  <input id ="_token" name="_token" value="{{ csrf_token() }}" type="hidden">
  
                                  <div class="input-group input-group-default col-md-6">
                                      <select class="form-control" name="evaluate">
                                          <option value="2">Approve Report</option>
                                          <option value="1">Reject Report</option>
                                      </select>
                                      </div>
                                      <div id="error-div" style="margin: 5px; color:red;"></div>
                                      <input name="adminid" id="adminid"  type="hidden" >
              
                                      <div class="input-group input-group-default">
                                          @error('email')
                                          <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                              <strong>{{$message}}</strong>
                                          </small>
                                          @enderror
                                          <span class="input-group-prepend"><label class="input-group-text"><i class="ik ik-shield"></i></label></span>
                                          <input required id="useremail" type="email" class="form-control" name="email" placeholder="Enter your email">
                                      </div>
              
                                      <div class="input-group input-group-default">
                                          @error('password')
                                          <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                              <strong>{{$password}}</strong>
                                          </small>
                                          @enderror
                                          <span class="input-group-prepend"><label class="input-group-text"><i class="ik ik-shield"></i></label></span>
                                          <input required id="userpassword" type="password" class="form-control" name="password" placeholder="Sign with password">
                                      </div>                         
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <button type="submit" class="btn btn-primary">Sign Report</button>
                              </div>
                          </form>
                          </div>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">  
                     @if (\App\Product::find($report_id)->phyto_hod_evaluation ==2) 
                    
                  <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#exampleModalCenter">  Reject Report</button>
                 <a target="_blank" href="{{url('admin/phyto/completedreport/show',['id' => $report_id])}}">
                  <button type="button" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.Completed Reports can not be edited after submision, you would be required to see system Administrator for unavoidable complains or changes.  Thank you')" class="btn btn-success pull-right">  Complete Report</button>
                 </a>
                  @endif
              </div>
           </div>
          </div>
        </div>
</div>



@endsection