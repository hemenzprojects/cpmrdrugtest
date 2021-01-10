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
                                            @foreach ($withhelds->groupBy('micro_hod_evaluation') as $result_evaluation) 
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
                                            @foreach ($approvals->groupBy('micro_hod_evaluation') as $result_approved) 
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
                  <div class="card">
                            <div class="card-header row">
                                <div class="col col-sm-3">
                                    <div class="card-options d-inline-block">
                                        <a href="#"><i class="ik ik-inbox"></i></a>
                                        <a href="#"><i class="ik ik-plus"></i></a>
                                        <a href="#"><i class="ik ik-rotate-cw"></i></a>
                                        <div class="dropdown d-inline-block">
                                            <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-horizontal"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="moreDropdown">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">More Action</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-sm-6">
                                    <div class="card-search with-adv-search dropdown">
                                        <form action="">
                                            <input type="text" class="form-control global_filter" id="global_filter" placeholder="Search.." required>
                                            <button type="submit" class="btn btn-icon"><i class="ik ik-search"></i></button>
                                            <button type="button" id="adv_wrap_toggler" class="adv-btn ik ik-chevron-down dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                            <div class="adv-search-wrap dropdown-menu dropdown-menu-right" aria-labelledby="adv_wrap_toggler">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control column_filter" id="col0_filter" placeholder="Name" data-column="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control column_filter" id="col1_filter" placeholder="Position" data-column="1">
                                                        </div>
                                                    </div>
                                               
                                                </div>
                                                <button class="btn btn-theme">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                    <div class="card-body">
                                        <form action="{{route('admin.phyto.hod_office.evaluate')}}" method="post">
                                            {{ csrf_field() }}
                                        <table id="order-table" class="table table-striped table-bordered table dataTable" style="overflow-x:scroll">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Tests conducted</th>
                                                    <th>Assigned To</th>
                                                    <th>Evaluation</th>
                                                    <th>Date Analysed</th>  
                                                    <th>Action</th>                  
                                                </tr>
                                            </thead> 
                                            <tbody> 
                                                @foreach ($evaluations as $product_evaluation)                                      
                                                <tr>
                                                <td> 
                                                    <div class="">
                                                        <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="evaluated_product[]" class="custom-control-input" value="{{$product_evaluation->id}}">
                                                            <span class="custom-control-label"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="font">
                                                    <span style="color: #0e9059">
                                                    {{$product_evaluation->productType->code}}|{{$product_evaluation->id}}|{{$product_evaluation->created_at->format('y')}} 
                                                   </span>
                                                </td>
                                                <td class="font">
                                                @foreach ($product_evaluation->organolipticReport->groupBy('id')->first() as $item)
                                                 {{  (\App\PhytoTestConducted::find($item->phyto_testconducted_id)? \App\PhytoTestConducted::find($item->phyto_testconducted_id)->name:'')}}
                                                @endforeach <br>

                                                @foreach ($product_evaluation->phytochemdataReport->groupBy('id')->first() as $item)
                                                {{ (\App\PhytoTestConducted::find($item->phyto_testconducted_id)? \App\PhytoTestConducted::find($item->phyto_testconducted_id)->name:'')}}
                                                @endforeach <br>
                                                
                                                @foreach ($product_evaluation->phytochemconstReport->groupBy('id')->first() as $item)
                                                {{  (\App\PhytoTestConducted::find($item->phyto_testconducted_id)? \App\PhytoTestConducted::find($item->phyto_testconducted_id)->name:'')}}
                                                @endforeach <br>
                                               </td>
                                                <td class="font">
                                                    {{  (\App\Admin::find($product_evaluation->phyto_analysed_by)? \App\Admin::find($product_evaluation->phyto_analysed_by)->full_name:'')}}
                                                </td>

                                                <td class="font">                               
                                                     {!! $product_evaluation->phy_hod_evaluation !!}
                                                </td>
                                                <td class="font"> 
                                                    {{$product_evaluation->phyto_dateanalysed}}
                                                </td>
                                                <td class="font">
                                                <a href="{{url('admin/phyto/hod_office/evaluate_one',['id' => $product_evaluation->id])}}"><i class="ik ik-eye f-16 mr-15 text-green"></i></a>

                                                </td>
                                                </tr>
                                            @endforeach 
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select  name="evaluation" class="form-control" id="exampleSelectGender">                                      
                                                        <option  value="1" >Complete Report</option>
                                                        {{-- <option  value="2" >Approve</option> --}}
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
                                                <button  type="submit" onclick="return confirm('Consider the following before completing report : 1.All report fields must be appropriately checked 2.Completed Reports can not be edited after submision, you would be required to see system Administrator for unavoidable complains or changes.  Thank you')" class="btn btn-primary mb-2">Complete Selected Report(s)</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div> 
                                
                                </div>
                        </div>
                
                    </div>
                </div>
        
    </div>
</div>
@endsection