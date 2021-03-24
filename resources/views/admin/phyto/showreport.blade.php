@extends('admin.layout.main')

@section('content')
@php

    $product = \App\Product::find($report_id);
@endphp

<div class="container-fluid">
    
    @include('admin.phyto.temp.organophysicoforminputmodal') 

    <form id="checkunit" action="{{url('admin/phyto/makereport/update',['id' => $product->id])}}" method="post">
        {{ csrf_field() }} 
    <div class="card" style="padding: 15px">
           <div class="text-center"> 
           <img src="{{asset('admin/img/logo.jpg')}}" class="" width="11%">
           <h4 class="font" style="font-size:18px"> Centre for Plant Medicine Research </h4>
           <p class="card-subtitle">Phytochemistry Department</p>
          </div>
         
          <div class="card"  style="padding: 15px">
                 @include('admin.phyto.temp.productformat') 
                 @include('admin.phyto.temp.organolepticsformat')
                 @include('admin.phyto.temp.physicochemicalformat')
                 @include('admin.phyto.temp.chemicalconstituents')
                 @include('admin.phyto.temp.phytoconclusion')
          </div>
                
        
       <div class="row">

        <div class="col-md-12" style="margin-bottom:2%">
                 
                  @include('admin.phyto.temp.signaturetemplate')

                 <div class="row" style="margin-top: 5%">
                    <div class="col-9">
                        <div class="row">
                       
                            <div class="col-sm-3">
                                @if ( $product->phyto_hod_evaluation ===Null ||  $product->phyto_hod_evaluation ===1 )
                                <button  type="submit" class="btn btn-success pull-right submitreport1" >
                                <i class="fa fa-credit-card "></i> 
                                     Save Report
                                </button>
                                <button style="display: none"  type="button" class="btn btn-info pull-right submitreport2" data-toggle="modal" data-target="#exampleModalCenter">
                                    <i class="fa fa-credit-card " ></i> 
                                    Submit for Approval
                                </button>
    
                                @endif
                                @if ( $product->phyto_hod_evaluation ==2)
                                <button type="button" onclick="myFunction()" class="btn btn-primary pull-right" id="pharm_complete_report" style="margin-right: 5px;">
                                <i class="fa fa-view"></i> Print Report</button>
                                @endif
                            </div>
                            <div class="col-sm-9">
                                @if ( $product->phyto_hod_evaluation ===Null ||  $product->phyto_hod_evaluation ===1 )
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
                        @if ( $product->phyto_hod_evaluation ===0)
                        <button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i>Approval Pending </button>
                        @endif
                        @if ( $product->phyto_hod_evaluation ===1)
                        <button type="button" class="btn btn-outline-danger"><i class="ik ik-x"></i> Report Withheld</button>
                        @endif
                        @if ( $product->phyto_hod_evaluation ===2)
                        <button type="button" class="btn btn-outline-success"><i class="ik ik-check"></i>Repport Approved </button>        
                       @endif
                    </div>
                </div>
           
        </div>
       </div>
    </div>
</form>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"> 
  
         <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterLabel">Please Sign to submit report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form  id="phytohodapproveform" sign-user-url="{{route('admin.phyto.hod_office.checkhodsign')}}" action="{{url('admin/phyto/makereport/update',['id' => $report_id])}}" class="" method="POST">
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
                    <input  type="hidden" name="complete_report" value="1" class="custom-control-input">

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



@endsection