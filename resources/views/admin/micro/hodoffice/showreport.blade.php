@extends('admin.layout.main')

@section('content')
<?php 
$product = \App\Product::find($report_id); 

?>

    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    {{-- <i class="ik ik-edit bg-blue"></i> --}}
                    <div class="d-inline">
                        <h5>Office of the HOD</h5>
                        <span>Below shows evaluated, approved and completed product</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Forms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Group Add-Ons</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

            <div class="card-body">
                @include('admin.micro.temp.preview') 

                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="state">
                                            <h6>Report(s) Withheld</h6>
                                        <h2>{{count($withhelds)}}</h2>
                                        
                                        </div>
                                        <div class="icon">
                                            <i class="ik ik-alert-circle"></i>
                                        </div>
                                    </div>
                                    <small class="text-small mt-10 d-block">Total number of product withheld</small>
                                </div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 62%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="state">
                                            <h6> Approved Report(s)</h6>
                                            <h2>{{count($approvals)}}</h2>
                                       </div>
                                        <div class="icon">
                                            <i class="ik ik-thumbs-up"></i>
                                        </div>
                                    </div>
                                    <small class="text-small mt-10 d-block">Total number of report in Approved</small>
                                </div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="state">
                                            <h6>Completed Report(s) </h6>
                                            <h2>{{count($completeds)}}</h2>
                                        </div>
                                        <div class="icon">
                                            <i class="ik ik-calendar"></i>
                                        </div>
                                    </div>
                                    <small class="text-small mt-10 d-block">Total number of report completed</small>
                                </div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 31%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>


            <div class="row">
                <div class="col-md-4">
                    @include('admin.micro.temp.hodoffice1') 

                </div>

                <div class="col-md-8">
                    <div class="card">
                        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">Preview Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Edit Report</a>
                            </li>
                          
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                <div class="card-body">
                                    <div class="col-sm-2">
                                    </div>
                                    @if ($product->micro_hod_evaluation ===0) 
                                    Please preview and evaluate <strong>({{$product->code}})</strong>  report 
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="card-body">
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
                                 
                
                                                <div class="row"  style="margin:10px; margin-top:5%">
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <h4 class="font" style="font-size:18px; margin:10px; margin-top:5px"><strong> Final Remarks: </strong></h4>
                                    
                                                        <textarea required name="micro_hod_remarks" class="form-control"  rows="4">{{$product->micro_hod_remarks}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <h4 class="font" style="font-size:18px; margin:10px; margin-top:5px"><strong> Product Grade</strong></h4>
                                                        <p>{!! $product->micro_grade_report !!} </p>
                                                            <select name="micro_grade" required class="form-control" >
                                                            <option value="{{$product->micro_grade}}">{!! $product->micro_grade_report !!}</option>
                                                                <option value="1">Failed</option>
                                                                <option value="2">Passed</option>
                                                            </select> 
                                                        <br>
                                                                    
                                                    </div>
                                                </div>
                                                @include('admin.micro.temp.signaturetemplate') 

                                                <div class="row" style="margin-bottom:2%; margin-top:5%">
                                                    <div class="col-sm-3" >
                                                     @if ($product->micro_hod_evaluation < 2 )
                                                     <button type="submit" class="btn btn-danger pull-right"> <i class="fa fa-credit-card"></i>Save report</button>
                                                     @endif
                                                    </div>
                                                  
                                                </div>
                                            </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <div class="row">  
                                <div class="col-md-8">
                                    @if ($product->micro_hod_evaluation ===1) 
                                    <div class="alert alert-danger" role="alert">
                                        Report of {{$product->code}}  has been rejected.
                                    </div>       
                                     @endif
                                </div>
                                <div class="col-md-6" style="margin-right: 1%">
                                    
                                    @if ($product->micro_hod_evaluation ===2 &&  ($product->micro_process_status ===0 || $product->micro_process_status ===3) ) 
                                    <a href="{{ old('redirect_to', URL::previous())}}">
                                    <div class="alert alert-success" role="alert">
                                        Report succesfully analysed. Final report of {{$product->code}}  will be approved by the Hod. 
                                    </div>
                                    </a>
                                    @endif
                                        
                                    @if ($product->micro_hod_evaluation ===2 &&  $product->micro_process_status ===2) 
                                    <a href="{{ old('redirect_to', URL::previous())}}">
                                        <div class="alert alert-danger" role="alert">
                                            Report of {{$product->code}}  has been rejected by Hod for some reasons
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
                                                    <form  id="microhodapproveform" sign-user-url="{{route('admin.micro.hod_office.checkhodsign')}}" action="{{route('admin.micro.hod_office.evaluatereport',['id' => $report_id])}}" class="" method="POST">
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
                                                            @error('pin')
                                                            <small style="margin-left:120px;margin-top:-10; margin-bottom:5px" class="form-text text-danger" role="alert">
                                                                <strong>{{$pin}}</strong>
                                                            </small>
                                                            @enderror
                                                            <span class="input-group-prepend"><label class="input-group-text"><i class="ik ik-shield"></i></label></span>
                                                            <input required id="userpin" type="password" class="form-control" name="pin" placeholder="Sign with   PIN">
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
                           
                            </div>
                            <div class="row" style="margin-bottom:2%">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#demoModapreview">
                                        <i class="fa fa-chevron-right "></i> 
                                        Preview
                                    </button>
                                </div>
                                @if ($product->micro_hod_evaluation <2)
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="ik ik-clipboard"></i> Evaluate Report</button>    
                                </div>
                                @endif
                                @if ($product->micro_hod_evaluation ===2 && ($product->micro_process_status ===0 || $product->micro_process_status ===2) ) 
                                <div class="col-md-6">  
                                <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#exampleModalCenter">Reject </button>
                
                                <a onclick="return confirm('Consider the following before submitting report : 1.All report fields must be appropriately checked 2.submited Reports can be edited after Hod evaluation.  Thank you')" href="{{route('admin.micro.hod_office.finalreport.send',['id' => $report_id])}}">
                                <button type="button" class="btn btn-success pull-right"> Send for approval</button>
                                </a>
                               
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                   </div>
                    </div>
                 
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
  var r = confirm("Be aware of the following before you complete report : 1.Completed Reports can not be edited aftesdr submision, system require you to see HoD for unavoidable complains or changes.  Thank you");
  if (r == true) {
  var  myWindow = window.open(url, "_blank", "width=500, height=500");
  } else {
   
  }
  document.getElementById("demo").innerHTML = txt;
}
</script> --}}

@endsection