@extends('admin.layout.main')

@section('content')

@php
    $product = \App\Product::find($report_id);
@endphp

<div class="container-fluid">
    @include('admin.phyto.temp.preview') 
    @include('admin.phyto.temp.organophysicoforminputmodal') 
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    {{-- <i class="ik ik-edit bg-blue"></i> --}}
                    <div class="d-inline">
                        <h5>Office of the HOD</h5>
                        <span>Below shows withheld, approved and completed product(s)</span>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-body">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="widget">
                                <div class="widget-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="state">
                                            <h6>Report(s) Withheld</h6>
                                            @foreach ($withhelds->groupBy('phyto_hod_evaluation') as $result_evaluation) 
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
                                            @foreach ($approvals->groupBy('phyto_hod_evaluation') as $result_approved) 
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
                                            @foreach ($completeds->groupBy('phyto_hod_evaluation') as $result_completed) 
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
                        @include('admin.phyto.temp.hodoffice2') 
    
                    </div>
                    <div class="col-md-8">
                        <div class="card" style="padding: 5px">

                                <div class="text-center"> 
                                <img src="{{asset('admin/img/logo.jpg')}}" class="" width="11%">
                                <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
                                <p class="card-subtitle">Phytochemistry Department</p>
                               </div>
                     
                               <form  action="{{url('admin/phyto/makereport/update',['id' => $product->id])}}" method="post">
                                {{ csrf_field() }} 
                                <input type="hidden" name="savereport" value="1">   

                               <div class="card"  style="padding: 15px">

                                 @include('admin.phyto.temp.productformat') 
                                 @include('admin.phyto.temp.organolepticsformat')
                                 @include('admin.phyto.temp.physicochemicalformat')
                                 @include('admin.phyto.temp.chemicalconstituents')
                                 @include('admin.phyto.temp.phytoconclusion')
                              </div>
                              <div class="col-sm-6">
                                @if ( $product->phyto_hod_evaluation === 0 ||  $product->phyto_hod_evaluation ===1 )
                                <button  type="submit" class="btn btn-success pull-right submitreport1" >
                                <i class="fa fa-credit-card "></i> 
                                     Save Report
                                </button>
                                @endif

                                 <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#demoModapreview">
                                    <i class="fa fa-chevron-right "></i> 
                                    Preview
                                </button>
                              </div>
                             </form>
                     
                     
                     
                                 @include('admin.phyto.temp.signaturetemplate')

                             
                                <div class="col-12" style="margin-top: 50px">
                                 <div class="row">
                                     <div class="col-md-6" style="margin-right: 16%">
                                       @if ($product->phyto_hod_evaluation <2)
                                       <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#exampleModalCenter"> <i class="fa fa-credit-card"></i> Sign Report</button>
                                       @endif
                                       @if ($product->phyto_hod_evaluation ==2) 
                                      <a href="{{ old('redirect_to', URL::previous())}}">
                                       <div class="alert alert-success" role="alert">
                                           Report succesfully completed. Final report of {{$product->code}}  will be printed by SID 
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
                                                            <input required id="useremail" type="email" class="form-control" name="email" placeholder="Enter your email" value="{{App\Admin::find(Auth::guard("admin")->id())->email}}" readonly>
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
                                                       <button type="submit" class="btn btn-primary">Sign</button>
                                                   </div>
                                               </form>
                                               </div>
                                           </div>
                                       </div>
                                     </div>
                                     <div class="col-md-4">  
                                          @if ($product->phyto_hod_evaluation == 2) 
                                         
                                       <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#exampleModalCenter">  Reject Report</button>
                                      <a href="{{url('admin/phyto/report/hod_office/complete_report',['id' => $product->id])}}" target=”_blank”>
                                       <button type="button" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.Completed Reports can not be edited after submision, you would be required to see system Administrator for unavoidable complains or changes.  Thank you')" class="btn btn-success pull-right">  Complete Report</button>
                                      </a>
                                       @endif
                                   </div>
                                </div>
                               </div>
                             </div>
                        </div>
                    </div>
                   
                </div>

        
    </div>
</div>


@endsection