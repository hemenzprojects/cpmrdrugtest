@extends('admin.layout.main')

@section('content')
@php
$hod_anex = App\Admin::where('id',Auth::guard('admin')->id())->where('dept_office_id',1)->first()
@endphp

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    {{-- <i class="ik ik-edit bg-blue"></i> --}}
                    <div class="d-inline">
                        <h5>Office of the HOD</h5>
                        <span>Below shows evaluated, approved and completed products</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="padding:1%">
                

                @php
                 $hod_assist = App\Admin::where('id',Auth::guard('admin')->id())->where('dept_office_id',1)->first()
               @endphp
                @if ($hod_assist->user_type_id ==2)
                @include('admin.pharm.temp.hodstatistics1')

                <div class="card">
                    <div class="col-md-4">
                        @include('admin.pharm.temp.hodtaskboard1') 
                        @include('admin.pharm.temp.hodtaskboard2') 
                    </div>
                     <div class="col-md-8">

                     </div>
                </div> 
                @endif
              
              

                @if ($hod_anex->user_type_id ==1)
                @include('admin.pharm.temp.hodstatistics2')

                <div class="card">
                    <div class="col-md-4">
                        @include('admin.pharm.temp.hodtaskboard2') 
                    </div>
               </div> 
                @endif
                
              

            </div>
        </div>
    </div>
</div>
@endsection              