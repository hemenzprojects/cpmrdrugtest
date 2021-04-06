<?php 
$product = \App\Product::find($report_id); 

?>
@extends('admin.layout.main')

@section('content')
        <div class="container-fluid">
            <div class="card" style="padding: 15px">
            <form id="checkinputmask" action="{{url('admin/micro/report/update',['id' => $report_id])}}" method="POST">
                    {{ csrf_field() }} 
                <div class="text-center"> 
                <img src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
                <h5 class="font" style="font-size:16px"> Microbiology Department Centre for Plant Medicine Research </h5>
                <p class="card-subtitle">Microbial Analysis Report on Herbal Product</p>
               </div>
            
                    
               
                    @include('admin.micro.temp.productformat') 
                    @include('admin.micro.temp.mlreportformat')                  

                    @include('admin.micro.temp.mereportform')
                    @include('admin.micro.temp.mereportformat')


                   <div class="row">
                     @if ( $product->micro_hod_evaluation > 0)
                     <div class="col-sm-8">
                         <h4 class="font" style="font-size:15px; margin:20px; margin-top:15px"> <strong> Report Evaluation </strong></h4>
                         <div class="alert alert-info" role="alert">
                             {{$product->micro_hod_remarks}}
                           </div>
                     </div>
                     @endif
                    <div class="col-sm-3" style="margin-top:30px">
                        <div class="form-group">
                            <label for="exampleInputEmail3"> <strong><span style="color: red">Product Evaluation</span></strong>  </label>
                            <select name="micro_grade" required class="form-control" id="exampleSelectGender">
                            <option value="{{$product->micro_grade}}">{!! $product->micro_grade_report !!}</option>
                                <option value="1">Failed</option>
                                <option value="2">Passed</option>
                            </select>                                
                            </div>
                    </div>
                </div>
                    <div class="row invoice-info" style="margin: 15px; margin-top:60px">
                        <?php
                        $micro_approved_by = ($product? $product->micro_approved_by:'');
                        $user_type         = (\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->user_type_id:'');
                      ?>
                        <div class="col-sm-4 invoice-col">
                            <p>Analyzed By</p><br>
                            @if ($product->micro_hod_evaluation == 2)
                            <img src="{{asset(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->sign_url:'')}}" class="" width="28%"><br>
                            @endif
                            -----------------------------<br>
                          
                            <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->full_name:'')}}</span><br>
                            <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->position:'')}}</span>

                        </div> 
                        <div class="col-sm-4 invoice-col">
                             
                        </div>
                        <div class="col-sm-4 invoice-col">
                            <?php
                            $micro_finalapproved_by = ($product? $product->micro_finalapproved_by:'');
                            $hod_user_type = (\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->user_type_id:'');
    
                            ?>
                            <p>Approved by</p><br>
                            @if ($product->micro_finalapproved_by !== Null)
                            <img src="{{asset(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->sign_url:'')}}" class="" width="28%"><br>
                            @endif
    
                            ------------------------------<br> 
    
                            <span>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->full_name:'')}}</span>
                            <p>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->position:'')}}</p>
             
                        </div>

                    </div>
    
               </div>

            <div class="row">
                <div class="col-9">
                    <div class="row">
                   
                        <div class="col-sm-3">
                            @if ( $product->micro_hod_evaluation ===Null ||  $product->micro_hod_evaluation ===1 )
                            <button  type="submit" class="btn btn-success pull-right submitreport1" id="pharm_submit_report" >
                            <i class="fa fa-credit-card "></i> 
                            Save Report
                            </button>
                            <button style="display: none"  type="button" class="btn btn-info pull-right submitreport2" id="pharm_submit_report" data-toggle="modal" data-target="#exampleModalCenter">
                                <i class="fa fa-credit-card " ></i> 
                              Submit Report
                            </button>

                            @endif
                            @if ( $product->micro_hod_evaluation ==2)
                            <button type="button" onclick="myFunction()" class="btn btn-primary pull-right" id="pharm_complete_report" style="margin-right: 5px;">
                            <i class="fa fa-view"></i> Print Report</button>
                            @endif
                        </div>
                        <div class="col-sm-9">
                            @if ( $product->micro_hod_evaluation ===Null ||  $product->micro_hod_evaluation ===1 )
                            <div class="form-check mx-sm-2">
                                <label class="custom-control custom-checkbox">
                                    <input id="submitreport" type="checkbox" name="complete_report" value="1" class="custom-control-input">
                                    <span class="custom-control-label">&nbsp;Check to complete report </span>
                                </label>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="col-3">
                    @if ( $product->micro_hod_evaluation ===0)
                    <button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>
                    @endif
                    @if ( $product->micro_hod_evaluation ===1)
                    <button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i> Report Withheld</button>
                    @endif
                    @if ( $product->micro_hod_evaluation ===2)
                    <button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>        
                   @endif
                </div>
            </div>
        </form>
        </div>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document"> 
          
                 <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterLabel">Please Sign to submit report</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form  id="microhodapproveform" sign-user-url="{{route('admin.micro.hod_office.checkhodsign')}}" action="{{url('admin/micro/report/update',['id' => $report_id])}}" class="" method="POST">
                            {{ csrf_field() }}
                        <input id ="_token" name="_token" value="{{ csrf_token() }}" type="hidden">

                        <div class="input-group input-group-default col-md-6">
                         
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
                            <input  type="hidden" name="complete_report" value="1" class="custom-control-input">

                            <div class="input-group input-group-default">
                                @error('pin')
                                <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                    <strong>{{$pin}}</strong>
                                </small>
                                @enderror
                                <span class="input-group-prepend"><label class="input-group-text"><i class="ik ik-shield"></i></label></span>
                                <input required id="userpin" type="password" class="form-control" name="PIN" placeholder="Sign with PIN">
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
@endsection

@section('bottom-scripts')
<script src="{{asset('js/jquery.inputmask.bundle.min.js')}}"></script>   
<script src="{{asset('js/microbialcomments.js')}}"></script>

{{-- <script>
function myFunction() {
  var url = $('input[id="report_url"]').attr("value");
  var r = confirm("Be aware of the following before you complete report : 1.Completed Reports can not be edited after submision, system require you to see HoD for unavoidable complains or changes.  Thank you");
  if (r == true) {
  var  myWindow = window.open(url, "_blank", "width=500, height=500");
  } else {
   
  }
  document.getElementById("demo").innerHTML = txt;
}
</script> --}}

@endsection