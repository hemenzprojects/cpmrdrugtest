@extends('admin.layout.main')

@section('content')

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
                {{-- <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="../index.html"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Forms</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Group Add-Ons</li>
                    </ol>
                </nav> --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="padding:1%">
                
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="widget">
                            <div class="widget-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="state">
                                        <h6>Report(s) evaluation</h6>
                                        @foreach ($withhelds->groupBy('pharm_hod_evaluation') as $result_evaluation) 
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
                                        @foreach ($approvals->groupBy('pharm_hod_evaluation') as $result_approved) 
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
                                        @foreach ($completeds->groupBy('pharm_hod_evaluation') as $result_completed) 
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
            

               <div class="card">
                 <div class="card-body">
                    <form action="{{route('admin.pharm.hod_office.evaluate')}}" method="post">
                        {{ csrf_field() }}
                    <div class="dt-responsive">
                        <table id="order-table"
                               class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Test conducted</th>
                                <th>Assigned To</th>
                                <th>Evaluation</th>
                                <th>Date Analysed</th>  
                                <th>Date Submited</th> 
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($evaluations as $evaluation)                                      
                                <tr>
                                <td class="font">
                                    <div class="">
                                        <label class="custom-control custom-checkbox">
                                        <input type="checkbox" name="pharm_evaluated_product[]" class="custom-control-input" value="{{$evaluation->id}}">
                                            <span class="custom-control-label"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="font">
                                    <a data-toggle="modal"  data-placement="auto" data-target="#exampleModalLong{{$evaluation->id}}" title="View Experiment" href=""></i>  
                                        <span  class="badge  pull-right" style="background-color: #de1024; color:#fff; margin:3px">
                                    {{$evaluation->productType->code}}|{{$evaluation->id}}|{{$evaluation->created_at->format('y')}}
                                    </span><br>

                                    </a>
                                </td>
                                <td class="font">
                                    {{\App\PharmTestConducted::find($evaluation->pharm_testconducted)->name}}
                                </td>
                                <td class="font">
                                    {{-- <strong>Sample Preparation:</strong><li> @foreach ($evaluation->samplePreparation->groupBy('id')->first() as $item)
                                        {{\App\Admin::find($item->distributed_by)->full_name}}
                                        @endforeach</li> --}}
                                  <strong>Animal Experiment:</strong>  <li style="margin-bottom: 5px"> @foreach ($evaluation->animalExperiment->groupBy('id')->first() as $item)
                                    <span style="color: #023504">{{\App\Admin::find($item->added_by_id)->full_name}}</span>
                                    @endforeach</li>
                                    <strong>Report Analyst:</strong>  <li> @foreach ($evaluation->animalExperiment->groupBy('id')->first() as $item)
                                        <span style="color: #023504">{{\App\Admin::find($item->added_by_id)->full_name}}
                                        </span>
                                       @endforeach
                                    </li>
                                </td>
                                <td class="font">{!! $evaluation->hod_pharm_evaluation !!}</td>
                                <td class="font">{{$evaluation->pharm_dateanalysed}}</td>
                                <td class="font">{{$evaluation->updated_at->format('d/m/Y')}}</td>
                                <td class="font">
                                    <a href="{{url('admin/pharm/hod_office/evaluate_one',['id' => $evaluation->id])}}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>

                                    </td>
                                  {{-- 
                                <div class="modal fade" id="exampleModalLong{{$evaluation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongLabel" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog" style="margin-right: 40%;" role="document">
                                        <div class="modal-content" style="width: 170%; margin-right:20%">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongLabel">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            </div>
                                            <div class="modal-body">
                                            
                                                <div class="row" style="margin:5px; padding:15px; background:#f7f4f4">
                                                                
                                                    <div class="col-md-3 col-6"> <strong>Product</strong>
                                                        <br>
                                                        <p class="text-muted">{{$evaluation->productType->code}}|{{$evaluation->id}}|{{$evaluation->created_at->format('y')}} <br>{{$evaluation->name}}</p>
                                                    </div>
                                                    <div class="col-md-3 col-6"> <strong>Product Form</strong>
                                                        <br>
                                                        <p class="text-muted">{{$evaluation->productType->name}}</p>
                                                    </div>
                                                    <div class="col-md-3 col-6"> <strong>Date Received</strong>
                                                        <br>
                                                        @foreach (\App\productDept::where('product_id',$evaluation->id)->where('dept_id',2)->get(); as $report)
                                                        <p class="text-muted"> {{$report->updated_at->format('d/m/Y')}} </p>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-3 col-6"> <strong>Date Analysed</strong>
                                                        <br>
                                                        <p class="text-muted">{{$evaluation->pharm_dateanalysed}} </p>
                                                    </div>
                                                </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                </tr>
                                 @endforeach
                        </tbody>
                          
                        </table>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select  name="evaluation" class="form-control" id="exampleSelectGender">
                                        <option value="1">Complete Report(s)</option>                                        
                                        
                                        </select>
                                    </div>
                                </div>
                                @error('status')
                                <small style="" class="form-text text-danger" role="alert">
                                    <strong>{{$message}}</strong>
                                </small>
                                @enderror
                            </div>
                            <div class="col-md-7">   
                                <button type="submit" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.Completed Reports can not be edited after submision, you would be required to see system Administrator for unavoidable complains or changes.  Thank you')" class="btn btn-primary mb-2">Complete Selected Report(s)</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection              