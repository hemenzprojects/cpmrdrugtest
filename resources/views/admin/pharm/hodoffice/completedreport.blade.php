@extends('admin.layout.main')

@section('content')

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-10">
                <div class="page-header-title">
                    {{-- <i class="ik ik-edit bg-blue"></i> --}}
                    <div class="d-inline">
                        <h5>Office of the HOD</h5>
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
    <div class="card">
        <div class="text-center" style="margin: 2%"> 
            <h4 class="font" style="font-size:18px">Generate Report</h4>
           <p class="card-subtitle"> selec date below to generate report</p>
          </div>
        <div class="row" style="margin:1%">
        
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Daily Report</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Search</button>                                        </div>
            </div>
            
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Monthly Report</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Search</button>                                        </div>
            </div>
    
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Yearly Report</label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">search</button>                                        </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-block">
            <h3>Pharmacology Completed Rports</h3>
        </div>
        <div class="card-body">
            <div class="dt-responsive">
                <table id="order-table"
                       class="table table-striped table-bordered nowrap">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Test conducted</th>
                        <th>Assigned Officers</th>
                        <th>Evaluation</th>
                        <th>Date Analysed</th>  
                        <th>Date Completed</th> 
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($completed_reports as $report)
                        <tr>
                            <td class="font">
                                    <a href="{{url('admin/pharm/completedreport/show',['id' => $report->id])}}">
                                     
                                    <span  class="badge  pull-right" style="background-color: #de1024; color:#fff ">
                                    {{$report->productType->code}}|{{$report->id}}|{{$report->created_at->format('y')}}
                                    </span>
                                    </a>
                            </td>
                            <td class="font"> {{\App\PharmTestConducted::find($report->pharm_testconducted)->name}}</td>
                            <td class="font">
                                    <strong>Sample Preparation:</strong>
                                    <li> @foreach ($report->samplePreparation->groupBy('id')->first() as $item)
                                    <span style="color: #023504">{{\App\Admin::find($item->distributed_by)->full_name}}</span>
                                    @endforeach
                                   </li>
                                    {{-- <strong>Animal Experiment:</strong> 
                                     <li style="margin-bottom: 5px"> @foreach ($report->animalExperiment->groupBy('id')->first() as $item)
                                    <span style="color: #023504">{{\App\Admin::find($item->added_by_id)->full_name}}</span>
                                    @endforeach</li> --}}
                                    <strong>Report Analyst:</strong>
                                      <li> @foreach ($report->animalExperiment->groupBy('id')->first() as $item)
                                    <span style="color: #023504">{{\App\Admin::find($item->added_by_id)->full_name}}
                                    </span>
                                    @endforeach
                                    </li>
                            </td>
                            <td class="font">{!! $report->hod_pharm_evaluation !!}</td>
                            <td class="font">{{$report->pharm_dateanalysed}}</td>
                            <td class="font">{{$report->pharm_datecompleted}}</td>
                        </tr>
                        @endforeach     
                     </tbody>
                 
                </table>
            </div>
        </div>
    </div>

</div>
@endsection