@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-10">
                <div class="page-header-title">
                    {{-- <i class="ik ik-edit bg-blue"></i> --}}
                    <div class="d-inline">
                        <h5>All Completed Products</h5>
                        <span>Below shows record book completed reports</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-outline-danger" href="{{ old('redirect_to', URL::previous())}}">
                    <i class="ik ik-arrow-left"></i> Previous
                </a>
            </div>
        </div>
    </div>
    <div class="card" style="overflow-x: scroll"> 
        <div class="card-header d-block">
            <h3>Pharmacology Completed Rports  </h3>
        </div>

        <div class="col col-sm-9">
            <div class="card-search with-adv-search dropdown">
                <form action="{{route('admin.pharm.report.hod_office.completereportsearch')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                        <span style="margin: 5">From</span>  
                        <input type="date" name="from_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                      
                        <div class="col-md-3">
                            <span style="margin: 5px">To  </span>  <input type="date" name="to_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-3">
                            <span style="margin: 5px">User</span>  
                            <select name="pharm_admin" id="" class="form-control">
                                <option value="">All Users</option>
                                @foreach ($admins as $item)
                               <option value="{{$item->id}}">{{$item->full_name}}</option> 
                                @endforeach
                               
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="hidden" name="samplepreparation">
                            <button style="margin-top: 20px" type="submit" class="btn btn-primary mr-2">search</button>  
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
        <div class="card-body">
            <table id="order-table" class="table table-striped table-bordered nowrap">
         <thead>
         <tr>
            
             <th>Product</th>
             <th>Test conducted</th>
             <th>Assigned To</th>
             <th>Approved By</th>
             <th>Evaluation</th>
             <th>Grade</th>
             <th>Date Analysed</th>  
             <th>Date Submited</th> 
             <th>Action</th>
         </tr>
         </thead>
         <tbody>
             @foreach ($completed_reports as $completed_report)                                      
             <tr>
          
             <td class="font">
                 <a data-toggle="modal"  data-placement="auto" data-target="#exampleModalLong{{$completed_report->id}}" title="View Experiment" href=""></i>  
                     <span  class="badge  pull-right" style="background-color: #de1024; color:#fff; margin:3px">
                 {{$completed_report->code}}
                 </span>

                 </a>
                 <sup style="font-size: 1px">
                    {{$completed_report->productType->code}}{{$completed_report->id}}{{$completed_report->created_at->format('y')}}
                 </sup> 
             </td>
             <td class="font">
                 {{\App\PharmTestConducted::find($completed_report->pharm_testconducted)->name}}
             </td>
             <td class="font">
                 
               <strong>Animal Experiment:</strong>  <li style="margin-bottom: 5px"> @foreach ($completed_report->animalExperiment->groupBy('id')->first() as $item)
                 <span style="color: #023504">{{\App\Admin::find($item->added_by_id)->full_name}}</span>
                 @endforeach</li>
                 <strong>Report Analyst:</strong>  
                 <li>
                    <span style="color: #023504">{{\App\Admin::find($completed_report->pharm_analysed_by)->full_name}}
                 </li>
             </td>
             <td class="font">
                 
                <strong>Approval 1</strong>  <li style="margin-bottom: 5px"> 
                @if ($completed_report->pharm_approved_by == !Null)
                {{\App\Admin::find($completed_report->pharm_approved_by)->full_name}}     
                @else
                    <span style="color:red"> Null </span>
                @endif
                </li>
                  <strong>Approval 2</strong>  
                  <li>
                     <span style="color: #023504">{{\App\Admin::find($completed_report->pharm_finalapproved_by)->full_name}}
                  </li>
              </td>
             <td class="font">{!! $completed_report->hod_pharm_evaluation !!}</td>
             <td class=""> 
                @if ($completed_report->pharm_grade != Null)
                <strong>{!! $completed_report->pharm_grade_report !!}</strong>
                @endif
            </td>
             <td class="font">{{$completed_report->pharm_dateanalysed}}</td>
             <td class="font">{{$completed_report->updated_at->format('d/m/Y')}}</td>
             <td class="font">
                 <a href="{{url('admin/pharm/completedreport/show',['id' => $completed_report->id])}}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>

                 </td>
             
             </tr>
          
              @endforeach
       </tbody>
       
     </table>
        </div> 
    </div>

</div>
@endsection