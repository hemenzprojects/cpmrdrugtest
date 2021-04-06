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
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Evaluation</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="widget">
                <div class="widget-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="state">
                            <h6>Report(s) Withheld</h6>
                            @foreach ($hod_withhelds->groupBy('micro_hod_evaluation') as $result_evaluation) 
                           <h2>{{count($result_evaluation)}}</h2>
                        
                            @endforeach
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
                            @foreach ($hod_approvals->groupBy('micro_hod_evaluation') as $result_approved) 
                            <h2>{{count($result_approved)}}</h2>
                            @endforeach
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
                            @foreach ($completeds->groupBy('micro_hod_evaluation') as $result_completed) 
                            <h2>{{count($result_completed)}}</h2>
                            @endforeach
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
        @include('admin.micro.temp.hodoffice2') 
    </div>
    <div class="col-md-8">
        <div class="container">
            <div class="card" style="padding: 15px">
            
                <div class="text-center"> 
                <img src="{{asset('admin/img/logo.jpg')}}" class="" width="12%">
                <h5 class="font" style="font-size:16px"> Microbiology Department Centre for Plant Medicine Research </h5>
                <p class="card-subtitle">Microbial Analysis Report on Herbal Product</p>
               </div>
               
                

               @include('admin.micro.temp.productformat') 
               @include('admin.micro.temp.mlreportformat')                  

               @include('admin.micro.temp.mereportformat')

                     <div class="row" style="margin: 0.5%; margin-top: 7%">
                        
                       
                        <div class="col-md-12">
                            <strong><h6>Produc Grade:</h6></strong><p>{!! $product->micro_grade_report !!} </p><br><br>
                        </div>

                   </div>
                   <div class="row invoice-info" style="margin: 15px; margin-top:60px">
                    <?php
                    $micro_approved_by = ($product? $product->micro_approved_by:'');
                    $user_type         = (\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->user_type_id:'');
                  ?>
                    <div class="col-sm-4 invoice-col">
                        <p>Analyzed By</p><br>
                        @if ($product->micro_hod_evaluation > null)
                        <img src="{{asset(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->sign_url:'')}}" class="" width="42%"><br>
                        @endif
                        -----------------------------<br>
                      
                        <span>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->full_name:'')}}</span>
                        <p>{{ucfirst(\App\Admin::find($micro_approved_by)? \App\Admin::find($micro_approved_by)->position:'')}}</p>

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
                        <img src="{{asset(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->sign_url:'')}}" class="" width="42%"><br>
                        @endif

                        ------------------------------<br> 

                        <span>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->full_name:'')}}</span>
                        <p>{{ucfirst(\App\Admin::find($micro_finalapproved_by)? \App\Admin::find($micro_finalapproved_by)->position:'')}}</p>
         
                    </div>
    
            </div>
            <div class="col-12">
          
                <div class="row" style="margin-top: 110px">
                    <div class="col-md-4">
                        @if ($product->micro_hod_evaluation ===2 && $product->micro_process_status ===1 ) 
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="ik ik-clipboard"></i> Evaluate Report</button>
                        @endif
                    </div>
                    <div class="col-md-8">
                        @if ($product->micro_process_status ===2) 
                        <div class="alert alert-danger" role="alert">
                            Report of {{$product->code}}  has been rejected.
                        </div>       
                       @endif
                    </div>
                      <div class="col-md-7" style="margin-right: 1%">
                          
                      
                          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document"> 
                            
                                   <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalCenterLabel">Please Sign to evaluate report</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                      </div>
                                      <div class="modal-body">
                                          <form  id="microhodfinalapproveform" sign-user-url="{{route('admin.micro.hod_office.finalapproval.checkhodsign')}}" action="{{route('admin.micro.hod_office.finalapproval.evaluatereport',['id' => $report_id])}}" class="" method="POST">
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
                                                  <input required id="userpin" type="password" class="form-control" name="pin" placeholder="Sign with PIN">
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
                        @if ($product->micro_hod_evaluation ===2 && $product->micro_process_status ===3) 
                        
                      <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#exampleModalCenter">  Reject </button>
                      <a onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.Completed Reports can not be edited after submision, you would be required to see system Administrator for unavoidable complains or changes.  Thank you')" target="_blank" href="{{url('admin/micro/report/hod_office/complete_report',['id' => $report_id])}}">
                      <button type="button" class="btn btn-success pull-right"> Complete </button>
                     </a>
                      @endif
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
  var r = confirm("Be aware of the following before you complete report : 1.Completed Reports can not be edited after submision, system require you to see HoD for unavoidable complains or changes.  Thank you");
  if (r == true) {
  var  myWindow = window.open(url, "_blank", "width=500, height=500");
  } else {
   
  }
  document.getElementById("demo").innerHTML = txt;
}
</script> --}}

@endsection
