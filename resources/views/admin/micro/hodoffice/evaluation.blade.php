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
                                        <form action="{{route('admin.micro.hod_office.evaluate')}}" method="post">
                                            {{ csrf_field() }}
                                        <table id="order-table" class="table table-striped table-bordered table dataTable" style="overflow-x:scroll">
                                            <thead>
                                                <tr><th>#</th>
                                                    <th>Product</th>
                                                    <th>Test conducted</th>
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
                                                   </span><br> {{$product_evaluation->name}}</td>
                                                <td class="font">
                                                    <li ><small class="">{{count($product_evaluation->loadAnalyses)}} Microbial Load Analysis</li>
                                                        @foreach ($product_evaluation->loadAnalyses->groupBy('id')->first() as $loadnalyses)
                                                        @endforeach
                                                        @if ($loadnalyses->pivot->load_analyses_id ===3)
                                                                <span class="float-right" style="color: red">/ tm count</span> 
                                                        @endif<br>
                                                        @if (count($product_evaluation->efficacyAnalyses)>0)
                                                        <li>{{count($product_evaluation->efficacyAnalyses)}} Efficacy Analysis</li>
                                                        @endif
                                                </td>
                                                @foreach($product_evaluation->microbialloadReports->groupBy('id')->first() as $report)
                                                <td class="font">{{\App\Admin::find($report->added_by_id)? \App\Admin::find($report->added_by_id)->full_name:'null'}}</td>
                                                @endforeach 
                                                <td class="font">{!! $product_evaluation->hod_evaluation !!}</td>
                                                <td class="font">
                                                {{$product_evaluation->micro_dateanalysed}}
                                                </td>
                                                <td class="font">
                                                <a href="#!"><i class="ik ik-eye f-16 mr-15 text-green" data-toggle="modal" data-target="#exampleModalLong{{$product_evaluation->id}}"></i></a>
                                                </td>
                                                </tr>

                                                <div class="modal fade" id="exampleModalLong{{$product_evaluation->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongLabel" style="display: none;" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content"  style="width: 160%">
                                                                                                                    
                                                                <div class="text-center" style="margin-top: 10px"> 
                                                                    <img src="{{asset('admin/img/logo.jpg')}}" class="" width="9%">
                                                                    <h5 class="font" style="font-size:16px"> Microbiology Department Centre for Plant Medicine Research </h5>
                                                                    <p class="card-subtitle">Microbial Analysis Report on Herbal Product</p>
                                                                </div>
                                                        
                                                        <div class="modal-body">
                                               
                                                                <div class="row" style="margin:5px; padding:15px; background:#f7f4f4">
                                                                
                                                                    <div class="col-md-3 col-6"> <strong>Product</strong>
                                                                        <br>
                                                                        <p class="text-muted">{{$product_evaluation->productType->code}}|{{$product_evaluation->id}}|{{$product_evaluation->created_at->format('y')}} <br>{{$product_evaluation->name}}</p>
                                                                         <input type="hidden" name="oneproduct_evaluation" value="{{$product_evaluation->id}}">
                                                                    </div>
                                                                    <div class="col-md-3 col-6"> <strong>Product Form</strong>
                                                                        <br>
                                                                        <p class="text-muted">{{$product_evaluation->productType->name}}</p>
                                                                    </div>
                                                                    <div class="col-md-3 col-6"> <strong>Date Received</strong>
                                                                        <br>
                                                                        @foreach (\App\productDept::where('product_id',$product_evaluation->id)->where('status',3)->where('dept_id',1)->get(); as $report)
                                                                        <p class="text-muted"> {{$report->updated_at->format('d/m/Y')}} </p>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-md-3 col-6"> <strong>Date Analysed</strong>
                                                                        <br>
                                                                        <p class="text-muted">{{$product_evaluation->micro_dateanalysed}} </p>
                                                                    </div>
                                                                </div>

                                                                {{-- loadAnalyses view --}}

                                                                <div class="card-header"><h3>Microbial <strong>Load</strong> Analysis</h3></div>

                                                                <div class="row" style="margin: 10px; padding:15px; background:#f7f4f4">
                                                                
                                                                    <div class="col-md-4 col-6"> <strong>Test Conducted</strong><br>
                                                                        <br>
                                                                        @foreach (\App\MicrobialLoadReport::where('product_id',$product_evaluation->id)->orderBy('id','ASC')->get(); as $mlreport)
                                                                            {{$mlreport->test_conducted}}<hr>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-md-4 col-6"> <strong>Result (CFU/ml)</strong><br>
                                                                        <br>
                                                                        @foreach (\App\MicrobialLoadReport::where('product_id',$product_evaluation->id)->orderBy('id','ASC')->get(); as $mlreport)
                                                                        {{$mlreport->result}}<hr>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-md-4 col-6"> <strong>Accepted Criterion (BP, 2016)</strong><br>
                                                                        <br>
                                                                        @foreach (\App\MicrobialLoadReport::where('product_id',$product_evaluation->id)->orderBy('id','ASC')->get(); as $mlreport)
                                                                        {{$mlreport->acceptance_criterion}}<hr>
                                                                        @endforeach
                                                                    </div>   
                                                            </div>

                                                                    {{-- efficacyAnalyses table --}}

                                                            <div class="card-header"><h3>Microbial<strong> Efficacy </strong>Analysis</h3></div>
                                                            <div class="row" style="margin: 10px; padding:15px; background:#f7f4f4">
                                                                
                                                                <div class="col-md-4 col-6"> <strong>Pathogens</strong><br><br>
                                                                    <br>
                                                                    @foreach (\App\MicrobialEfficacyReport::where('product_id',$product_evaluation->id)->orderBy('id','ASC')->get(); as $mereport)
                                                                        {{$mereport->pathogen}}<hr>
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-md-3 col-6"> <strong>Product <br>Inhibition Zone</strong><br>
                                                                    <br>
                                                                    @foreach (\App\MicrobialEfficacyReport::where('product_id',$product_evaluation->id)->orderBy('id','ASC')->get(); as $mereport)
                                                                        {{$mereport->pi_zone}}<hr>
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-md-3 col-6"> <strong>Ciprofloxacin Inhibition Zone</strong><br>
                                                                    <br>
                                                                    @foreach (\App\MicrobialEfficacyReport::where('product_id',$product_evaluation->id)->orderBy('id','ASC')->get(); as $mereport)
                                                                        {{$mereport->ci_zone}}<hr>
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-md-2 col-6"> <strong>Flouconazole Inhibition Zone</strong><br>
                                                                    <br>
                                                                    @foreach (\App\MicrobialEfficacyReport::where('product_id',$product_evaluation->id)->orderBy('id','ASC')->get(); as $mereport)
                                                                        {{$mereport->fi_zone}}<hr>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                            {{-- comment and conclution --}}
                                                            
    
                                                            <div class="alert alert-secondary mt-20" style="margin-bottom: 10px">
                                                                <strong><span>General Comment</span></strong><br><br>
                                                                    <P>{{$product_evaluation->micro_comment}}</P>
                                                                <strong><span>Conclution</span></strong><br><br>
                                                                <div class="input-group">
                                                                <P>{{$product_evaluation->micro_conclution}}</P>
                                                                </div> 
                                                            </div>
                                                             <input type="hidden" value="2" name="approve">

                                                            </div>
                                                            <div class="modal-footer">
                                                            <a href="{{url('admin/micro/hod_office/evaluate_one',['id' => $product_evaluation->id, 'evaluate' => 1])}}"><button type="button" class="btn btn-secondary">Withheld</button></a>

                                                            <a href="{{url('admin/micro/hod_office/evaluate_one',['id' => $product_evaluation->id, 'evaluate' => 2])}}"><button type="button" class="btn btn-primary">Approve</button></a>
                                                            </div>
                                                      
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach 
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select  name="evaluation" class="form-control" id="exampleSelectGender">
                                                        <option value="">Evaluate Report</option>                                        
                                                        <option  value="1" >Withhold</option>
                                                        <option  value="2" >Approve</option>
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
                                                <button type="submit" class="btn btn-primary mb-2">Evaluate Selected Report</button>
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